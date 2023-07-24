<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Progres_model extends CI_Model
{
	private $_table = TABEL_PROGRES;


	public function complete_data($progres)
	{
		if (!$progres) return null;

		if (!isset($progres->progres_data)) return $progres;
		$prog_obj = json_decode($progres->progres_data);

		$tmp_progres = new stdClass();
		// print_r($prog_obj);
		foreach ($prog_obj as $key => $value) {
			$tmp_stage = $this->get_stage_id($key);
			$tmp_status = $this->get_status_id($value);
			$tmp_progres->{$tmp_stage->code_name} = $tmp_status->id;
		}
		$progres->progres_data = $tmp_progres;
		return $progres;
	}

	// get all
	public function get_progreses()
	{
		$query = $this->db
			->get($this->_table);
		$progreses = $query->result();

		foreach ($progreses as $progres) {
			$progres = $this->complete_data($progres);
		}

		return $progreses;
	}

	// get by id
	public function get_progres_id($id)
	{
		$query = $this->db
			->where('id', $id)
			->get($this->_table);
		$progres = $query->row();

		if ($progres) {
			$progres = $this->complete_data($progres);
		}

		return $progres;
	}

	// get by mahasiswa
	public function get_progres_nim($nim)
	{
		$query = $this->db
			->where('mahasiswa_nim', $nim)
			->get($this->_table);
		$progres = $query->row();

		if ($progres) {
			$progres = $this->complete_data($progres);
		}

		return $progres;
	}

	// create
	public function create_init_status_nim($nim)
	{
		$this->db
			->set('mahasiswa_nim', $nim)
			->set('progres_data', json_encode($this->generate_initial_progres()));

		return $this->db->insert($this->_table);
	}


	// PROGRES GENERATOR
	public function generate_initial_progres()
	{
		$statuses = $this->get_statuses();
		$stages = $this->get_stages();
		$progres = [];
		foreach ($stages as $key => $stage) {
			$progres[$stage->id] = $statuses[0]->id;
		}
		return $progres;
	}


	// UPDATE
	public function update_stage_progres_id($progres_id, $stage_id, $status_id)
	{
		$progres = $this->get_progres_id($progres_id);
		$stages = $this->get_stages();
		$statuses = $this->get_statuses();
		$newStatus = $this->get_status_id($status_id);
		$new_progres = [];
		foreach ($stages as $key => $stage) {
			if ($stage->id > $stage_id) {
				$new_progres[$stage->id] = $statuses[0]->id;
			}
			if ($stage->id === $stage_id) {
				$new_progres[$stage->id] = $newStatus->id;
			}
			if ($stage->id < $stage_id) {
				$new_progres[$stage->id] = $statuses[count($statuses) - 1]->id;
			}
		}


		$this->db
			->set('mahasiswa_nim', $progres->mahasiswa_nim)
			->set('progres_data', json_encode($new_progres))
			->where('mahasiswa_nim', $progres->mahasiswa_nim);

		return $this->db->update($this->_table);
	}

	public function status_reinit($status_name)
	{
		$date = new DateTime('now');

		$query = $this->db
			->set('updated_at', $this->_updated_at)
			->set($status_name, PROGRES_STATUS_INIT)
			->where('id', $this->_id);

		$result = $this->db->update($this->_table);

		if (!$result) {
			return [
				'status' => false,
				'message' => 'Gagal mengupdate progres'
			];
		}
		return [
			'status' => true,
			'message' => 'Berhasil mengupdate progres'
		];
	}

	// update status proses 
	public function status_proses($stage_name)
	{
		$date = new DateTime('now');

		$this->db
			->set('updated_at', $date->format('Y-m-d H:i:s'))
			->set($stage_name, PROGRES_STATUS_PROSES)
			->where('id', $this->_id);

		return  $this->db->update($this->_table);
	}

	// update status revisi
	public function status_revisi($step_name)
	{
		$date = new DateTime('now');

		$query = $this->db
			->set('updated_at', $this->_updated_at)
			->set($step_name, PROGRES_STATUS_REVISI)
			->where('id', $this->_id);

		$result = $this->db->update($this->_table);

		if (!$result) {
			return [
				'status' => false,
				'message' => 'Gagal mengupdate progres'
			];
		}
		return [
			'status' => true,
			'message' => 'Berhasil mengupdate progres'
		];
	}

	// update status selesai
	public function status_selesai($step_name)
	{
		$date = new DateTime('now');

		$query = $this->db
			->set('updated_at', $this->_updated_at)
			->set($step_name, PROGRES_STATUS_SELESAI)
			->where('id', $this->_id);

		$result = $this->db->update($this->_table);

		if (!$result) {
			return [
				'status' => false,
				'message' => 'Gagal mengupdate progres'
			];
		}
		return [
			'status' => true,
			'message' => 'Berhasil mengupdate progres'
		];
	}

	// delete
	public function delete_progres_id($progres_id)
	{
		$this->db
			->where('id', $progres_id);
		return $this->db->delete(TABEL_PROGRES);
	}

	// [stage] [status]
	public function generate_status_report_progres_id($progres_id)
	{
		$progres = $this->get_progres_id($progres_id);
		$progres_data = $progres->progres_data;

		$statuses = $this->get_statuses();

		$status_report = "";
		$max_stage = -1;
		foreach ($progres_data as $stage_code => $status_id) {
			$stage = $this->get_stage_code_name($stage_code);
			$status = $this->get_status_id($status_id);
			if ($status->id != $statuses[0]->id) {
				if ($max_stage < $stage->id) {
					$status_report =  $status->name . " " . $stage->name;
				}
			}
		}

		return $status_report;
	}

	// progress
	public function calculate_percentage_progres_id($progres_id)
	{
		$progres = $this->get_progres_id($progres_id);
		$progres_data = $progres->progres_data;

		$sum = 0;
		foreach ($progres_data as $stage_name => $status_id) {
			$stage = $this->get_stage_code_name($stage_name);
			$status = $this->get_status_id($status_id);

			$sum += $stage->value * $status->value;
		}

		return number_format(($sum), 0);
	}

	public function get_display_color_class_status_id($status_id)
	{
		$status = $this->get_status_id($status_id);

		switch ($status->code_name) {
			case PROGRES_STATUS_INIT:
				return 'bg-light';
				break;
			case PROGRES_STATUS_PROSES:
				return 'bg-warning';
				break;
			case PROGRES_STATUS_REVISI:
				return 'bg-danger';
				break;
			case PROGRES_STATUS_SELESAI:
				return 'bg-success';
				break;
			default:
				return 'bg-light';
				break;
		}
	}

	// STATUS
	public function get_statuses()
	{
		$query = $this->db
			->get(TABEL_REGISTER_STATUS);
		return $query->result();
	}

	public function get_status_id($id_step)
	{
		$query = $this->db
			->where('id', $id_step)
			->get(TABEL_REGISTER_STATUS);
		return $query->row();
	}

	public function get_final_status()
	{

		$query = $this->db
			->order_by('value', 'DESC')
			->get(TABEL_REGISTER_STATUS);
		return $query->row();
	}

	// STAGES
	public function get_stages($field = null, $order = null)
	{
		$query = $this->db
			->order_by(is_null($field) ? 'id' : $field, is_null($order) ? 'ASC' : $order)
			->get(TABEL_REGISTER_STAGE);
		return $query->result();
	}

	public function get_stage_id($id_stage)
	{
		$query = $this->db
			->where('id', $id_stage)
			->get(TABEL_REGISTER_STAGE);
		return $query->row();
	}

	public function get_stage_code_name($code_name)
	{
		$query = $this->db
			->where('code_name', $code_name)
			->get(TABEL_REGISTER_STAGE);
		return $query->row();
	}

	// Statistics  
	public function is_stage_finished_progres_id($progres_id, $stage_id)
	{
		$progres = $this->progres_model->get_progres_id($progres_id);
		$stage = $this->progres_model->get_stage_id($stage_id);

		$progres_data = $progres->progres_data;
		if ($progres_data->{$stage->code_name} === $this->get_final_status()->id)
			return true;

		return false;
	}
}

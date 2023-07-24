<?php

use function PHPUnit\Framework\isNull;

defined('BASEPATH') or exit('No direct script access allowed');
class Mahasiswa_model extends CI_Model
{
	private $_table = TABEL_MAHASISWA;


	public function get_mahasiswas()
	{
		$query = $this->db
			->get(TABEL_MAHASISWA);
		$mahasiswas = $query->result();

		$this->load->model('dosen_model');
		foreach ($mahasiswas as $mahasiswa) {
			$mahasiswa = $this->complete_data($mahasiswa);
		}

		return $mahasiswas;
	}

	public function get_mahasiswa_nim($nim)
	{
		$query = $this->db
			->where('nim', $nim)
			->get(TABEL_MAHASISWA);

		$mahasiswa = $query->row();

		if ($mahasiswa) {
			$mahasiswa = $this->complete_data($mahasiswa);
		}

		return $mahasiswa;
	}

	public function get_mahasiswa_uid($user_id)
	{
		$query = $this->db
			->where('user_id', $user_id)
			->get(TABEL_MAHASISWA);

		$mahasiswa = $query->row();

		if ($mahasiswa) {
			$mahasiswa = $this->complete_data($mahasiswa);
		}

		return $mahasiswa;
	}

	public function get_mahasiswas_dosbing_nip($nip)
	{
		$query = $this->db
			->where('dosbing_1', $nip)
			->or_where('dosbing_2', $nip)
			->get(TABEL_MAHASISWA);
		$mahasiswas = $query->result();

		$this->load->model('dosen_model');
		foreach ($mahasiswas as $mahasiswa) {
			$mahasiswa = $this->complete_data($mahasiswa);
		}

		return $mahasiswas;
	}

	public function get_mahasiswas_dosbing1_nip($nip)
	{
		$query = $this->db
			->where('dosbing_1', $nip)
			->get(TABEL_MAHASISWA);
		$mahasiswas = $query->result();

		$this->load->model('dosen_model');
		foreach ($mahasiswas as $mahasiswa) {
			$mahasiswa = $this->complete_data($mahasiswa);
		}

		return $mahasiswas;
	}

	public function get_mahasiswas_dosbing2_nip($nip)
	{
		$query = $this->db
			->where('dosbing_2', $nip)
			->get(TABEL_MAHASISWA);
		$mahasiswas = $query->result();

		$this->load->model('dosen_model');
		foreach ($mahasiswas as $mahasiswa) {
			$mahasiswa = $this->complete_data($mahasiswa);
		}

		return $mahasiswas;
	}

	public function get_mahasiswas_stage_id($stage_id)
	{
		$tmp_mahasiswas = $this->get_mahasiswas();

		$mahasiswas = [];
		foreach ($tmp_mahasiswas as $key => $mahasiswa) {
			if ($this->progres_model->is_stage_finished_progres_id($mahasiswa->progres->id, $stage_id)) {
				array_push($mahasiswas, $mahasiswa);
			}
		}

		return $mahasiswas;
	}

	public function get_mahasiswas_dosbing_stage_id($dosbing_nip, $stage_id)
	{
		$tmp_mahasiswas = $this->get_mahasiswas_dosbing_nip($dosbing_nip);

		$mahasiswas = [];
		foreach ($tmp_mahasiswas as $key => $mahasiswa) {
			if ($this->progres_model->is_stage_finished_progres_id($mahasiswa->progres->id, $stage_id)) {
				array_push($mahasiswas, $mahasiswa);
			}
		}

		return $mahasiswas;
	}

	function complete_data($mahasiswa)
	{
		$this->load->model('progres_model');
		$mahasiswa->user = $this->user_model->get_user_id($mahasiswa->user_id);
		$mahasiswa->dosbing_1 = $this->dosen_model->get_dosen_nip($mahasiswa->dosbing_1);
		$mahasiswa->dosbing_2 = $this->dosen_model->get_dosen_nip($mahasiswa->dosbing_2);
		$mahasiswa->progres =  $this->progres_model->get_progres_nim($mahasiswa->nim);
		return $mahasiswa;
	}

	// create
	public function create($nim, $judul_ta, $dosbing_1_nip, $dosbing_2_nip, $user_id, $status = null)
	{
		$this->db->set('nim', $nim)
			->set('judul_ta', $judul_ta)
			->set('dosbing_1', $dosbing_1_nip)
			->set('dosbing_2', $dosbing_2_nip)
			->set('user_id', $user_id)
			->set('status', is_null($status) ? 'Baru' : $status);

		if (!$this->db->insert(TABEL_MAHASISWA)) {
			return null;
		}

		$this->load->model('progres_model');
		$this->progres_model->create_init_status_nim($nim);

		$mahasiswa = $this->get_mahasiswa_nim($nim);

		return $mahasiswa;
	}

	// update
	public function update_judul_nim($nim, $judul_ta)
	{
		$date = new DateTime('now');
		$this->db
			->set('updated_at', $date->format('Y-m-d H:i:s'))
			->set('judul_ta', $judul_ta)
			->where('nim', $nim);

		return $this->db->update(TABEL_MAHASISWA);
	}

	public function update_dosbing_nim($mahasiswa_nim, $dosbing_1_nip, $dosbing_2_nip)
	{
		$this->db
			->set('dosbing_1', $dosbing_1_nip)
			->set('dosbing_2', $dosbing_2_nip)
			->where('nim', $mahasiswa_nim);
		return $this->db->update(TABEL_MAHASISWA);
	}

	// delete
	public function delete_mahasiswa_nim($mahasiswa_nim)
	{
		$this->db
			->where('nim', $mahasiswa_nim);
		return $this->db->delete(TABEL_MAHASISWA);
	}

	// utils
	public function get_nim_email($email)
	{
		$email = explode('@', $email);
		if (count($email) !== 2) {
			return null;
		}

		$name_nim = $email[0];
		$name_nim = explode('.', $name_nim);
		if (count($name_nim) !== 2) {
			return null;
		}
		return $name_nim[1];
	}

	public function fields_import($index = null)
	{
		$fields = [
			'nama',
			'nim',
			'email',
			'status',
			'judul_ta',
			'dosbing_1',
			'dosbing_2'
		];

		if (is_null($index)) return $fields;

		return $fields[$index];
	}

	public function rule_profile_mahasiswa()
	{
		return [
			[
				'field' => 'txtName',
				'label' => 'Nama Lengkap',
				'rules' => 'required|trim'
			],
			[
				'field' => 'txtTa',
				'label' => 'Judul Tugas Akhir',
				'rules' => 'required|trim'
			],
			// [
			// 	'field' => 'txtNim',
			// 	'label' => 'NIM',
			// 	'rules' => 'required|trim'
			// ],
			// [
			// 	'field' => 'txtDosbing1',
			// 	'label' => 'Dosen Pembimbing 1',
			// 	'rules' => 'required|trim'
			// ],
			// [
			// 	'field' => 'txtDosbing2',
			// 	'label' => 'Dosen Pembimbing 2',
			// 	'rules' => 'required|trim'
			// ],
		];
	}
}

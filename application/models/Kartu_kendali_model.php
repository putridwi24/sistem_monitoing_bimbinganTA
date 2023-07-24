<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Kartu_kendali_model extends CI_Model
{
	private $_table = TABEL_KARTU_KENDALI;

	// get all
	public function get_kartus()
	{
		$query = $this->db
			->get($this->_table);
		$kartus = $query->result();

		if ($kartus) {
			foreach ($kartus as $kartu) {
				$kartu = $this->complete_data($kartu);
			}
		}

		return $kartus;
	}

	// get by id
	public function get_kartu_id($id)
	{
		$query = $this->db
			->where('id', $id)
			->get($this->_table);
		$kartu = $query->row();
		if ($kartu) {
			$kartu = $this->complete_data($kartu);
		}

		return $kartu;
	}

	// get by mahasiswa
	public function get_kartus_nim($nim)
	{
		$query = $this->db
			->where('mahasiswa_nim', $nim)
			->get($this->_table);
		$kartus = $query->result();

		if ($kartus) {
			foreach ($kartus as $kartu) {
				$kartu = $this->complete_data($kartu);
			}
		}

		return $kartus;
	}

	// get by dosen
	public function get_kartus_nip($nip)
	{
		$query = $this->db
			->where('dosen_nip', $nip)
			->get($this->_table);
		$kartus = $query->result();

		if ($kartus) {
			$this->load->model('mahasiswa_model');
			foreach ($kartus as $kartu) {
				$kartu = $this->complete_data($kartu);
			}
		}
		return $kartus;
	}

	// get by dosen mahasiswa
	public function get_kartus_nip_nim($dosen_nip, $mahasiswa_nim)
	{
		$query = $this->db
			->where('dosen_nip', $dosen_nip)
			->where('mahasiswa_nim', $mahasiswa_nim)
			->get($this->_table);
		$kartus = $query->result();

		if ($kartus) {
			$this->load->model('mahasiswa_model');
			foreach ($kartus as $kartu) {
				$kartu = $this->complete_data($kartu);
			}
		}
		return $kartus;
	}

	function complete_data($kartu)
	{
		$this->load->model('dosen_model');
		$this->load->model('mahasiswa_model');
		$kartu->dosen = $this->dosen_model->get_dosen_nip($kartu->dosen_nip);
		$kartu->mahasiswa = $this->mahasiswa_model->get_mahasiswa_nim($kartu->mahasiswa_nim);
		return $kartu;
	}

	// create
	public function create($nim, $nip, $kegiatan = null)
	{
		$this->load->model('dosen_model');
		$this->load->model('mahasiswa_model');

		$dosen = $this->dosen_model->get_dosen_nip($nip);
		if (!$dosen) {
			return null;
		}

		$mahasiswa = $this->mahasiswa_model->get_mahasiswa_nim($nim);
		if (!$mahasiswa) {
			return null;
		}

		$this->db
			->set('mahasiswa_nim', $nim)
			->set('dosen_nip', $nip)
			->set('kegiatan', $kegiatan);
		if (!$this->db->insert($this->_table)) {
			return null;
		}

		$kartu = $this->get_kartu_id($this->db->insert_id());
		return $kartu;
	}

	public function create_from_bimbingan($bimbingan_id)
	{
		$this->load->model('bimbingan_model');
		$bimbingan = $this->bimbingan_model->get_bimbingan_id($bimbingan_id);

		$kegiatan = "<a href='" . base_url('bimbingan/' . $bimbingan->id) . "'>Bimbingan</a>";
		return $this->create(
			$bimbingan->mahasiswa_nim,
			$bimbingan->dosen_nip,
			$kegiatan
		);
	}

	// update
	public function update_id($kartu_id, $kegiatan, $dosen_nip)
	{
		$date = new DateTime('now');

		$query = $this->db
			->set('updated_at', $date->format('Y-m-d H:i:s'))
			->set('kegiatan', $kegiatan)
			->set('dosen_nip', $dosen_nip)
			->where('id', $kartu_id);

		return $this->db->update($this->_table);
	}

	// delete
	public function delete_id($kartu_id)
	{
		$query = $this->db
			->where('id', $kartu_id);

		return  $this->db->delete($this->_table);
	}

	// sign
	public function sign_request($kartu_id)
	{
		$date = new DateTime('now');
		$this->db
			->set('request_paraf_at', $date->format('Y-m-d H:i:s'))
			->where('id', $kartu_id);
		return $this->db->update($this->_table);
	}

	public function sign_id($kartu_id, $dosen_nip)
	{
		$date = new DateTime('now');
		$query = $this->db
			->set('updated_at', $date->format('Y-m-d H:i:s'))
			->set('paraf', $dosen_nip)
			->set('diparaf_at', $date->format('Y-m-d H:i:s'))
			->where('id', $kartu_id);

		return $this->db->update($this->_table);
	}

	// rules

	public function rules_edit()
	{
		return [
			[
				'field' => 'txtKegiatan',
				'label' => 'Kegiatan',
				'rules' => 'required'
			],
		];
	}

	public function rules_create()
	{
		return [
			[
				'field' => 'txtDosenNip',
				'label' => 'Dosen',
				'rules' => 'required'
			],
			[
				'field' => 'txtKegiatan',
				'label' => 'Kegiatan',
				'rules' => 'required'
			],
		];
	}
}

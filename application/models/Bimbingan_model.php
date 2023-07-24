<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Bimbingan_model extends CI_Model
{
	private $_table = TABEL_BIMBINGAN;

	public function get_bimbingan($id)
	{
		$query = $this->db
			->where('id', $id)
			->get($this->_table);
		$bimbingan = $query->row();
		if ($bimbingan) {
			$bimbingan = $this->complete_data($bimbingan);
		}
		return $bimbingan;
	}

	public function get_bimbingan_id($id)
	{
		$query = $this->db
			->where('id', $id)
			->get($this->_table);
		$bimbingan = $query->row();
		if ($bimbingan) {
			$bimbingan = $this->complete_data($bimbingan);
		}
		return $bimbingan;
	}

	public function get_bimbingans_nim($nim)
	{
		$query = $this->db
			->where('mahasiswa_nim', $nim)
			->order_by('created_at', 'desc')
			->get($this->_table);
		$bimbingans = $query->result();

		foreach ($bimbingans as $bimbingan) {
			$bimbingan = $this->complete_data($bimbingan);
		}

		return $bimbingans;
	}

	public function get_bimbingan_finish_nim($nim)
	{
		$query = $this->db
			->where('mahasiswa_nim', $nim)
			->where('selesai_at is not null')
			->order_by('created_at', 'desc')
			->get($this->_table);
		$bimbingans = $query->result();

		foreach ($bimbingans as $bimbingan) {
			$bimbingan = $this->complete_data($bimbingan);
		}

		return $bimbingans;
	}

	public function get_bimbingan_finish_nip($nip)
	{
		$query = $this->db
			->where('dosen_nip', $nip)
			->where('selesai_at is not null')
			->order_by('created_at', 'desc')
			->get($this->_table);
		$bimbingans = $query->result();

		foreach ($bimbingans as $bimbingan) {
			$bimbingan = $this->complete_data($bimbingan);
		}

		return $bimbingans;
	}

	public function get_bimbingans_nip($nip)
	{
		$query = $this->db
			->where('dosen_nip', $nip)
			->where('disetujui_at is not null')
			->where('selesai_at is null')
			->order_by('created_at', 'desc')
			->get($this->_table);
		$bimbingans = $query->result();

		if (!$bimbingans) return $bimbingans;

		foreach ($bimbingans as $bimbingan) {
			$dosen = $this->dosen_model->get_dosen_nip($bimbingan->dosen_nip);
			$bimbingan->dosen = $dosen;
			$mahasiswa = $this->mahasiswa_model->get_mahasiswa_nim($bimbingan->mahasiswa_nim);
			$bimbingan->mahasiswa = $mahasiswa;
		}

		return $bimbingans;
	}

	public function get_bimbingans_finished_nip_nim($dosen_nip, $mahasiswa_nim)
	{
		$query = $this->db
			->where('mahasiswa_nim', $mahasiswa_nim)
			->where('dosen_nip', $dosen_nip)
			->where('selesai_at is not null')
			->order_by('created_at', 'desc')
			->get($this->_table);
		$bimbingans = $query->result();

		foreach ($bimbingans as $bimbingan) {
			$bimbingan = $this->complete_data($bimbingan);
		}

		return $bimbingans;
	}

	function complete_data($bimbingan)
	{
		$bimbingan->dosen = $this->dosen_model->get_dosen_nip($bimbingan->dosen_nip);
		$bimbingan->mahasiswa = $this->mahasiswa_model->get_mahasiswa_nim($bimbingan->mahasiswa_nim);
		return $bimbingan;
	}

	// ANTRIAN
	public function get_antrians_nip($nip)
	{
		$query = $this->db
			->where('dosen_nip', $nip)
			->where('disetujui_at is not null')
			->where('selesai_at is null')
			->where('ditolak_at is null')
			->order_by('disetujui_at', 'desc')
			->get($this->_table);
		$antrians = $query->result();

		if (!$antrians) return $antrians;

		foreach ($antrians as $antrian) {
			$antrian = $this->complete_data($antrian);
		}

		return $antrians;
	}

	public function get_antrians_nim($nim)
	{
		$query = $this->db
			->where('mahasiswa_nim', $nim)
			->where('disetujui_at is not null')
			->where('selesai_at is null')
			->where('ditolak_at is null')
			->order_by('disetujui_at', 'desc')
			->get($this->_table);
		$antrians = $query->result();

		if (!$antrians) return $antrians;

		foreach ($antrians as $antrian) {
			$antrian = $this->complete_data($antrian);
		}

		return $antrians;
	}

	public function update_keterangan_dosen_id($id_bimbingan, $keterangan_dosen)
	{
		$date = new DateTime('now');
		$this->db
			->set('updated_at', $date->format('Y-m-d H:i:s'))
			->set('keterangan_dosen', $keterangan_dosen)
			->where('id', $id_bimbingan);
		return $this->db->update($this->_table);
	}

	public function update_finish_id($id_bimbingan)
	{
		$date = new DateTime('now');
		$this->db
			->set('updated_at', $date->format('Y-m-d H:i:s'))
			->set('selesai_at', $date->format('Y-m-d H:i:s'))
			->where('id', $id_bimbingan);
		return $this->db->update($this->_table);
	}


	// PERMOHONAN
	public function get_permohonans_nip($nip)
	{
		$query = $this->db
			->where('dosen_nip', $nip)
			->order_by('created_at', 'desc')
			->get(TABEL_BIMBINGAN);

		$permohonans = $query->result();

		$this->load->model('dosen_model');
		$this->load->model('mahasiswa_model');
		foreach ($permohonans as $bimbingan) {
			$bimbingan->dosen = $this->dosen_model->get_dosen_nip($bimbingan->dosen_nip);
			$bimbingan->mahasiswa = $this->mahasiswa_model->get_mahasiswa_nim($bimbingan->mahasiswa_nim);
		}

		return $permohonans;
	}

	public function get_permohonans_nim($nim)
	{
		$query = $this->db
			->where('mahasiswa_nim', $nim)
			->where('disetujui_at is null')
			->where('selesai_at is null')
			->get($this->_table);
		$permohonans = $query->result();

		if (!$permohonans) return $permohonans;

		$this->load->model('dosen_model');
		$this->load->model('mahasiswa_model');
		foreach ($permohonans as $bimbingan) {
			$dosen = $this->dosen_model->get_dosen_nip($bimbingan->dosen_nip);
			$bimbingan->dosen = $dosen;
			$mahasiswa = $this->mahasiswa_model->get_mahasiswa_nim($bimbingan->mahasiswa_nim);
			$bimbingan->mahasiswa = $mahasiswa;
		}

		return $permohonans;
	}

	public function create_permohonan($nim, $judul_ta, $nip_dosen, $waktu, $keterangan, $file)
	{
		$this->db
			->set('mahasiswa_nim', $nim)
			->set('judul_ta', $judul_ta)
			->set('dosen_nip', $nip_dosen)
			->set('waktu_bimbingan', $waktu)
			->set('keterangan_mahasiswa', $keterangan)
			->set('file_ta', $file);

		if (!$this->db->insert($this->_table)) {
			return null;
		}

		$permohonan = $this->get_bimbingan_id($this->db->insert_id());
		return $permohonan;
	}

	public function accept($id_permohonan)
	{
		$date = new DateTime('now');
		$this->db
			->set('disetujui_at', $date->format('Y-m-d H:i:s'))
			->set('ditolak_at', null)
			->set('updated_at', $date->format('Y-m-d H:i:s'))
			->where('id', $id_permohonan);
		return $this->db->update($this->_table);
	}

	public function reject($id_permohonan, $keterangan_dosen)
	{
		$date = new DateTime('now');
		$this->db
			->set('keterangan_dosen', $keterangan_dosen)
			->set('disetujui_at', null)
			->set('ditolak_at', $date->format('Y-m-d H:i:s'))
			->set('updated_at', $date->format('Y-m-d H:i:s'))
			->where('id', $id_permohonan);
		return $this->db->update($this->_table);
	}

	public function delete($id_permohonan)
	{
		$this->db
			->where('id', $id_permohonan);
		return $this->db->delete(TABEL_BIMBINGAN);
	}

	// RULES
	public function rule_create_permohonan()
	{
		return [
			[
				'field' => 'txtJudulTa',
				'label' => 'Judul Tugas Akhir',
				'rules' => 'required|trim'
			],
			[
				'field' => 'txtDosbing',
				'label' => 'Dosen Pembimbing',
				'rules' => 'required|trim'
			],
			[
				'field' => 'txtTanggalWaktu',
				'label' => 'Tanggal dan Waktu Bimbingan',
				'rules' => 'required|trim'
			],
			[
				'field' => 'txtKeteranganMahasiswa',
				'label' => 'Keterangan Mahasiswa',
				'rules' => 'required|trim'
			],
		];
	}

	public function rule_process_bimbingan()
	{
		return [
			[
				'field' => 'txtKeteranganDosen',
				'label' => 'Keterangan Dosen',
				'rules' => 'required|trim'
			],
		];
	}

	public function rule_reject_permohonan()
	{
		return [
			[
				'field' => 'txtKeteranganDosen',
				'label' => 'Keterangan Dosen',
				'rules' => 'required|trim'
			],
		];
	}
}

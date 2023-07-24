<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bimbingan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->auth_model->role_validator();
		$this->user = $this->auth_model->get_current_user_session();
		$this->load->model('bimbingan_model');
	}

	public function index()
	{
		switch ($this->role_model->get_role_id($this->user->role)->name) {
			case 'mahasiswa':
				$mahasiswa = $this->mahasiswa_model->get_mahasiswa_uid($this->user->id);
				if (!$mahasiswa->dosbing_1) {
					$this->session->set_flashdata(['message_error' => 'Anda belum mengisi data mahasiswa!']);
					redirect('profile');
				}
				$this->index_mahasiswa();
				break;
			case 'dosen':
			case 'tim_ta':
				$this->index_dosen();
				break;
			default:
				# code...
				break;
		}
	}

	public function index_mahasiswa()
	{
		$this->auth_model->role_validator(['mahasiswa']);

		$mahasiswa = $this->mahasiswa_model->get_mahasiswa_uid($this->user->id);
		$bimbingans = $this->bimbingan_model->get_bimbingans_nim($mahasiswa->nim);

		$this->load->view('bimbingan/index_mahasiswa', [
			'bimbingans' => $bimbingans
		]);
	}

	public function index_dosen()
	{
		$this->auth_model->role_validator(['dosen', 'tim_ta']);
		$dosen = $this->dosen_model->get_dosen_uid($this->user->id);
		$bimbingans = $this->bimbingan_model->get_antrians_nip($dosen->nip);
		$selesai = $this->bimbingan_model->get_bimbingan_finish_nip($dosen->nip);

		$bimbingans = array_merge($bimbingans, $selesai);

		// echo "<pre>";
		// print_r($bimbingans);
		// echo "</pre>";
		// return;

		$this->load->view('bimbingan/index_dosen', [
			'bimbingans' => $bimbingans
		]);
	}

	// bimbingan
	public function process($id)
	{
		$this->auth_model->role_validator(['dosen', 'tim_ta']);
		if (is_null($id))
			$id = $this->input->post('idBimbingan');

		$bimbingan = $this->bimbingan_model->get_bimbingan($id);
		if (!$bimbingan) {
			$this->session->set_flashdata(['message_error' => 'Bimbingan tidak valid']);
			redirect('bimbingan');
		}

		$dosen = $this->dosen_model->get_dosen_nip($bimbingan->dosen_nip);
		$mahasiswa_bimbingan = $this->mahasiswa_model->get_mahasiswa_nim($bimbingan->mahasiswa_nim);

		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->bimbingan_model->rule_process_bimbingan());
		$txtBimbinganSelesai = $this->input->post('txtBimbinganSelesai');

		if ($this->form_validation->run()) {
			$txtKeteranganDosen = $this->input->post('txtKeteranganDosen');
			$txtBimbinganSelesai = $this->input->post('txtBimbinganSelesai');
			$txtBimbinganSelesai = !!$txtBimbinganSelesai;

			if (!$this->bimbingan_model->update_keterangan_dosen_id($bimbingan->id, $txtKeteranganDosen)) {
				$this->session->set_flashdata(['message_error' => 'Gagal menyimpan keterangan dosen']);
				redirect('bimbingan/' . $bimbingan->id . '/process');
			}

			if ($txtBimbinganSelesai) {
				if (!$this->bimbingan_model->update_finish_id($bimbingan->id)) {
					$this->session->set_flashdata(['message_error' => 'Gagal menyimpan status bimbingan']);
					redirect('bimbingan/' . $bimbingan->id . '/process');
				}

				// TAMBAHKAN KARTU KENDALI
				$this->load->model('kartu_kendali_model');
				$kartu = $this->kartu_kendali_model->create_from_bimbingan($bimbingan->id);

				// BUAT NOTIFIKASI
				$this->load->model('pengumuman_model');
				$this->pengumuman_model->create_message_bimbingan_finished($bimbingan->id, $kartu->id);
			}

			$this->session->set_flashdata([
				'message_success' => $txtBimbinganSelesai ? 'Bimbingan selesai' : 'Keterangan disimpan'
			]);
			redirect('bimbingan');
		}

		$this->load->view('bimbingan/process', [
			'bimbingan' => $bimbingan,
			'dosen' => $dosen,
			'mahasiswa' => $mahasiswa_bimbingan
		]);
	}
}

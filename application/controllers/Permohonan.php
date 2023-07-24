<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permohonan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->auth_model->role_validator();
		$this->user = $this->auth_model->get_current_user_session();
		$this->load->model('bimbingan_model');
	}

	// INDEXES
	public function index()
	{
		switch ($this->role_model->get_role_id($this->user->role)->name) {
			case 'mahasiswa':
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

	public function index_dosen()
	{
		$this->auth_model->role_validator(['dosen', 'tim_ta']);
		$dosen = $this->dosen_model->get_dosen_uid($this->user->id);
		$permohonans = $this->bimbingan_model->get_permohonans_nip($dosen->nip);

		$this->load->view('permohonan/index_dosen', [
			'permohonans' => $permohonans
		]);
	}

	public function show($id = null)
	{
		$this->auth_model->role_validator(['dosen', 'tim_ta']);
		if (is_null($id))
			$id = $this->input->post('idBimbingan');

		$permohonan = $this->bimbingan_model->get_bimbingan($id);
		if (!$permohonan) {
			$this->session->set_flashdata(['message_error' => 'Permohonan tidak valid']);
			redirect('permohonan');
		}

		$dosen = $this->dosen_model->get_dosen_nip($permohonan->dosen_nip);

		$this->load->model('mahasiswa_model');
		$mahasiswa = $this->mahasiswa_model->get_mahasiswa_nim($permohonan->mahasiswa_nim);

		$this->load->view('permohonan/show', [
			'permohonan' => $permohonan,
			'dosen' => $dosen,
			'mahasiswa' => $mahasiswa
		]);
	}

	// CREATE
	public function create()
	{
		$this->auth_model->role_validator(['mahasiswa']);
		$this->load->model('mahasiswa_model');
		$mahasiswa = $this->mahasiswa_model->get_mahasiswa_uid($this->user->id);
		if (!$mahasiswa->dosbing_1) {
			$this->session->set_flashdata(['message_error' => 'Anda belum mengisi data mahasiswa!']);
			redirect('profile');
		}

		$mahasiswa = $this->mahasiswa_model->get_mahasiswa_uid($this->user->id);

		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->bimbingan_model->rule_create_permohonan());

		if ($this->form_validation->run()) {
			$fileTa = null;
			// cek apakah ada file 
			if (!empty($_FILES['fileAttach']['name'])) {
				$this->load->helper('string');
				$config['upload_path'] = UPLOAD_PATH_BIMBINGAN;
				$config['allowed_types'] = '*';
				$config['max_size'] = 10000;
				// $config['file_name'] = random_string('alnum', 24);

				$this->load->library('upload', $config);
				if (!is_dir(UPLOAD_PATH_BIMBINGAN)) {
					mkdir(UPLOAD_PATH_BIMBINGAN);
				}
				if (!$this->upload->do_upload('fileAttach')) {
					$this->session->set_flashdata(['message_error' => $this->upload->display_errors()]);
					redirect('permohonan/create');
				}
				$fileInfo = $this->upload->data();
				$fileTa = $fileInfo['file_name'];
			}

			$txtJudulTa = $this->input->post('txtJudulTa');
			$txtDosbing = $this->input->post('txtDosbing');
			$txtTanggalWaktu = $this->input->post('txtTanggalWaktu');
			$waktu = new DateTime($txtTanggalWaktu);
			$txtKeteranganMahasiswa = $this->input->post('txtKeteranganMahasiswa');
			$this->load->model('dosen_model');
			$dosbing = $this->dosen_model->get_dosen_nip($txtDosbing);

			$this->db->trans_start();
			$permohonan = $this->bimbingan_model->create_permohonan($mahasiswa->nim, $txtJudulTa, $txtDosbing, $waktu->format('Y-m-d H:i:s'), $txtKeteranganMahasiswa, $fileTa);
			if ($permohonan) {
				$this->db->trans_complete();

				$this->load->model(['pengumuman_model', 'mailing_model']);
				$this->pengumuman_model->create_message_bimbingan_asked($permohonan->id);
				$this->mailing_model->send_mail_bimbingan_asked($permohonan->id);

				$this->session->set_flashdata('message_success', 'Berhasil membuat permohonan.');
				redirect('bimbingan');
			}

			$this->session->set_flashdata('message_error', 'Gagal membuat permohonan.');
			redirect('bimbingan');
		}

		$this->load->view('permohonan/create_mahasiswa', [
			'mahasiswa' => $mahasiswa
		]);
	}

	// UPDATE
	public function accept($id = null)
	{
		$this->auth_model->role_validator(['dosen', 'tim_ta']);
		if (is_null($id))
			$id = $this->input->post('idBimbingan');

		$bimbingan = $this->bimbingan_model->get_bimbingan($id);

		if (!$bimbingan) {
			$this->session->set_flashdata(['message_error' => 'Bimbingan tidak valid']);
			redirect('permohonan');
		}

		if (!$this->bimbingan_model->accept($bimbingan->id)) {
			$this->session->set_flashdata(['message_error' => 'Gagal menyetujui bimbingan']);
			redirect('permohonan');
		}

		$this->load->model(['pengumuman_model', 'mailing_model']);
		$this->pengumuman_model->create_message_bimbingan_accepted($bimbingan->id);
		$this->mailing_model->send_mail_bimbingan_accepted($bimbingan->id);

		$this->session->set_flashdata(['message_success' => 'Permohonan Bimbingan disetujui, lihat pada Antrian Bimbingan']);
		redirect('permohonan');
	}

	public function reject($id = null)
	{
		$this->auth_model->role_validator(['dosen', 'tim_ta']);
		if (is_null($id))
			$id = $this->input->post('idBimbingan');

		$bimbingan = $this->bimbingan_model->get_bimbingan($id);

		if (!$bimbingan) {
			$this->session->set_flashdata(['message_error' => 'Bimbingan tidak valid']);
			redirect('permohonan');
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->bimbingan_model->rule_reject_permohonan());
		if ($this->form_validation->run()) {
			$txtKeteranganDosen = $this->input->post('txtKeteranganDosen');

			if (!$this->bimbingan_model->reject($bimbingan->id, $txtKeteranganDosen)) {
				$this->session->set_flashdata(['message_error' => 'Gagal menolak permohonan bimbingan']);
				redirect('permohonan');
			}

			$this->load->model(['pengumuman_model', 'mailing_model']);
			$this->pengumuman_model->create_message_bimbingan_rejected($bimbingan->id);
			$this->mailing_model->send_mail_bimbingan_rejected($bimbingan->id);

			$this->session->set_flashdata(['message_success' => 'Permohonan bimbingan ditolak']);
			redirect('permohonan');
		}

		$this->session->set_flashdata(['message_error' => 'Tambahkan keterangan penolakan']);
		redirect('permohonan');
	}

	// DELETE
	public function delete($id = null)
	{
		$this->auth_model->role_validator(['mahasiswa']);
		if (is_null($id))
			$id = $this->input->post('idBimbingan');

		$bimbingan = $this->bimbingan_model->get_bimbingan($id);

		if (!$bimbingan) {
			$this->session->set_flashdata(['message_error' => 'Bimbingan tidak valid']);
			redirect('bimbingan');
		}

		if (!$this->bimbingan_model->delete($bimbingan->id)) {
			$this->session->set_flashdata(['message_error' => 'Gagal menghapus bimbingan']);
			redirect('bimbingan');
		}

		if (file_exists(UPLOAD_PATH_BIMBINGAN . $bimbingan->file_ta) && !is_dir(UPLOAD_PATH_BIMBINGAN . $bimbingan->file_ta)) {
			unlink(UPLOAD_PATH_BIMBINGAN . $bimbingan->file_ta);
		}

		$this->session->set_flashdata('message_success', 'Berhasil menghapus permohonan bimbingan.');
		redirect('bimbingan');
	}
}

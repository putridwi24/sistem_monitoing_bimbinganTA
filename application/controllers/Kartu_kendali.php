<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kartu_kendali extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->auth_model->role_validator();
		$this->user = $this->auth_model->get_current_user_session();
		$this->load->model('kartu_kendali_model');
	}

	// INDEX
	public function index()
	{
		switch ($this->role_model->get_role_id($this->user->role)->name) {
			case 'mahasiswa':
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
		$kartus = $this->kartu_kendali_model->get_kartus_nim($mahasiswa->nim);

		$this->load->view('kartu_kendali/index_mahasiswa', [
			'kartus' => $kartus
		]);
	}

	public function index_dosen()
	{
		$this->auth_model->role_validator(['dosen', 'tim_ta']);

		$dosen = $this->dosen_model->get_dosen_uid($this->user->id);
		$kartus = $this->kartu_kendali_model->get_kartus_nip($dosen->nip);

		$this->load->view('kartu_kendali/index_dosen', [
			'kartus' => $kartus
		]);
	}

	// SHOW
	public function show($kartu_id)
	{
		switch ($this->role_model->get_role_id($this->user->role)->name) {
			case 'mahasiswa':
				$this->edit_mahasiswa($kartu_id);
				break;
			case 'dosen':
			case 'tim_ta':
				redirect('kartu_kendali');
				// $this->show_dosen($kartu_id);
				break;
			default:
				# code...
				break;
		}
	}

	public function show_dosen($kartu_id)
	{
		$this->auth_model->role_validator(['mahasiswa']);

		$mahasiswa = $this->mahasiswa_model->get_mahasiswa_uid($this->user->id);
		$kartu = $this->kartu_kendali_model->get_kartu_id($kartu_id);

		if (!$kartu) {
			$this->session->set_flashdata(['message_error' => 'Kartu kendali tidak valid']);
			redirect('kartu_kendali');
		}

		if ($kartu->mahasiswa->nim !== $mahasiswa->nim) {
			$this->session->set_flashdata(['message_error' => 'Kartu kendali tidak valid']);
			redirect('kartu_kendali');
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->kartu_kendali_model->rules_edit());

		if ($this->form_validation->run()) {
			$txtKegiatan = $this->input->post('txtKegiatan');
			if (!$this->kartu_kendali_model->update_id($kartu->id, $txtKegiatan)) {
				$this->session->set_flashdata(['message_success' => 'Gagal memperbarui kartu kendali.']);
				redirect('kartu_kendali/' . $kartu_id);
			}
			$this->session->set_flashdata(['message_success' => 'Berhasil memperbarui kartu kendali.']);
			redirect('kartu_kendali/' . $kartu_id);
		}

		$this->load->view('kartu_kendali/edit_mahasiswa', [
			'kartu' => $kartu
		]);
	}

	// CREATE
	public function create()
	{
		$this->auth_model->role_validator(['mahasiswa']);

		$mahasiswa = $this->mahasiswa_model->get_mahasiswa_uid($this->user->id);

		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->kartu_kendali_model->rules_create());

		if ($this->form_validation->run()) {
			$txtKegiatan = $this->input->post('txtKegiatan');
			$txtDosenNip = $this->input->post('txtDosenNip');

			$dosen = $this->dosen_model->get_dosen_nip($txtDosenNip);

			if (!$dosen) {
				$this->session->set_flashdata(['message_success' => 'Gagal membuat kartu kendali.']);
				redirect('kartu_kendali');
			}

			if (!$this->kartu_kendali_model->create($mahasiswa->nim, $dosen->nip, $txtKegiatan)) {
			}

			$this->session->set_flashdata(['message_success' => 'Berhasil membuat kartu kendali.']);
			redirect('kartu_kendali');
		}

		$this->load->view('kartu_kendali/create_mahasiswa', [
			'mahasiswa' => $mahasiswa
		]);
	}

	// EDIT  
	public function edit_mahasiswa($kartu_id = null)
	{
		$this->auth_model->role_validator(['mahasiswa']);

		$mahasiswa = $this->mahasiswa_model->get_mahasiswa_uid($this->user->id);
		$kartu = $this->kartu_kendali_model->get_kartu_id($kartu_id);

		if (!$kartu) {
			$this->session->set_flashdata(['message_error' => 'Kartu kendali tidak valid']);
			redirect('kartu_kendali');
		}

		if ($kartu->mahasiswa->nim !== $mahasiswa->nim) {
			$this->session->set_flashdata(['message_error' => 'Kartu kendali tidak valid']);
			redirect('kartu_kendali');
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->kartu_kendali_model->rules_edit());

		if ($this->form_validation->run()) {
			$txtKegiatan = $this->input->post('txtKegiatan');
			$txtDosenNip = $this->input->post('txtDosenNip');
			if (!$this->kartu_kendali_model->update_id($kartu->id, $txtKegiatan, $txtDosenNip)) {
				$this->session->set_flashdata(['message_success' => 'Gagal memperbarui kartu kendali.']);
				redirect('kartu_kendali/' . $kartu_id);
			}
			$this->session->set_flashdata(['message_success' => 'Berhasil memperbarui kartu kendali.']);
			redirect('kartu_kendali/' . $kartu_id);
		}

		$this->load->view('kartu_kendali/edit_mahasiswa', [
			'kartu' => $kartu
		]);
	}

	// UTILS
	public function sign_request($kartuId = null)
	{
		$this->auth_model->role_validator(['mahasiswa']);
		$mahasiswa = $this->mahasiswa_model->get_mahasiswa_uid($this->user->id);

		if (is_null($kartuId)) {
			$kartuId = $this->input->post('kartuId');
		}

		$kartu = $this->kartu_kendali_model->get_kartu_id($kartuId);
		if (!$kartu) {
			$this->session->set_flashdata(['message_error' => 'Kartu kendali tidak valid']);
			redirect('kartu_kendali');
		}

		if ($kartu->mahasiswa->nim !== $mahasiswa->nim) {
			$this->session->set_flashdata(['message_error' => 'Kartu kendali tidak valid']);
			redirect('kartu_kendali');
		}

		if (!$this->kartu_kendali_model->sign_request($kartu->id)) {
			$this->session->set_flashdata(['message_error' => 'Gagal meminta paraf.']);
			redirect('kartu_kendali');
		}

		$this->pengumuman_model->create_message_kartu_sign_request($kartu->id);

		$this->session->set_flashdata(['message_success' => 'Berhasil meminta paraf.']);
		redirect('kartu_kendali');
	}

	public function sign($id = null)
	{
		$this->auth_model->role_validator(['dosen', 'tim_ta']);
		$dosen = $this->dosen_model->get_dosen_uid($this->user->id);

		if (is_null($id))
			$id = $this->input->post('idKartu');

		$kartu = $this->kartu_kendali_model->get_kartu_id($id);

		if (!$kartu) {
			$this->session->set_flashdata(['message_error' => 'Kartu kendali tidak valid']);
			redirect('kartu_kendali');
		}

		if (!$this->kartu_kendali_model->sign_id($kartu->id, $dosen->nip)) {
			$this->session->set_flashdata(['message_error' => 'Gagal memberi paraf']);
			redirect('kartu_kendali');
		}

		$this->load->model('kartu_kendali_model');
		$this->pengumuman_model->create_message_kartu_signed($kartu->id);

		$this->session->set_flashdata(['message_success' => 'Berhasil memberi paraf']);
		redirect('kartu_kendali');
	}
}

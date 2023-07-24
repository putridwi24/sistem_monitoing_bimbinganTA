<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Timeline extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->auth_model->role_validator();
		$this->user = $this->auth_model->get_current_user_session();
		$this->load->model('progres_model');
	}
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

	public function index_dosen()
	{
		$this->auth_model->role_validator(['dosen', 'tim_ta']);
		$dosen = $this->dosen_model->get_dosen_uid($this->user->id);
		$this->load->model('mahasiswa_model');
		$this->load->model('progres_model');

		$mahasiswas = $this->mahasiswa_model->get_mahasiswas_dosbing_nip($dosen->nip);
		$this->load->view('timeline/index_dosen', [
			'mahasiswas' => $mahasiswas,
		]);
	}

	public function index_mahasiswa()
	{
		$this->auth_model->role_validator(['mahasiswa']);
		$this->load->model(['progres_model', 'mahasiswa_model']);
		$mahasiswa = $this->mahasiswa_model->get_mahasiswa_uid($this->user->id);
		$progres = $this->progres_model->get_progres_nim($mahasiswa->nim);

		$this->progres_model->calculate_percentage_progres_id($progres->id);
		// return;
		$this->load->view('timeline/index_mahasiswa', [
			'mahasiswa' => $mahasiswa,
			'progres' => $progres
		]);
	}

	public function show($id)
	{
		$this->auth_model->role_validator(['dosen', 'tim_ta']);
		$this->load->model('progres_model');

		$progres = $this->progres_model->get_progres_id($id);
		if (!$progres) {
			$this->session->set_flashdata(['message_error' => 'Timeline tidak valid']);
			redirect('timeline');
		}

		$mahasiswa = $this->mahasiswa_model->get_mahasiswa_nim($progres->mahasiswa_nim);
		$this->progres_model->calculate_percentage_progres_id($progres->id);

		$this->load->view('timeline/show_dosen', [
			'progres' => $progres,
			'mahasiswa' => $mahasiswa
		]);
	}

	public function update($id = null)
	{
		$this->auth_model->role_validator(['dosen', 'tim_ta']);
		if (is_null($id))
			$id = $this->input->post('txtProgresId');

		$txtStatusId = $this->input->post('txtStatusId');
		$txtStageId = $this->input->post('txtStageId');

		$newStatus = $this->progres_model->get_status_id($txtStatusId);
		if (!$newStatus) {
			$this->session->set_flashdata(['message_error' => 'Input tidak valid']);
			redirect('timeline');
		}

		$stage = $this->progres_model->get_stage_id($txtStageId);
		if (!$stage) {
			$this->session->set_flashdata(['message_error' => 'Input tidak valid']);
			redirect('timeline');
		}

		$progres = $this->progres_model->get_progres_id($id);
		if (!$progres) {
			$this->session->set_flashdata(['message_error' => 'Timeline tidak valid']);
			redirect('timeline');
		}

		if (!$this->progres_model->update_stage_progres_id($progres->id, $stage->id, $newStatus->id)) {
			// return;
			$this->session->set_flashdata(['message_error' => 'Gagal mengupdate status timeline']);
			redirect('timeline');
		}
		// return;

		$this->session->set_flashdata(['message_success' => 'Berhasil mengupdate status timeline']);
		redirect('timeline/' . $progres->id);
	}
}

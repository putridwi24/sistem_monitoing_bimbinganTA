<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Beranda extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->auth_model->role_validator();
		$this->user = $this->auth_model->get_current_user_session();
	}

	public function index()
	{
		switch ($this->role_model->get_role_id($this->user->role)->name) {
			case 'mahasiswa':
				$this->mahasiswa();
				break;
			case 'dosen':
			case 'tim_ta':
				$this->dosen();
				break;
			case 'tim_ta':
				// redirect('beranda/tim_ta');
				break;
			default:
				# code...
				break;
		}
	}

	public function dosen()
	{
		$this->auth_model->role_validator(['dosen', 'tim_ta']);

		$this->load->model('dosen_model');

		$dosen = $this->dosen_model->get_dosen_uid($this->user->id);
		if (!$dosen) {
			$this->session->set_flashdata('message_error', 'Silakan melengkapi data dosen');
			redirect('profile');
		}

		$mahasiswas = $this->mahasiswa_model->get_mahasiswas_dosbing_nip($dosen->nip);
		$stages = $this->progres_model->get_stages('id', 'ASC');
		foreach ($stages as $key => $stage) {
			$stage->mahasiswas = $this->mahasiswa_model->get_mahasiswas_dosbing_stage_id($dosen->nip, $stage->id);
		}

		$this->load->view('dosen/beranda', [
			'mahasiswas' => $mahasiswas,
			'stages' => $stages
		]);
	}

	public function tim_ta()
	{
		$this->auth_model->role_validator(['tim_ta']);
		$data = new stdClass();

		$dosens = $this->dosen_model->get_dosens();

		$mahasiswas = $this->mahasiswa_model->get_mahasiswas();

		$stage = $this->progres_model->get_stage_code_name('sempro');
		$mahasiswa_sempros = $this->mahasiswa_model->get_mahasiswas_stage_id($stage->id);

		$stage = $this->progres_model->get_stage_code_name('semhas');
		$mahasiswa_sidangs = $this->mahasiswa_model->get_mahasiswas_stage_id($stage->id);

		// return;
		$this->load->view('tim_ta/beranda', [
			'dosbings' => $dosens,
			'mahasiswas' => $mahasiswas,
			'sempros' => $mahasiswa_sempros,
			'sidangs' => $mahasiswa_sidangs
		]);
	}

	public function mahasiswa()
	{
		$this->auth_model->role_validator(['mahasiswa']);
		$this->load->model('mahasiswa_model');
		$mahasiswa = $this->mahasiswa_model->get_mahasiswa_uid($this->user->id);

		if (!$mahasiswa) {
			$this->session->set_flashdata(['message_error' => 'Anda belum mengisi data mahasiswa!']);
			redirect('profil');
		}

		$this->load->model('bimbingan_model');
		$bimbingans = $this->bimbingan_model->get_bimbingans_nim($mahasiswa->nim);

		$this->load->model('progres_model');

		echo "<pre>";
		$progres = $this->progres_model->get_progres_nim($mahasiswa->nim);
		echo "</pre>";
		// return;

		$this->load->view('mahasiswa/beranda', [
			'bimbingans' => $bimbingans,
			'progres' => $progres
		]);
	}
}

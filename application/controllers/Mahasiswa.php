<?php

use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv as WriterCsv;

defined('BASEPATH') or exit('No direct script access allowed');

class Mahasiswa extends CI_Controller
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
				redirect('beranda/mahasiswa');
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

	public function index_tim_ta()
	{
		$this->auth_model->role_validator(['tim_ta']);
		$mahasiswas = $this->mahasiswa_model->get_mahasiswas();

		$this->load->view('mahasiswa/index_tim_ta', [
			'mahasiswas' => $mahasiswas
		]);
	}

	public function index_dosen()
	{
		$this->auth_model->role_validator(['tim_ta', 'dosen']);
		$dosen = $this->dosen_model->get_dosen_uid($this->user->id);

		$mahasiswas = $this->mahasiswa_model->get_mahasiswas_dosbing_nip($dosen->nip);

		$this->load->view('mahasiswa/index_dosen', [
			'mahasiswas' => $mahasiswas
		]);
	}

	public function show($nim)
	{
		switch ($this->role_model->get_role_id($this->user->role)->name) {
			case 'mahasiswa':
				redirect('beranda/mahasiswa');
				break;
			case 'dosen':
				redirect('beranda/dosen');
				break;
			case 'tim_ta':
				$this->show_tim_ta($nim);
				break;
			default:
				# code...
				break;
		}
	}

	public function show_tim_ta($nim)
	{
		$this->auth_model->role_validator(['tim_ta']);
		$mahasiswa = $this->mahasiswa_model->get_mahasiswa_nim($nim);

		$this->load->model('bimbingan_model');
		$bimbingans = $this->bimbingan_model->get_bimbingan_finish_nim($mahasiswa->nim);

		$dosens = $this->dosen_model->get_dosens();
		$this->load->view('mahasiswa/show_tim_ta', [
			'mahasiswa' => $mahasiswa,
			'dosens' => $dosens,
			'bimbingan_historys' => $bimbingans
		]);
	}

	// CREATE
	public function import()
	{
		$this->auth_model->role_validator(['tim_ta']);

		$config['upload_path'] = UPLOAD_PATH_TMP;
		$config['allowed_types'] = 'xlsx|csv';
		$config['max_size'] = 10000;
		$config['file_name'] = 'tmp_file_mahasiswa';
		$this->load->library('upload', $config);

		// cek apakah direktori sudah ada
		if (!is_dir(UPLOAD_PATH_TMP)) {
			mkdir(UPLOAD_PATH_TMP);
		}

		// cek apakah file sudah ada
		if (file_exists(UPLOAD_PATH_TMP . 'tmp_file_mahasiswa.xlsx')) {
			unlink(UPLOAD_PATH_TMP . 'tmp_file_mahasiswa.xlsx');
		}
		if (file_exists(UPLOAD_PATH_TMP . 'tmp_file_mahasiswa.csv')) {
			unlink(UPLOAD_PATH_TMP . 'tmp_file_mahasiswa.csv');
		}

		// lakukan upload
		if (!$this->upload->do_upload('file_mahasiswa')) {
			// jika upload gagal
			echo $this->upload->display_errors();
			http_response_code(500);
			return;
		}

		// proses jika upload berhasil
		$file = $this->upload->data();
		if ($file['file_ext'] === '.csv') {
			$reader = new Csv();
		} else if ($file['file_ext'] === '.xlsx') {
			$reader = new Xlsx();
		}
		$spreadsheet = $reader->load(UPLOAD_PATH_TMP . $file['file_name']);
		$data_raw = $spreadsheet->getActiveSheet()->toArray();

		// periksa format data
		$head = $data_raw[0];
		foreach ($head as $key => $value) {
			if ($value !== $this->mahasiswa_model->fields_import($key)) {
				echo 'Format data tidak benar indeks: ' . $key . ' | file: ' . $value . ' | format ' . $this->mahasiswa_model->fields_import($key);
				print_r($head);
				http_response_code(500);
				return;
			}
		}

		// pindahkan data ke array
		$fields = $this->mahasiswa_model->fields_import();
		$mahasiswa_new = [];
		foreach ($data_raw as $key => $data) {
			if ($key > 0) {
				foreach ($fields as $key => $value) {
					$mahasiswa_tmp[$value] = $data[$key];
				}
				array_push($mahasiswa_new, $mahasiswa_tmp);
			}
		}

		// daftarkan mahasiswa
		$status = [];
		foreach ($mahasiswa_new as $key => $mahasiswa) {
			// periksa apakah mahasiswa sudah terdaftar
			if ($this->mahasiswa_model->get_mahasiswa_nim($mahasiswa['nim'])) {
				$status_tmp = [
					'status' => 0,
					'name' => $mahasiswa['nama'],
					'message' => 'Mahasiswa sudah terdaftar'
				];
				array_push($status, $status_tmp);
				continue;
			}
			$dosen_1 = $this->dosen_model->get_dosen_code_name($mahasiswa['dosbing_1']);
			if (!$dosen_1) {
				$status_tmp = [
					'status' => 0,
					'name' => $mahasiswa['nama'],
					'message' => 'Dosen dengan kode nama ' . $mahasiswa['dosbing_1'] . ' tidak ditemukan'
				];
				array_push($status, $status_tmp);
				continue;
			}
			$dosen_2 = $this->dosen_model->get_dosen_code_name($mahasiswa['dosbing_2']);
			if (!$dosen_2) {
				$status_tmp = [
					'status' => 0,
					'name' => $mahasiswa['nama'],
					'message' => 'Dosen dengan kode nama ' . $mahasiswa['dosbing_2'] . ' tidak ditemukan'
				];
				array_push($status, $status_tmp);
				continue;
			}

			$this->db->trans_start();
			// buat user baru
			$user_new = $this->user_model->create(
				$mahasiswa['nama'],
				$mahasiswa['email'],
				$this->role_model->get_role_name('mahasiswa')->id,
				null
			);

			if (!$user_new) {
				$status_tmp = [
					'status' => 0,
					'name' => $mahasiswa['nama'],
					'message' => 'Tidak dapat membuat user baru'
				];
				array_push($status, $status_tmp);
				continue;
			}

			// buat mahasiswa baru
			$new_mahasiswa = $this->mahasiswa_model->create(
				$mahasiswa['nim'],
				$mahasiswa['judul_ta'],
				$dosen_1->nip,
				$dosen_2->nip,
				$user_new->id,
				$mahasiswa['status']
			);

			if (!$new_mahasiswa) {
				$status_tmp = [
					'status' => 0,
					'name' => $mahasiswa['nama'],
					'message' => 'Tidak dapat membuat mahasiswa baru'
				];
				array_push($status, $status_tmp);
				continue;
			}

			$status_tmp = [
				'status' => 1,
				'name' => $mahasiswa['nama'],
				'message' => 'Berhasil ditambahkan'
			];
			array_push($status, $status_tmp);

			$this->db->trans_complete();

			$this->auth_model->create_send_password_reset($user_new->email);
		}

		echo json_encode([
			'status' => 200,
			'message' => 'Berhasil memproses data',
			'data' => $status
		]);
		http_response_code(200);
		return;
	}

	public function import_file_template()
	{
		$this->auth_model->role_validator(['tim_ta']);
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$fields = $this->mahasiswa_model->fields_import();
		foreach ($fields as $key => $value) {
			$sheet->setCellValue([$key + 1, 1], $value);
		}
		$writer = new WriterCsv($spreadsheet);
		$fileName = 'format_data_mahasiswa.csv';

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
		$writer->save('php://output');
	}

	// UPDATE
	public function update_dosbing($mahasiswaNim)
	{
		$this->auth_model->role_validator(['tim_ta']);

		$dosbing1Nip = $this->input->post('dosbing1Nip');
		$dosbing2Nip = $this->input->post('dosbing2Nip');

		$mahasiswa = $this->mahasiswa_model->get_mahasiswa_nim($mahasiswaNim);
		if (!$mahasiswa) {
			$this->session->set_flashdata(['message_error' => 'Mahasiswa tidak valid.']);
			redirect('mahasiswa/' . $mahasiswaNim);
		}

		$dosbing1 = $this->dosen_model->get_dosen_nip($dosbing1Nip);
		if (!$dosbing1) {
			$this->session->set_flashdata(['message_error' => 'Gagal mengganti dosen pembimbing. Dosen tidak valid.']);
			redirect('mahasiswa/' . $mahasiswaNim);
		}

		$dosbing2 = $this->dosen_model->get_dosen_nip($dosbing2Nip);
		if (!$dosbing2) {
			$this->session->set_flashdata(['message_error' => 'Gagal mengganti dosen pembimbing. Dosen tidak valid.']);
			redirect('mahasiswa/' . $mahasiswaNim);
		}

		if (!$this->mahasiswa_model->update_dosbing_nim($mahasiswa->nim, $dosbing1->nip, $dosbing2->nip)) {
			$this->session->set_flashdata(['message_error' => 'Gagal mengganti dosen pembimbing.']);
			redirect('mahasiswa/' . $mahasiswaNim);
		}

		$this->session->set_flashdata(['message_success' => 'Berhasil mengganti dosen pembimbing.']);
		redirect('mahasiswa/' . $mahasiswaNim);
	}

	// DELETE
	public function delete($mahasiswaNim)
	{
		$this->auth_model->role_validator(['tim_ta']);

		$txtAdminPassword = $this->input->post('txtAdminPassword');

		$admin = $this->user;
		if (!password_verify($txtAdminPassword, $admin->password)) {
			$this->session->set_flashdata(['message_error' => 'Gagal menghapus mahasiswa. Password admin salah!']);
			redirect('mahasiswa/' . $mahasiswaNim);
		}

		$mahasiswa = $this->mahasiswa_model->get_mahasiswa_nim($mahasiswaNim);
		if (!$mahasiswa) {
			$this->session->set_flashdata(['message_error' => 'Gagal menghapus mahasiswa. Mahasiswa tidak valid!']);
			redirect('mahasiswa/' . $mahasiswaNim);
		}

		$this->load->model('bimbingan_model');
		$permohonans = $this->bimbingan_model->get_permohonans_nim($mahasiswa->nim);
		if ($permohonans) {
			$this->session->set_flashdata(['message_error' => 'Gagal menghapus mahasiswa. Mahasiswa memiliki permohonan bimbingan!']);
			redirect('mahasiswa/' . $mahasiswaNim);
		}
		$bimbingans = $this->bimbingan_model->get_bimbingans_nim($mahasiswa->nim);
		if ($bimbingans) {
			$this->session->set_flashdata(['message_error' => 'Gagal menghapus mahasiswa. Mahasiswa memiliki bimbingan!']);
			redirect('mahasiswa/' . $mahasiswaNim);
		}

		$this->load->model('kartu_kendali_model');
		$kartus = $this->kartu_kendali_model->get_kartus_nim($mahasiswa->nim);
		if ($kartus) {
			$this->session->set_flashdata(['message_error' => 'Gagal menghapus mahasiswa. Mahasiswa memiliki kartu kendali!']);
			redirect('mahasiswa/' . $mahasiswaNim);
		}


		$this->db->trans_start();
		$this->load->model('progres_model');
		$progres = $this->progres_model->get_progres_nim($mahasiswa->nim);
		if ($progres)
			if (!$this->progres_model->delete_progres_id($progres->id)) {
				$this->session->set_flashdata(['message_error' => 'Gagal menghapus mahasiswa. Tidak dapat menghapus progres!']);
				redirect('mahasiswa/all');
			}

		$pengumumans = $this->pengumuman_model->get_pengumuman_creator_id($mahasiswa->user->id);
		foreach ($pengumumans as $key => $pengumuman) {
			if (!$this->pengumuman_model->delete($pengumuman->id)) {
				return;
			}
		}

		if (!$this->mahasiswa_model->delete_mahasiswa_nim($mahasiswaNim)) {
			$this->session->set_flashdata(['message_error' => 'Gagal menghapus mahasiswa.']);
			redirect('mahasiswa/' . $mahasiswaNim);
		}

		if (!$this->user_model->delete($mahasiswa->user->id)) {
			$this->session->set_flashdata(['message_error' => 'Gagal menghapus mahasiswa.']);
			redirect('mahasiswa/' . $mahasiswaNim);
		}
		$this->db->trans_complete();

		$this->session->set_flashdata(['message_success' => 'Berhasil menghapus mahasiswa.']);
		redirect('mahasiswa/all');
	}
}

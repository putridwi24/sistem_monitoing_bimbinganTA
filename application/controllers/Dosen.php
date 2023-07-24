<?php

use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv as WriterCsv;

defined('BASEPATH') or exit('No direct script access allowed');

class Dosen extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->auth_model->role_validator();
		$this->user = $this->auth_model->get_current_user_session();
		$this->load->model('dosen_model');
	}

	public function index()
	{
		$this->auth_model->role_validator(['tim_ta']);

		$dosens = $this->dosen_model->get_dosens();

		$this->load->view('dosen/index', [
			'dosens' => $dosens
		]);
	}

	public function show($nip)
	{
		$this->auth_model->role_validator(['tim_ta']);

		$dosen = $this->dosen_model->get_dosen_nip($nip);
		if (!$dosen) {
			$this->session->set_flashdata(['message_error' => 'Dosen tidak valid']);
			redirect('dosen');
		}

		$bimbingan1 = $this->mahasiswa_model->get_mahasiswas_dosbing1_nip($dosen->nip);
		$bimbingan2 = $this->mahasiswa_model->get_mahasiswas_dosbing2_nip($dosen->nip);

		$this->load->model('bimbingan_model');
		foreach ($bimbingan1 as $key => $mahasiswa) {
			$mahasiswa->bimbingans_dosen = $this->bimbingan_model->get_bimbingans_finished_nip_nim($dosen->nip, $mahasiswa->nim);
			$mahasiswa->bimbingans = $this->bimbingan_model->get_bimbingan_finish_nim($mahasiswa->nim);
		}
		foreach ($bimbingan2 as $key => $mahasiswa) {
			$mahasiswa->bimbingans_dosen = $this->bimbingan_model->get_bimbingans_finished_nip_nim($dosen->nip, $mahasiswa->nim);
			$mahasiswa->bimbingans = $this->bimbingan_model->get_bimbingan_finish_nim($mahasiswa->nim);
		}

		$this->load->model('kartu_kendali_model');
		foreach ($bimbingan1 as $key => $mahasiswa) {
			$mahasiswa->kartus_dosen = $this->kartu_kendali_model->get_kartus_nip_nim($dosen->nip, $mahasiswa->nim);
			$mahasiswa->kartus = $this->kartu_kendali_model->get_kartus_nim($mahasiswa->nim);
		}
		foreach ($bimbingan2 as $key => $mahasiswa) {
			$mahasiswa->kartus_dosen = $this->kartu_kendali_model->get_kartus_nip_nim($dosen->nip, $mahasiswa->nim);
			$mahasiswa->kartus = $this->kartu_kendali_model->get_kartus_nim($mahasiswa->nim);
		}

		$this->load->view('dosen/show', [
			'dosen' => $dosen,
			'bimbingan1' => $bimbingan1,
			'bimbingan2' => $bimbingan2
		]);
	}

	public function import()
	{
		$this->auth_model->role_validator(['tim_ta']);

		$config['upload_path'] = UPLOAD_PATH_TMP;
		$config['allowed_types'] = 'xlsx|csv';
		$config['max_size'] = 10000;
		$config['file_name'] = 'tmp_file_dosen';
		$this->load->library('upload', $config);

		// cek apakah direktori sudah ada
		if (!is_dir(UPLOAD_PATH_TMP)) {
			mkdir(UPLOAD_PATH_TMP);
		}

		// cek apakah file sudah ada
		if (file_exists(UPLOAD_PATH_TMP . 'tmp_file_dosen.xlsx')) {
			unlink(UPLOAD_PATH_TMP . 'tmp_file_dosen.xlsx');
		}
		if (file_exists(UPLOAD_PATH_TMP . 'tmp_file_dosen.csv')) {
			unlink(UPLOAD_PATH_TMP . 'tmp_file_dosen.csv');
		}

		// lakukan upload
		if (!$this->upload->do_upload('file_dosen')) {
			// jika upload gagal
			echo json_encode([
				'status' => 500,
				'message' => $this->upload->display_errors()
			]);
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
		$fields = $this->dosen_model->fields_import();
		foreach ($fields as $key => $value) {
			if ($value !== $data_raw[0][$key]) {
				echo "Format data tidak benar. ";
				echo 'Kolom:' . $key . ' | file: ' . $data_raw[0][$key] . '| seharusnya: ' . $value;
				http_response_code(422);
				return;
			}
		}

		// pindahkan data ke array
		$dosen_new = [];
		foreach ($data_raw as $key => $data) {
			if ($key > 0) {
				foreach ($fields as $key => $field) {
					$dosen_tmp[$field] = $data[$key];
				}
				array_push($dosen_new, $dosen_tmp);
			}
		}

		// daftarkan dosen
		$status = [];
		foreach ($dosen_new as $key => $dosen) {
			// periksa data
			if (!preg_match("/^\\d+$/", $dosen['nip'])) {
				$status_tmp = [
					'status' => 'gagal',
					'name' => $dosen['nama'],
					'message' => 'NIP tidak benar.'
				];
				array_push($status, $status_tmp);
				continue;
			}
			if (!preg_match("/^\\d+$/", $dosen['nip'])) {
				$status_tmp = [
					'status' => 'gagal',
					'name' => $dosen['nama'],
					'message' => 'NIP tidak benar.'
				];
				array_push($status, $status_tmp);
				continue;
			}
			if (!$this->user_model->email_check_domain($dosen['email'])) {
				$status_tmp = [
					'status' => 'gagal',
					'name' => $dosen['nama'],
					'message' => 'Email tidak benar.'
				];
				array_push($status, $status_tmp);
				continue;
			}

			// periksa apakah dosen sudah terdaftar
			if ($this->dosen_model->get_dosen_code_name($dosen['code_name'])) {
				$status_tmp = [
					'status' => 'gagal',
					'name' => $dosen['nama'],
					'message' => 'Kode nama sudah terdaftar'
				];
				array_push($status, $status_tmp);
				continue;
			}

			if ($this->dosen_model->get_dosen_nip($dosen['nip'])) {
				$status_tmp = [
					'status' => 'gagal',
					'name' => $dosen['nama'],
					'message' => 'NIP sudah terdaftar'
				];
				array_push($status, $status_tmp);
				continue;
			}

			$this->db->trans_start();
			// buat user baru
			$user_new = $this->user_model->create(
				$dosen['nama'],
				$dosen['email'],
				$this->role_model->get_role_name('dosen')->id,
				null
			);

			if (!$user_new) {
				$status_tmp = [
					'status' => 'gagal',
					'name' => $dosen['nama'],
					'message' => 'Tidak dapat membuat user baru'
				];
				array_push($status, $status_tmp);
				continue;
			}

			// buat dosen baru
			$dosen_new = $this->dosen_model->create(
				$dosen['nip'],
				$dosen['code_name'],
				$user_new->id
			);

			if (!$dosen_new) {
				$status_tmp = [
					'status' => 'gagal',
					'name' => $dosen['nama'],
					'message' => 'Tidak dapat membuat dosen baru'
				];
				array_push($status, $status_tmp);
				continue;
			}
			$status_tmp = [
				'status' => 1,
				'name' => $dosen['nama'],
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
		$fields = $this->dosen_model->fields_import();
		foreach ($fields as $key => $value) {
			$sheet->setCellValue([$key + 1, 1], $value);
		}
		$writer = new WriterCsv($spreadsheet);
		$fileName = 'format_data_dosen.csv';

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
		$writer->save('php://output');
	}

	// DELETE
	public function delete($nip)
	{
		$this->auth_model->role_validator(['tim_ta']);

		$txtAdminPassword = $this->input->post('txtAdminPassword');

		$admin = $this->user;
		if (!password_verify($txtAdminPassword, $admin->password)) {
			$this->session->set_flashdata(['message_error' => 'Tidak dapat menghapus dosen. Password admin salah!']);
			redirect('dosen/' . $nip);
		}

		$dosen = $this->dosen_model->get_dosen_nip($nip);
		if (!$dosen) {
			$this->session->set_flashdata(['message_error' => 'Gagal menghapus dosen. Dosen tidak valid!']);
			redirect('dosen/' . $dosen->nip);
		}

		$mahasiswas = $this->mahasiswa_model->get_mahasiswas_dosbing_nip($dosen->nip);
		if ($mahasiswas) {
			$this->session->set_flashdata(['message_error' => 'Gagal menghapus dosen. Dosen terdaftar sebagai dosen pembimbing!']);
			redirect('dosen/' . $dosen->nip);
		}

		$this->load->model('bimbingan_model');
		$permohonans = $this->bimbingan_model->get_permohonans_nip($dosen->nip);
		if ($permohonans) {
			$this->session->set_flashdata(['message_error' => 'Gagal menghapus dosen. Dosen memiliki permohonan bimbingan!']);
			redirect('dosen/' . $dosen->nip);
		}
		$bimbingans = $this->bimbingan_model->get_bimbingans_nip($dosen->nip);
		if ($bimbingans) {
			$this->session->set_flashdata(['message_error' => 'Gagal menghapus dosen. Dosen memiliki bimbingan!']);
			redirect('dosen/' . $dosen->nip);
		}

		$this->load->model('kartu_kendali_model');
		$kartus = $this->kartu_kendali_model->get_kartus_nip($dosen->nip);
		if ($kartus) {
			$this->session->set_flashdata(['message_error' => 'Gagal menghapus dosen. Dosen memiliki kartu kendali!']);
			redirect('dosen/' . $dosen->nip);
		}

		$this->db->trans_start();
		$pengumumans = $this->pengumuman_model->get_pengumuman_creator_id($dosen->user->id);
		foreach ($pengumumans as $key => $pengumuman) {
			if (!$this->pengumuman_model->delete($pengumuman->id)) {
				return;
			}
		}

		if (!$this->dosen_model->delete_dosen_nip($dosen->nip)) {
			$this->session->set_flashdata(['message_error' => 'Gagal menghapus dosen.']);
			redirect('dosen/' . $dosen->nip);
		}

		if (!$this->user_model->delete($dosen->user->id)) {
			$this->session->set_flashdata(['message_error' => 'Gagal menghapus user.']);
			redirect('dosen/' . $dosen->nip);
		}
		$this->db->trans_complete();

		$this->session->set_flashdata(['message_success' => 'Berhasil menghapus dosen.']);
		redirect('dosen');
	}
}

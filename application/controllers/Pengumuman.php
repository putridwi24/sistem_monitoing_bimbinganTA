<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengumuman extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->auth_model->role_validator();
		$this->user = $this->auth_model->get_current_user_session();
		$this->load->model('pengumuman_model');
	}

	// INDEXES
	public function index()
	{
		$this->auth_model->role_validator(['tim_ta']);
		$pengumumans = $this->pengumuman_model->get_pengumuman_generals();
		$this->load->view('pengumuman/index', [
			'pengumumans' => $pengumumans
		]);
	}

	public function index_public()
	{
		$pengumumans = $this->pengumuman_model->get_pengumumans();
		$this->load->view('pengumuman/index_all', [
			'pengumumans' => $pengumumans
		]);
	}

	// SHOW
	public function show($id)
	{
		$this->load->model('pengumuman_model');

		$pengumuman = $this->pengumuman_model->get_id($id);
		if (!$pengumuman) {
			$this->session->set_flashdata(['message_error' => 'Pengumuman tidak valid']);
			redirect('beranda');
		}
		$this->pengumuman_model->update_add_seen_by($pengumuman->id, [$this->user->id]);
		return $this->load->view('pengumuman/show', [
			'pengumuman' => $pengumuman
		]);
	}

	// create
	public function create()
	{
		$this->auth_model->role_validator(['tim_ta']);
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->pengumuman_model->rules_create());

		if ($this->form_validation->run()) {

			$attachment = [];
			// cek apakah ada file 
			if (!empty($_FILES['fileAttach']['name'])) {
				$this->load->helper('string');
				$config['upload_path'] = UPLOAD_PATH_NOTIFICATION;
				$config['allowed_types'] = '*';
				$config['max_size'] = 10000;
				// $config['file_name'] = random_string('alnum', 24);

				$this->load->library('upload', $config);
				if (!is_dir(UPLOAD_PATH_NOTIFICATION)) {
					mkdir(UPLOAD_PATH_NOTIFICATION);
				}
				if (!$this->upload->do_upload('fileAttach')) {
					$this->session->set_flashdata(['message_error' => $this->upload->display_errors()]);
					redirect('pengumuman/create');
				} else {
					// update database
					$fileInfo = $this->upload->data();
					array_push($attachment, $fileInfo['file_name']);
				}
			}

			$txtTitle = $this->input->post('txtTitle');
			$txtInfo = $this->input->post('txtInfo');
			$immediateRelease = $this->input->post('immediateRelease');
			$immediateRelease = !!$immediateRelease;
			$notifTo = [];

			$save = $this->pengumuman_model->create(
				$txtTitle,
				$txtInfo,
				$this->user->id,
				'general',
				$immediateRelease,
				$notifTo,
				$attachment
			);
			if (!$save['status']) {
				$this->session->set_flashdata('message_error', $save['message']);
				return $this->load->view('pengumuman/create');
			}
			$this->session->set_flashdata('message_success', $save['message']);
			redirect('pengumuman');
		}

		$this->load->view('pengumuman/create');
	}

	// update
	public function edit($id)
	{
		$this->auth_model->role_validator(['tim_ta']);
		$pengumuman = $this->pengumuman_model->get_id($id);
		if (!$pengumuman) {
			$this->session->set_flashdata('message_error', 'Pengumuman tidak valid!');
			return redirect('pengumuman');
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->pengumuman_model->rules_create());

		if ($this->form_validation->run()) {
			$txtInfo = $this->input->post('txtInfo');
			$txtTitle = $this->input->post('txtTitle');
			$result = $this->pengumuman_model->update($pengumuman->id, $txtTitle, $txtInfo);
			if ($result['status']) {
				$this->session->set_flashdata('message_success', 'Berhasil mengubah pengumuman!');
				return redirect('pengumuman');
			}
			return redirect('pengumuman');
			$this->session->set_flashdata('message_error', $result['message']);
		}

		$this->load->view('pengumuman/edit', [
			'pengumuman' => $pengumuman
		]);
	}

	public function add_file()
	{
		$this->auth_model->role_validator(['tim_ta']);
		$id = $this->input->post('idPengumuman');
		$fileName = $this->input->post('fileName');
		$pengumuman = $this->pengumuman_model->get_id($id);
		if (!$pengumuman) {
			$this->session->set_flashdata('message_error', 'Pengumuman tidak valid!');
			return redirect('pengumuman');
		}

		// cek apakah ada file 
		if (empty($_FILES['fileAttach']['name'])) {
			$this->session->set_flashdata(['message_error' => 'Tidak ditemukan file']);
			redirect('pengumuman/' . $pengumuman->id . '/edit');
		}

		$this->load->helper('string');
		$config['upload_path'] = UPLOAD_PATH_NOTIFICATION;
		$config['allowed_types'] = '*';
		$config['max_size'] = 10000;
		// $config['file_name'] = random_string('alnum', 24);

		$this->load->library('upload', $config);
		if (!is_dir(UPLOAD_PATH_NOTIFICATION)) {
			mkdir(UPLOAD_PATH_NOTIFICATION);
		}
		if (!$this->upload->do_upload('fileAttach')) {
			$this->session->set_flashdata(['message_error' => $this->upload->display_errors()]);
			redirect('pengumuman/' . $pengumuman->id . '/edit');
		}

		// update database
		$fileInfo = $this->upload->data();
		if (!$this->pengumuman_model->update_add_file_id($pengumuman->id, $fileInfo['file_name'])) {
			$this->session->set_flashdata(['message_error' => 'Gagal menyimpan file']);
			redirect('pengumuman/' . $pengumuman->id . '/edit');
		}
		$this->session->set_flashdata('message_success', 'Berhasil menambah file.');
		redirect('pengumuman/' . $pengumuman->id . '/edit');
	}

	public function delete_file()
	{
		$this->auth_model->role_validator(['tim_ta']);
		$id = $this->input->post('idPengumuman');
		$fileName = $this->input->post('fileName');

		$pengumuman = $this->pengumuman_model->get_id($id);
		if (!$pengumuman) {
			$this->session->set_flashdata('message_error', 'Pengumuman tidak valid!');
			return redirect('pengumuman');
		}

		if (!file_exists(UPLOAD_PATH_NOTIFICATION . $fileName) || is_dir(UPLOAD_PATH_NOTIFICATION . $fileName)) {
			$this->session->set_flashdata('message_error', 'File tidak valid!');
			return redirect('pengumuman/' . $id . '/edit');
		}
		$this->load->helper('file');
		if (!unlink(UPLOAD_PATH_NOTIFICATION . $fileName)) {
			$this->session->set_flashdata('message_error', 'Gagal menghapus file!');
			return redirect('pengumuman/' . $id . '/edit');
		}
		if (!$this->pengumuman_model->update_delete_file_id($id, $fileName)) {
			$this->session->set_flashdata('message_error', 'Gagal menyimpan perubahan.');
			return redirect('pengumuman/' . $id . '/edit');
		}
		$this->session->set_flashdata('message_success', 'Berhasil menghapus file');
		redirect('pengumuman/' . $id . '/edit');
	}

	public function publish($id = null)
	{
		$this->auth_model->role_validator(['tim_ta']);
		if (is_null($id))
			$id = $this->input->post('idPengumuman');

		$pengumuman = $this->pengumuman_model->get_id($id);
		if (!$pengumuman) {
			$this->session->set_flashdata('message_error', 'Pengumuman tidak valid!');
			return redirect('pengumuman');
		}

		$result = $this->pengumuman_model->publish($pengumuman->id);

		if (!$result['status']) {
			$this->session->set_flashdata('message_error', $result['message']);
			return redirect('pengumuman');
		}

		$this->session->set_flashdata('message_success', $result['message']);
		redirect('pengumuman');
	}

	public function unpublish($id = null)
	{
		$this->auth_model->role_validator(['tim_ta']);
		if (is_null($id))
			$id = $this->input->post('idPengumuman');

		$pengumuman = $this->pengumuman_model->get_id($id);
		if (!$pengumuman) {
			$this->session->set_flashdata('message_error', 'Pengumuman tidak valid!');
			return redirect('pengumuman');
		}

		$result = $this->pengumuman_model->unpublish($pengumuman->id);

		if (!$result['status']) {
			$this->session->set_flashdata('message_error', $result['message']);
			return redirect('pengumuman');
		}

		$this->session->set_flashdata('message_success', $result['message']);
		redirect('pengumuman');
	}

	public function add_read_by()
	{
		$pengumumanIdJson = $this->input->post('pengumumanIdJson');
		$user = $this->auth_model->get_current_user_session();

		if (is_null($pengumumanIdJson)) {
			echo json_encode([
				'status' => 422,
				'message' => 'Pengumuman tidak valid'
			]);
			http_response_code(422);
			return;
		}

		$pengumuman_ids = json_decode($pengumumanIdJson);

		if (!is_array($pengumuman_ids)) {
			echo json_encode([
				'status' => 422,
				'message' => 'Pengumuman tidak valid'
			]);
			http_response_code(422);
			return;
		}

		if (count($pengumuman_ids) === 0) {
			echo json_encode([
				'status' => 422,
				'message' => 'Pengumuman tidak valid'
			]);
			http_response_code(422);
			return;
		}

		foreach ($pengumuman_ids as $pengumuman_id) {
			$this->pengumuman_model->update_add_seen_by($pengumuman_id, $user->id);
		}

		$this->session->set_flashdata('message_success', 'Berhasil mengarsipkan pengumuman');
		echo json_encode([
			'status' => 200,
			'message' => 'Berhasil mengarsipkan pengumuman'
		]);
		http_response_code(200);
		return;
	}

	// delete
	public function delete($id = null)
	{
		$this->auth_model->role_validator(['tim_ta']);

		if (is_null($id))
			$id = $this->input->post('idPengumuman');

		$pengumuman = $this->pengumuman_model->get_id($id);
		if (!$pengumuman) {
			$this->session->set_flashdata('message_error', 'Pengumuman tidak valid!');
			return redirect('pengumuman');
		}

		$result = $this->pengumuman_model->delete($pengumuman->id);

		if (!$result['status']) {
			$this->session->set_flashdata('message_error', $result['message']);
			return redirect('pengumuman');
		}

		$this->session->set_flashdata('message_success', 'Berhasil menghapus pengumuman!');
		redirect('pengumuman');
	}
}

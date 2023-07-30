<?php
defined('BASEPATH') or exit('No direct script access allowed');

class File extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->auth_model->role_validator();
		$this->user = $this->auth_model->get_current_user_session();
		$this->load->model('file_model');
	}

	public function dokumen()
	{
		switch ($this->role_model->get_role_id($this->user->role)->name) {
			case 'mahasiswa':
				$this->index_general();
				break;
			case 'dosen':
				$this->index_general();
				break;
			case 'tim_ta':
				$this->index_general();
				break;
			default:
				# code...
				break;
		}
	}

	function index_tim_ta()
	{
		$this->auth_model->role_validator(['tim_ta']);
		$documents = $this->file_model->get_documents();
		$this->load->view('dokumen/index_tim_ta', [
			'documents' => $documents
		]);
	}

	public function index_general()
	{
		$documents = $this->file_model->get_documents();
		$this->load->view('dokumen/index_general', [
			'documents' => $documents
		]);
	}

	public function create()
	{
		$this->auth_model->role_validator(['tim_ta']);

		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->file_model->rules_new_doc());

		if ($this->form_validation->run()) {
			$txtDeskripsi = $this->input->post('txtDeskripsi');
			// cek apakah ada file 
			if (!empty($_FILES['fileDokumen']['name'])) {
				$config['upload_path'] = UPLOAD_PATH_DOCUMENTS;
				$config['allowed_types'] = '*';
				$config['max_size'] = 100000;

				$this->load->library('upload', $config);
				if (!is_dir(UPLOAD_PATH_DOCUMENTS)) {
					mkdir(UPLOAD_PATH_DOCUMENTS);
				}
				if (!$this->upload->do_upload('fileDokumen')) {
					$this->session->set_flashdata(['message_error' => $this->upload->display_errors()]);
					redirect('dokumen/add');
				}

				$fileInfo = $this->upload->data();
				if (!$this->file_model->add_document($fileInfo['file_name'], $txtDeskripsi)) {
					$this->session->set_flashdata(['message_error' => 'Gagal menyimpan dokumen']);
					redirect('dokumen/add');
				}

				$this->session->set_flashdata(['message_success' => 'Berhasil menyimpan dokumen']);
				redirect('dokumen/all');
			}
		}
		$this->load->view('dokumen/create');
	}

	public function delete()
	{
		$this->auth_model->role_validator(['tim_ta']);

		$documentId = $this->input->post('documentId');
		$document = $this->file_model->get_document_id($documentId);

		if (!$document) {
			$this->session->set_flashdata(['message_error' => 'Dokumen tidak valid']);
			redirect('dokumen/all');
		}

		if (!is_file(UPLOAD_PATH_DOCUMENTS . $document->file_name)) {
			echo UPLOAD_PATH_DOCUMENTS . $document->file_name;
			return;
			$this->session->set_flashdata(['message_error' => 'Dokumen tidak valid']);
			redirect('dokumen/all');
		}

		$this->db->trans_begin();
		if (!$this->file_model->delete_document_id($document->id)) {
			$this->session->set_flashdata(['message_error' => 'Gagal menghapus dari database']);
			redirect('dokumen/all');
		}

		if (!unlink(UPLOAD_PATH_DOCUMENTS . $document->file_name)) {
			$this->session->set_flashdata(['message_error' => 'Gagal menghapus file']);
			redirect('dokumen/all');
		}
		$this->db->trans_complete();

		$this->session->set_flashdata(['message_success' => 'Berhasil menghapus file']);
		redirect('dokumen/all');
	}
}

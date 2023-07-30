<?php
defined('BASEPATH') or exit('No direct script access allowed');
class File_model extends CI_Model
{
	public function __construct()
	{
		if (!is_dir(UPLOAD_PATH_DOCUMENTS)) {
			mkdir(UPLOAD_PATH_DOCUMENTS);
		}
	}

	// show
	public function get_documents()
	{
		$query = $this->db
			->get(TABEL_FILES);

		$result = $query->result();

		return $result;
	}

	public function get_document_id($documentId)
	{
		$query = $this->db
			->where('id', $documentId)
			->get(TABEL_FILES);

		$document = $query->row();

		return $document;
	}


	// create
	public function add_document($file_name, $description)
	{
		$this->db
			->set('file_name', $file_name)
			->set('description', $description);

		if (!$this->db->insert(TABEL_FILES)) {
			return null;
		}

		$query = $this->db->where('id', $this->db->insert_id())->get(TABEL_FILES);

		return $query->row();
	}

	// update
	// delete
	public function delete_document_id($documentId)
	{
		$this->db
			->where('id', $documentId);
		return $this->db->delete(TABEL_FILES);
	}

	// utils
	public function rules_new_doc()
	{
		return [
			[
				'field' => 'txtDeskripsi',
				'label' => 'Deskripsi Dokumen',
				'rules' => 'required'
			],
		];
	}
}

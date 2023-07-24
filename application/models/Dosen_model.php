<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dosen_model extends CI_Model
{
	private $_table = TABEL_DOSEN;

	public function get_dosens()
	{
		$query = $this->db
			->get(TABEL_DOSEN);

		$dosens = $query->result();
		foreach ($dosens as $dosen) {
			$dosen->user = $this->user_model->get_user_id($dosen->user_id);
		}
		return $dosens;
	}

	public function get_dosen_nip($nip)
	{
		$query = $this->db
			->where('nip', $nip)
			->get(TABEL_DOSEN);

		$dosen = $query->row();

		if ($dosen) {
			$dosen->user = $this->user_model->get_user_id($dosen->user_id);
		}

		return $dosen;
	}

	public function get_dosen_uid($user_id)
	{
		$query = $this->db
			->where('user_id', $user_id)
			->get(TABEL_DOSEN);

		$dosen = $query->row();

		if ($dosen) {
			$dosen->user = $this->user_model->get_user_id($dosen->user_id);
		}

		return $dosen;
	}

	public function get_dosen_code_name($code_name)
	{
		$query = $this->db
			->where('code_name', $code_name)
			->get(TABEL_DOSEN);

		$dosen = $query->row();

		if ($dosen) {
			$dosen->user = $this->user_model->get_user_id($dosen->user_id);
		}

		return $dosen;
	}

	public function get_tim_uid($uid)
	{
		$query = $this->db
			->select('
				' . TABEL_DOSEN . '.nip as nip,  
				' . TABEL_USER . '.name as name,
				' . TABEL_USER . '.id as user_id,
				' . TABEL_USER . '.email as email,
				' . TABEL_USER . '.avatar as avatar,
				' . TABEL_USER . '.telephone as telephone
			')
			->from(TABEL_USER)
			->join(TABEL_USER, '' . TABEL_DOSEN . '.user_id=' . TABEL_USER . '.id')
			->where('id', $uid)
			->get();
		return $query->row();
	}

	public function create($nip, $code_name, $user_id)
	{
		$this->db
			->set('nip', $nip)
			->set('code_name', $code_name)
			->set('user_id', $user_id);

		if (!$this->db->insert(TABEL_DOSEN)) {
			return null;
		}
		$dosen = $this->get_dosen_nip($nip);

		return $dosen;
	}

	public function update_nip($nip)
	{
		$date = new DateTime('now');
		$this->db->set('updated_at', $date->format('Y-m-d H:i:s'))
			->where('nip', $nip);

		return $this->db->update(TABEL_DOSEN);
	}

	// DELETE
	public function delete_dosen_nip($nip)
	{
		$this->db
			->where('nip', $nip);

		return $this->db->delete(TABEL_DOSEN);
	}

	public function fields_import($index = null)
	{
		$fields = [
			'nama',
			'email',
			'code_name',
			'nip',
		];

		if (is_null($index)) return $fields;

		return $fields[$index];
	}

	// rules
	public function rules_profile_update()
	{
		return [
			[
				'field' => 'txtName',
				'label' => 'Nama Lengkap',
				'rules' => 'required|trim'
			],
		];
	}
}

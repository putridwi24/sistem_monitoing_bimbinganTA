<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Role_model extends CI_Model
{
	private $_table = TABEL_USER;

	// get
	public function get_roles()
	{
		$query = $this->db
			->get(TABEL_USER_ROLE);
		return $query->result();
	}

	public function get_role_id($role_id)
	{
		$query = $this->db
			->where('id', $role_id)
			->get(TABEL_USER_ROLE);
		return $query->row();
	}

	public function get_role_email($email)
	{
		$email = explode('@', $email);
		if (count($email) === 0) {
			return false;
		}

		switch ($email[1]) {
			case 'if.itera.ac.id':
				return $this->get_role_name('dosen');
				break;
			case 'student.itera.ac.id':
				return $this->get_role_name('mahasiswa');
				break;
			default:
				return $this->get_role_name('dosen');
				break;
		}
		return false;
	}

	public function get_role_name($role_name)
	{
		$query = $this->db
			->where('name', $role_name)
			->get(TABEL_USER_ROLE);
		return $query->row();
	}
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User_model extends CI_Model
{
	private $_table = TABEL_USER;

	// create
	public function create($name, $email, $role, $password = null)
	{
		if ($name === '' || $email === '') return null;

		$data = [
			'name' => $name,
			'email' => $email,
			'avatar' => SIMOTA_AVATAR_DEFAULT,
			'role' => $role,
			'password' => is_null($password) ? '' : password_hash($password, PASSWORD_DEFAULT)
		];

		if (!$this->db->insert(TABEL_USER, $data)) {
			return null;
		}

		$user = $this->get_user_id($this->db->insert_id());
		return $user;
	}

	// read
	public function get_user_id($user_id)
	{
		$query = $this->db
			->where('id', $user_id)
			->get(TABEL_USER);

		return $query->row();
	}

	public function get_user_email($user_email)
	{
		$query = $this->db
			->where('email', $user_email)
			->get(TABEL_USER);

		return $query->row();
	}

	public function is_password_created($email)
	{
		$user = $this->get_user_email($email);
		return is_null($user->password);
	}

	// update
	public function update_data_id($user_id, $name, $email, $avatar)
	{
		$this->db
			->set('name', $name)
			->set('email', $email)
			->set('avatar', $avatar)
			->where('id', $user_id);
		return $this->db->update(TABEL_USER);
	}

	public function update_confirm_id($user_id)
	{
		$time = new DateTime('now');
		$this->db
			->set('email_confirm_at', $time->format('Y-m-d H:i:s'))
			->where('id', $user_id);
		return $this->db->update(TABEL_USER);
	}

	public function update_avatar_id($user_id, $avatar_name)
	{
		$this->db
			->set('avatar', $avatar_name)
			->where('id', $user_id);
		return $this->db->update(TABEL_USER);
	}

	public function update_role_id($user_id, $role_id)
	{
		$this->db
			->set('role', $role_id)
			->where('id', $user_id);
		return $this->db->update(TABEL_USER);
	}

	public function update_password_id($user_id, $password)
	{
		$this->db
			->set('password', password_hash($password, PASSWORD_DEFAULT))
			->where('id', $user_id);
		return $this->db->update(TABEL_USER);
	}

	public function update_reset_password_id($user_id)
	{
		$this->db
			->set('password', password_hash('password', PASSWORD_DEFAULT))
			->where('id', $user_id);
		return $this->db->update(TABEL_USER);
	}

	public function update_last_login_id($user_id)
	{
		$time = new DateTime('now');
		$this->db
			->set('last_login', $time->format('Y-m-d H:i:s'))
			->where('id', $user_id);
		return $this->db->update(TABEL_USER);
	}

	// DELETE
	public function delete($id)
	{
		$this->db
			->where('id', $id);
		return $this->db->delete(TABEL_USER);
	}

	public function email_check_format($email)
	{
		$email = explode('@', $email);
		if (count($email) === 0) {
			return false;
		}

		return true;
	}

	public function email_check_domain($email)
	{
		if (!$this->email_check_format($email)) {
			return false;
		}

		$email = explode('@', $email);
		if (count($email) === 0) {
			return false;
		}

		switch ($email[1]) {
			case 'if.itera.ac.id':
			case 'student.itera.ac.id':
			case 'gmail.com':
				return true;
				break;
		}
		return false;
	}

	public function rules_update_password()
	{
		return [
			[
				'field' => 'txtPasswordOld',
				'label' => 'Password Lama',
				'rules' => 'required|trim'
			],
			[
				'field' => 'txtPasswordNew',
				'label' => 'Password Baru',
				'rules' => 'required|trim'
			],
			[
				'field' => 'txtPasswordNewConfirm',
				'label' => 'Konfirmasi Password Baru',
				'rules' => 'required|trim|matches[txtPasswordNew]'
			],
		];
	}

	public function rules_new_user()
	{
		return [
			[
				'field' => 'txtPassword',
				'label' => 'Password',
				'rules' => 'required|min_length[8]'
			],
			[
				'field' => 'txtPasswordConfirm',
				'label' => 'Konfirmasi Password',
				'rules' => 'required|matches[txtPassword]'
			],
			[
				'field' => 'txtEmail',
				'label' => 'Email',
				'rules' => 'required|is_unique[' . TABEL_USER . '.email]'
			],
			[
				'field' => 'txtTel',
				'label' => 'Nomor telepon',
				'rules' => 'required|regex_match[/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/]',
				'errors' => [
					'regex_match' => 'Format %s tidak benar'
				]
			],
			[
				'field' => 'txtName',
				'label' => 'Nama',
				'rules' => 'required|trim'
			],
		];
	}
}

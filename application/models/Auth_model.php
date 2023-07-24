<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Auth_model extends CI_Model
{
	private $_table = TABEL_USER;
	const SESSION_KEY = "user_id";
	const SESSION_ROLE = "user_role";


	public function __construct()
	{
		$this->load->model('user_model');
	}

	// session create
	public function create_session_email($email, $password)
	{
		$user = $this->user_model->get_user_email($email);
		// apakah user terdaftar
		if (!$user) {
			return false;
		}

		// apakah password benar
		if (!password_verify($password, $user->password)) {
			return false;
		}

		// buat session
		$this->session->set_userdata([self::SESSION_KEY => $user->id]);
		$user = $this->get_current_user_session();
		$this->session->set_userdata([self::SESSION_ROLE => $user->role]);

		return true;
	}

	// session get 
	public function get_current_user_session()
	{
		if (!$this->session->has_userdata(self::SESSION_KEY)) {
			return null;
		}

		$user_id = $this->session->userdata(self::SESSION_KEY);

		return $user = $this->user_model->get_user_id($user_id);
	}

	// session update 

	// session delete
	public function delete_session()
	{
		$this->session->unset_userdata(self::SESSION_KEY);
		$this->session->unset_userdata(self::SESSION_ROLE);
		return !$this->session->has_userdata(self::SESSION_KEY);
	}

	// email confirm create
	public function create_email_confirm($email)
	{
		$this->load->helper('string');
		$token = random_string('alnum', 70);
		$this->db
			->set('email', $email)
			->set('token', $token);
		if ($this->db->insert(TABEL_EMAIL_CONFIRM)) {
			return $token;
		} else {
			return false;
		}
	}

	public function create_send_email_confirm($email)
	{
		$token = $this->auth_model->create_email_confirm($email);

		// send email confirm
		$this->load->model('mailing_model');
		$status = $this->mailing_model->send_email_verification($email, $token);
		if ($status) {
			return $token;
		}
		return null;
	}

	// email confirm accept
	public function update_accept_email_confirm_token($token)
	{
		$query = $this->db
			->where('token', $token)
			->where('confirmed_at is null')
			->get(TABEL_EMAIL_CONFIRM);

		$result = $query->row();
		if (!$result) {
			return false;
		}

		$time = new DateTime('now');
		$this->db
			->set('confirmed_at', $time->format('Y-m-d H:i:s'))
			->where('id', $result->id);

		if (!$this->db->update(TABEL_EMAIL_CONFIRM)) {
			return false;
		}
		return $result;
	}

	// password reset
	public function get_valid_password_reset_token($token)
	{
		$query = $this->db
			->where('token', $token)
			->where('confirmed_at is null')
			->get(TABEL_PASSWORD_RESET);

		return $query->row();
	}

	public function create_password_reset($email)
	{
		$this->load->helper('string');
		$token = random_string('alnum', 70);
		$this->db
			->set('email', $email)
			->set('token', $token);
		if ($this->db->insert(TABEL_PASSWORD_RESET)) {
			return $token;
		} else {
			return false;
		}
	}

	public function create_send_password_reset($email)
	{
		$token = $this->auth_model->create_password_reset($email);

		// send password reset
		$this->load->model('mailing_model');
		$status = $this->mailing_model->send_password_reset($email, $token);
		if ($status) {
			return $token;
		}

		return null;
	}

	public function update_accept_token($token)
	{
		$time = new DateTime('now');
		$this->db
			->set('confirmed_at', $time->format('Y-m-d H:i:s'))
			->where('id', $token->id);

		return $this->db->update(TABEL_PASSWORD_RESET);
	}

	public function update_accept_password_reset_token($token, $password)
	{
		$token = $this->get_valid_password_reset_token($token);
		if (!$token) return false;

		$this->db->trans_start();
		if (!$this->update_accept_token($token)) {
			return false;
		}
		$user = $this->user_model->get_user_email($token->email);
		$this->user_model->update_password_id($user->id, $password);

		$this->db->trans_complete();
		return true;
	}

	// role validator
	public function role_validator($role = ['mahasiswa', 'dosen', 'tim_ta'])
	{
		$user = $this->get_current_user_session();
		if (!$user) redirect('auth');
		$user_role = $this->role_model->get_role_id($user->role);
		$valid = false;
		foreach ($role as $item) {
			$valid |=  ($user_role->name === $item);
		}
		if (!$valid) redirect('auth');
	}


	public function rules_create_session()
	{
		return [
			[
				'field' => 'txtEmail',
				'label' => 'Email',
				'rules' => 'required'
			],
			[
				'field' => 'txtPassword',
				'label' => 'Password',
				'rules' => 'required'
			]
		];
	}

	public function rules_reset_password_token()
	{
		return [
			[
				'field' => 'txtPassword',
				'label' => 'Password',
				'rules' => 'required'
			],
			[
				'field' => 'txtPasswordConfirm',
				'label' => 'Konfirmasi Password',
				'rules' => 'required|matches[txtPassword]'
			],
		];
	}

	public function rules_password_reset()
	{
		return [
			[
				'field' => 'txtEmail',
				'label' => 'Email',
				'rules' => 'required'
			],
		];
	}
}

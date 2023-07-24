<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function index()
	{
		$user = $this->auth_model->get_current_user_session();
		if (!$user) {
			redirect('login');
		}
		switch ($this->role_model->get_role_id($user->role)->name) {
			case 'mahasiswa':
				redirect('beranda/mahasiswa');
				break;
			case 'dosen':
				redirect('beranda/dosen');
				break;
			case 'tim_ta':
				redirect('beranda/tim_ta');
				break;
			default:
				# code...
				break;
		}
	}

	public function login()
	{
		$this->load->model('user_model');

		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->auth_model->rules_create_session());

		if ($this->form_validation->run()) {
			$txtEmail = $this->input->post('txtEmail');
			$password = $this->input->post('txtPassword');

			// cek user
			if (!$this->user_model->get_user_email($txtEmail)) {

				$this->session->set_flashdata('message_error', 'Email tidak terdaftar');
				redirect('login');
			}

			// buat session
			if (!$this->auth_model->create_session_email($txtEmail, $password)) {
				$this->session->set_flashdata('message_error', 'Email atau password salah');
				redirect('login');
			}

			redirect('auth');
		}
		$this->load->view('backend/login');
	}

	public function logout()
	{
		$this->auth_model->delete_session();
		redirect('auth');
	}

	public function register()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules($this->user_model->rules_new_user());
		// $this->form_validation->set_rules(
		// 	'txtName',
		// 	'Nama Lengkap',
		// 	'callback_min_one_word'
		// );

		$this->form_validation->set_rules(
			'txtEmail',
			'Email',
			'callback_email_verif'
		);

		if ($this->form_validation->run()) {
			$regName = $this->input->post('txtName');
			$regUsername = $this->input->post('txtUsername');
			$regEmail = $this->input->post('txtEmail');
			$regTel = $this->input->post('txtTel');
			$regPassword = $this->input->post('txtPassword');

			// register user
			$role = $this->role_model->get_role_email($regEmail);

			$this->db->trans_start();
			$create_user = $this->user_model->create($regUsername, $regEmail, $regTel, $regName, $regPassword, $role->id);
			if (is_null($create_user)) {
				$this->session->set_flashdata('message_error', 'Gagal melakukan pendaftaran');
				redirect('register');
			}

			// register mahasiswa or dosen
			switch ($role->name) {
				case 'mahasiswa':
					$this->load->model('mahasiswa_model');
					$nim = $this->mahasiswa_model->get_nim_email($regEmail);
					$this->mahasiswa_model->create($nim, null, null, null, $create_user->id);
					break;

				case 'dosen':
					break;
				default:
					# code...
					break;
			}

			// generate email confirm
			$state = $this->auth_model->create_send_email_confirm($regEmail);

			if ($state) {
				$this->session->set_flashdata('message_success', 'Berhasil mendaftar, silakan cek email untuk konfirmasi pendaftaran');
			} else {
				print_r($this->email->print_debugger());
				return;
				$this->session->set_flashdata(['message_error' => 'Gagal mengirim email']);
			}

			$this->db->trans_complete();
			redirect('login');
		}

		$this->load->view('backend/register');
	}

	// account reset
	public function email_confirm()
	{
		$token = $this->input->get('token');

		if (!$token) {
			$this->session->set_flashdata('message_error', 'Gagal konfirmasi email');
			redirect('login');
		}

		$confirm = $this->auth_model->update_accept_email_confirm_token($token);
		if (!$confirm) {
			$this->session->set_flashdata('message_error', 'Gagal konfirmasi email. Token tidak valid atau kadaluarsa.');
			redirect('login');
		}

		if ($this->user_model->is_password_created($confirm->email)) {
			$this->session->set_flashdata('message_success', 'Berhasil konfirmasi Email, silakan login');
			redirect('login');
		}

		if ($this->auth_model->create_send_password_reset($confirm->email)) {
			$this->session->set_flashdata('message_success', 'Berhasil konfirmasi Email, silakan cek email untuk login.');
			redirect('login');
		} else {
			print_r($this->email->print_debugger());
			return;
			$this->session->set_flashdata(['message_error' => 'Gagal mengirim email']);
		}
	}

	public function password_reset()
	{
		$token = $this->input->get('token');

		if (!$token) {
			$this->session->set_flashdata('message_error', 'Gagal reset password');
			redirect('login');
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->auth_model->rules_reset_password_token());

		if ($this->form_validation->run()) {
			$txtPassword = $this->input->post('txtPassword');
			$confirm = $this->auth_model->update_accept_password_reset_token($token, $txtPassword);
			if (!$confirm) {
				$this->session->set_flashdata('message_error', 'Gagal konfirmasi email. Token tidak valid atau kadaluarsa.');
				redirect('login');
			}

			if ($this->user_model->is_password_created($confirm->email)) {
				$this->session->set_flashdata('message_success', 'Berhasil membuat password, silakan login');
				redirect('login');
			}

			if ($this->auth_model->create_send_password_reset($confirm->email)) {
				$this->session->set_flashdata('message_success', 'Berhasil membuat password, silakan cek email untuk login.');
				redirect('login');
			} else {
				print_r($this->email->print_debugger());
				return;
				$this->session->set_flashdata(['message_error' => 'Gagal mengirim email']);
			}
		}

		$this->load->view('backend/password_create', [
			'token' => $token
		]);
	}

	public function password_forgot()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->auth_model->rules_password_reset());

		if ($this->form_validation->run()) {
			$txtEmail = $this->input->post('txtEmail');

			// generate email confirm
			if (!$this->auth_model->create_send_password_reset($txtEmail)) {
				$this->session->set_flashdata('message_error', 'Tidak dapat membuat password baru.');
				redirect('login');
			}
			$this->session->set_flashdata('message_success', 'Silakan periksa email untuk membuat password baru.');
			redirect('login');
		}

		$this->load->view('backend/password_forgot');
	}

	// rules
	public function min_one_word($str)
	{
		$str = trim($str);
		if (preg_match('/\s/', $str)) {
			return TRUE;
		} else {
			$this->form_validation->set_message('min_one_word', '{field} minimal satu kata');
			return FALSE;
		}
	}

	public function email_verif($email)
	{
		if (!$this->user_model->email_check_format($email)) {
			$this->form_validation->set_message('email_verif', 'Format {field} tidak benar');
			return false;
		}

		if (!$this->user_model->email_check_domain($email)) {
			$this->form_validation->set_message('email_verif', '{field} harus menggunakan email resmi ITERA');
			return false;
		}
		return true;
	}
}

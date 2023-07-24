<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
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
				$mahasiswa = $this->mahasiswa_model->get_mahasiswa_uid($this->user->id);
				$this->load->view('user/profil_mahasiswa', [
					'mahasiswa' => $mahasiswa
				]);

				break;
			case 'dosen':
			case 'tim_ta':
				$dosen = $this->dosen_model->get_dosen_uid($this->user->id);
				$this->load->view('user/profil_dosen', [
					'dosen' => $dosen
				]);
				break;
		}
	}

	// EDIT
	public function edit()
	{
		switch ($this->role_model->get_role_id($this->user->role)->name) {
			case 'mahasiswa':
				$this->edit_mahasiswa();
				break;
			case 'dosen':
			case 'tim_ta':
				$this->edit_dosen();
				break;
		}
	}

	public function edit_mahasiswa()
	{
		$this->auth_model->role_validator(['mahasiswa']);
		$mahasiswa = $this->mahasiswa_model->get_mahasiswa_uid($this->user->id);

		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->mahasiswa_model->rule_profile_mahasiswa());

		if ($this->form_validation->run()) {
			$txtName = $this->input->post('txtName');
			$txtTa = $this->input->post('txtTa');

			$this->db->trans_start();
			if (!$this->user_model->update_data_id($this->user->id, $txtName, $this->user->email, $this->user->avatar)) {
				$this->session->set_flashdata('message_error', 'Gagal memperbarui data user');
				redirect('profile/edit');
			}

			$mahasiswa = $this->mahasiswa_model->get_mahasiswa_uid($this->user->id);
			$update = false;
			if ($mahasiswa) {
				// if exist 
				$update = $this->mahasiswa_model->update_judul_nim($mahasiswa->nim, $txtTa);
			} else {
			}
			if (!$update) {
				$this->session->set_flashdata('message_error', 'Gagal memperbarui data mahasiswa');
				redirect('profile/edit');
			}

			$this->db->trans_complete();
			$this->session->set_flashdata('message_success', 'Berhasil memperbarui data');
			redirect('profile');
		}

		$dosens = $this->dosen_model->get_dosens();
		$this->load->view('user/edit_mahasiswa', [
			'mahasiswa' => $mahasiswa,
			'dosens' => $dosens
		]);
	}

	public function edit_dosen()
	{
		$this->auth_model->role_validator(['dosen', 'tim_ta']);
		$dosen = $this->dosen_model->get_dosen_uid($this->user->id);

		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->dosen_model->rules_profile_update());

		if ($this->form_validation->run()) {
			$txtName = $this->input->post('txtName');

			$this->db->trans_start();
			if (!$this->user_model->update_data_id($this->user->id, $txtName, $this->user->email, $this->user->avatar)) {
				$this->session->set_flashdata('message_error', 'Gagal memperbarui data user');
				redirect('profile/edit');
			}

			$dosen = $this->dosen_model->get_dosen_uid($this->user->id);
			$update = false;
			if ($dosen) {
				// if exists
				$update = $this->dosen_model->update_nip($dosen->nip);
			} else {
			}

			if (!$update) {
				$this->session->set_flashdata('message_error', 'Gagal memperbarui data dosen');
				redirect('profile/edit');
			}

			$this->db->trans_complete();
			$this->session->set_flashdata('message_success', 'Berhasil memperbarui data');
			redirect('profile');
		}

		$this->load->view('user/edit_dosen', [
			'dosen' => $dosen,
		]);
	}

	public function password_change()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->user_model->rules_update_password());

		if ($this->form_validation->run()) {
			$passwordOld = $this->input->post('txtPasswordOld');
			$passwordNew = $this->input->post('txtPasswordNew');

			if (!password_verify($passwordOld, $this->user->password))
				$this->session->set_flashdata('message_error', 'Password salah');

			if ($this->user_model->update_password_id($this->user->id, $passwordNew)) {
				$this->session->set_flashdata('message_success', 'Berhasil mengganti password');
				return redirect('profile/edit');
			}
			$this->session->set_flashdata('message_error', 'Gagal mengganti password');
		}
		$this->load->view('user/edit_password');
	}

	public function update_avatar()
	{
		$userId = $this->input->post('idUser');
		$user = $this->user_model->get_user_id($userId);
		if (!$user) {
			$this->session->set_flashdata(['message_success' => 'User tidak valid']);
			redirect('profile/edit');
		}
		// cek apakah ada file 
		if (!empty($_FILES['imgAvatar']['name'])) {
			$this->load->helper('string');
			$config['upload_path'] = UPLOAD_PATH_PROFILE;
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['max_size'] = 10000;
			$config['file_name'] = random_string('alnum', 24);

			$this->load->library('upload', $config);
			if (!is_dir(UPLOAD_PATH_PROFILE)) {
				mkdir(UPLOAD_PATH_PROFILE);
			}
			if (!$this->upload->do_upload('imgAvatar')) {
				$this->session->set_flashdata(['message_error' => $this->upload->display_errors()]);
				redirect('profile/edit');
			} else {
				if ($this->user->avatar !== SIMOTA_AVATAR_DEFAULT) {
					// delete past file 
					if (file_exists(UPLOAD_PATH_PROFILE . $this->user->avatar) && !is_dir(UPLOAD_PATH_PROFILE . $this->user->avatar)) {
						$this->load->helper('file');
						unlink(UPLOAD_PATH_PROFILE . $this->user->avatar);
					}
				}

				// update database
				$fileInfo = $this->upload->data();
				if ($this->user_model->update_avatar_id($this->user->id, $fileInfo['file_name'])) {
					$this->session->set_flashdata(['message_success' => 'Berhasil mengupdate profil']);
					redirect('profile/edit');
				}
			}
		}
	}

	public function password_reset()
	{
		$this->auth_model->role_validator(['tim_ta']);

		$userId = $this->input->post('userId');

		$user = $this->user_model->get_user_id($userId);
		if (!$user) {
			$this->session->set_flashdata('message_error', 'User tidak valid');
			redirect($_SERVER['HTTP_REFERER']);
		}

		if ($this->user_model->update_reset_password_id($user->id)) {
			$this->session->set_flashdata('message_success', 'Berhasil mereset password');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->session->set_flashdata('message_error', 'Gagal mereset password');
		redirect($_SERVER['HTTP_REFERER']);
	}

	// DELETE
	public function delete($userId)
	{
		echo $userId;
	}
}

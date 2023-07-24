<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mailing_model extends CI_Model
{
	public $email_config = [
		'mailtype'  => 'html',
		'charset'   => 'utf-8',
		'protocol'  => 'smtp',
		'smtp_host' => MAIL_SMTP_HOST,
		'smtp_user' => MAIL_SMTP_USER,  // Email gmail
		'smtp_pass'   => MAIL_SMTP_PASS,  // Password gmail
		'smtp_crypto' => MAIL_SMTP_CRYPTO,
		'smtp_port'   => MAIL_SMTP_PORT,
		'crlf'    => "\r\n",
		'newline' => "\r\n"
	];


	public function __construct()
	{
		$this->load->model('user_model');
		$this->load->library('email', $this->email_config);
	}

	public function send_email_verification($mail_to, $verif_token)
	{
		if (!ENABLE_EMAIL) return true;
		// send email confirm
		$this->email->from(MAIL_NOREPLY, 'Sistem Monitoring TA');
		$this->email->to($mail_to);
		$this->email->subject('Konfirmasi pendaftaran');
		$message = "Silakan klik link dibawah untuk konfirmasi email. <br>
						<a href='" . base_url('email_confirm?token=' . $verif_token) . "'>Konfirmasi Email</a>";
		$this->email->message($message);

		return $this->email->send();
	}

	public function send_password_reset($mail_to, $reset_token)
	{
		if (!ENABLE_EMAIL) return true;
		// send password reset 
		$this->email->from(MAIL_NOREPLY, 'Sistem Monitoring TA');
		$this->email->to($mail_to);
		$this->email->subject('Permohonan Bimbingan');
		$message = "Silakan klik link dibawah untuk membuat password baru. <br>
							<a href='" . base_url('password_reset?token=' . $reset_token) . "'>Buat Password Baru</a>";
		$this->email->message($message);

		return $this->email->send();
	}

	public function send_mail_bimbingan_asked($bimbingan_id)
	{
		if (!ENABLE_EMAIL) return true;

		$this->load->model('bimbingan_model');

		$bimbingan = $this->bimbingan_model->get_bimbingan_id($bimbingan_id);
		$dosen = $this->dosen_model->get_dosen_nip($bimbingan->dosen_nip);
		$mahasiswa = $this->mahasiswa_model->get_mahasiswa_nim($bimbingan->mahasiswa_nim);

		$dosen = $this->dosen_model->get_dosen_nip($dosen->nip);
		$mahasiswa = $this->mahasiswa_model->get_mahasiswa_nim($mahasiswa->nim);

		$info = 'Mahasiswa <strong>' . $mahasiswa->user->name . '</strong> telah mengajukan permohonan bimbingan. ';
		$info .= "Segera <a href='" . base_url('permohonan/') . "'>Periksa Permohonan</a>";

		$this->email->from(MAIL_NOREPLY, 'Sistem Monitoring TA');
		$this->email->to($dosen->user->email);
		$this->email->subject('Permohonan Bimbingan');
		$this->email->message($info);

		return $this->email->send();
	}

	public function send_mail_bimbingan_accepted($bimbingan_id)
	{
		if (!ENABLE_EMAIL) return true;

		$this->load->model('bimbingan_model');

		$bimbingan = $this->bimbingan_model->get_bimbingan_id($bimbingan_id);
		$dosen = $this->dosen_model->get_dosen_nip($bimbingan->dosen_nip);
		$mahasiswa = $this->mahasiswa_model->get_mahasiswa_nim($bimbingan->mahasiswa_nim);

		$dosen = $this->dosen_model->get_dosen_nip($dosen->nip);
		$mahasiswa = $this->mahasiswa_model->get_mahasiswa_nim($mahasiswa->nim);

		$info = 'Permohonan Bimbingan anda kepada <strong>' . $dosen->user->name . '</strong>  telah disetujui. ';
		$info .= "Silakan <a href='" . base_url('bimbingan') . "'>Periksa Bimbingan</a>";

		$this->email->from(MAIL_NOREPLY, 'Sistem Monitoring TA');
		$this->email->to($mahasiswa->user->email);
		$this->email->subject('Bimbingan Disetujui');
		$this->email->message($info);

		return $this->email->send();
	}

	public function send_mail_bimbingan_rejected($bimbingan_id)
	{
		if (!ENABLE_EMAIL) return true;

		$this->load->model('bimbingan_model');

		$bimbingan = $this->bimbingan_model->get_bimbingan_id($bimbingan_id);
		$dosen = $this->dosen_model->get_dosen_nip($bimbingan->dosen_nip);
		$mahasiswa = $this->mahasiswa_model->get_mahasiswa_nim($bimbingan->mahasiswa_nim);

		$dosen = $this->dosen_model->get_dosen_nip($dosen->nip);
		$mahasiswa = $this->mahasiswa_model->get_mahasiswa_nim($mahasiswa->nim);

		$info = 'Permohonan Bimbingan anda kepada <strong>' . $dosen->user->name . '</strong>  telah disetujui. ';
		$info .= "Silakan <a href='" . base_url('bimbingan') . "'>Periksa Bimbingan</a>";

		$this->email->from(MAIL_NOREPLY, 'Sistem Monitoring TA');
		$this->email->to($mahasiswa->user->email);
		$this->email->subject('Bimbingan Ditolak');
		$this->email->message($info);

		return $this->email->send();
	}
}

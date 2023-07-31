<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Development extends CI_Controller
{
	public function reset()
	{
		$con = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);
		if (!$con) {
			die("Connection failed" . mysqli_connect_error());
		}

		if (!mysqli_query($con, 'USE ' . DB_NAME)) {
			die(mysqli_error($con));
		}

		// CLEAR DATABASE
		if (!mysqli_query($con, 'SET foreign_key_checks=0')) {
			die(mysqli_error($con));
		}
		if (!mysqli_query($con, 'DROP TABLE IF EXISTS ' . TABEL_USER)) {
			die(mysqli_error($con));
		}
		if (!mysqli_query($con, 'DROP TABLE IF EXISTS ' . TABEL_EMAIL_CONFIRM)) {
			die(mysqli_error($con));
		}
		if (!mysqli_query($con, 'DROP TABLE IF EXISTS ' . TABEL_PASSWORD_RESET)) {
			die(mysqli_error($con));
		}
		if (!mysqli_query($con, 'DROP TABLE IF EXISTS ' . TABEL_USER_ROLE)) {
			die(mysqli_error($con));
		}
		if (!mysqli_query($con, 'DROP TABLE IF EXISTS ' . TABEL_MAHASISWA)) {
			die(mysqli_error($con));
		}
		if (!mysqli_query($con, 'DROP TABLE IF EXISTS ' . TABEL_DOSEN)) {
			die(mysqli_error($con));
		}
		if (!mysqli_query($con, 'DROP TABLE IF EXISTS ' . TABEL_PENGUMUMAN)) {
			die(mysqli_error($con));
		}
		if (!mysqli_query($con, 'DROP TABLE IF EXISTS ' . TABEL_BIMBINGAN)) {
			die(mysqli_error($con));
		}
		if (!mysqli_query($con, 'DROP TABLE IF EXISTS ' . TABEL_KARTU_KENDALI)) {
			die(mysqli_error($con));
		}
		if (!mysqli_query($con, 'DROP TABLE IF EXISTS ' . TABEL_REGISTER_STATUS)) {
			die(mysqli_error($con));
		}
		if (!mysqli_query($con, 'DROP TABLE IF EXISTS ' . TABEL_REGISTER_STAGE)) {
			die(mysqli_error($con));
		}
		if (!mysqli_query($con, 'DROP TABLE IF EXISTS ' . TABEL_PROGRES)) {
			die(mysqli_error($con));
		}
		if (!mysqli_query($con, 'DROP TABLE IF EXISTS ' . TABEL_FILES)) {
			die(mysqli_error($con));
		}
		if (!mysqli_query($con, 'SET foreign_key_checks=1')) {
			die(mysqli_error($con));
		}

		// CREATE DATABASES
		$query = "CREATE TABLE " . TABEL_USER_ROLE . " (
				id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
				name VARCHAR(20) NOT NULL
			);
			";
		if (!mysqli_query($con, $query)) {
			die(mysqli_error($con));
		}

		$query = "CREATE TABLE " . TABEL_USER . " (
				id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
				name VARCHAR(70) NOT NULL,
				email VARCHAR(70) NOT NULL,
				email_confirm_at DATETIME DEFAULT NULL,
				avatar VARCHAR(200) DEFAULT NULL,
				role INT UNSIGNED NOT NULL,
				password VARCHAR(200) DEFAULT NULL,
				created_at DATETIME NOT NULL DEFAULT NOW(),
				updated_at DATETIME DEFAULT NULL,
				last_login DATETIME DEFAULT NULL,
				FOREIGN KEY(role) REFERENCES " . TABEL_USER_ROLE . "(id)
			);
			";
		if (!mysqli_query($con, $query)) {
			die(mysqli_error($con));
		}

		$query = "CREATE TABLE " . TABEL_EMAIL_CONFIRM . " (
				id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
				created_at DATETIME NOT NULL DEFAULT NOW(),
				updated_at DATETIME DEFAULT NULL,
				confirmed_at DATETIME DEFAULT NULL,
				email VARCHAR(70) NOT NULL,
				token VARCHAR(70) NOT NULL 
			);
			";
		if (!mysqli_query($con, $query)) {
			die(mysqli_error($con));
		}

		$query = "CREATE TABLE " . TABEL_PASSWORD_RESET . " (
				id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
				created_at DATETIME NOT NULL DEFAULT NOW(),
				updated_at DATETIME DEFAULT NULL,
				confirmed_at DATETIME DEFAULT NULL,
				email VARCHAR(70) NOT NULL,
				token VARCHAR(70) NOT NULL 
			);
			";
		if (!mysqli_query($con, $query)) {
			die(mysqli_error($con));
		}

		$query = "CREATE TABLE " . TABEL_DOSEN . " (
				created_at DATETIME NOT NULL DEFAULT NOW(),
				updated_at DATETIME DEFAULT NULL,
				nip VARCHAR(30) NOT NULL PRIMARY KEY,
				code_name VARCHAR(10) DEFAULT NULL,
				user_id INT UNSIGNED NOT NULL, 
				FOREIGN KEY(user_id) REFERENCES " . TABEL_USER . "(id)
			);
			";
		if (!mysqli_query($con, $query)) {
			die(mysqli_error($con));
		}

		$query = "CREATE TABLE " . TABEL_MAHASISWA . " (
				created_at DATETIME NOT NULL DEFAULT NOW(),
				updated_at DATETIME DEFAULT NULL,
				nim VARCHAR(20) NOT NULL PRIMARY KEY,
				status VARCHAR (50) DEFAULT NULL,
				judul_ta VARCHAR(100) DEFAULT NULL,
				dosbing_1 VARCHAR(30) DEFAULT NULL,
				dosbing_2 VARCHAR(30) DEFAULT NULL,
				user_id INT UNSIGNED NOT NULL,
				FOREIGN KEY(user_id) REFERENCES " . TABEL_USER . "(id),
				FOREIGN KEY(dosbing_1) REFERENCES " . TABEL_DOSEN . "(nip),
				FOREIGN KEY(dosbing_2) REFERENCES " . TABEL_DOSEN . "(nip)
			);
			";
		if (!mysqli_query($con, $query)) {
			die(mysqli_error($con));
		}

		$query = "CREATE TABLE " . TABEL_PENGUMUMAN . " (
				id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
				created_at DATETIME NOT NULL DEFAULT NOW(),
				updated_at DATETIME DEFAULT NULL,
				release_at DATETIME DEFAULT NULL,
				created_by INT UNSIGNED NOT NULL,
				category VARCHAR(20) DEFAULT NULL,
				title VARCHAR(100) NOT NULL,
				info VARCHAR(1000) NOT NULL,
				attachment JSON DEFAULT NULL,
				notif_to JSON DEFAULT NULL,
				seen_by JSON DEFAULT NULL,
				FOREIGN KEY(created_by) REFERENCES " . TABEL_USER . "(id)
			);
			";
		if (!mysqli_query($con, $query)) {
			die(mysqli_error($con));
		}

		$query = "CREATE TABLE " . TABEL_BIMBINGAN . " (
				id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
				created_at DATETIME NOT NULL DEFAULT NOW(),
				updated_at DATETIME DEFAULT NULL,
				mahasiswa_nim VARCHAR(20) NOT NULL,
				judul_ta VARCHAR(100) DEFAULT NULL,
				dosen_nip VARCHAR(30) NOT NULL,
				waktu_bimbingan DATETIME DEFAULT NULL,
				disetujui_at DATETIME DEFAULT NULL,
				ditolak_at DATETIME DEFAULT NULL,
				selesai_at DATETIME DEFAULT NULL,
				keterangan_mahasiswa VARCHAR(200) DEFAULT NULL,
				keterangan_dosen VARCHAR(200) DEFAULT NULL,
				file_ta VARCHAR(200) DEFAULT NULL,
				FOREIGN KEY(mahasiswa_nim) REFERENCES " . TABEL_MAHASISWA . "(nim),
				FOREIGN KEY(dosen_nip) REFERENCES " . TABEL_DOSEN . "(nip)
			);
			";
		if (!mysqli_query($con, $query)) {
			die(mysqli_error($con));
		}

		$query = "CREATE TABLE " . TABEL_KARTU_KENDALI . " (
				id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
				created_at DATETIME NOT NULL DEFAULT NOW(),
				updated_at DATETIME DEFAULT NULL,
				mahasiswa_nim VARCHAR(20) NOT NULL,
				dosen_nip VARCHAR(30) NOT NULL,
				kegiatan VARCHAR(1000) DEFAULT NULL,
				request_paraf_at DATETIME DEFAULT NULL,
				paraf VARCHAR(20) DEFAULT NULL,
				diparaf_at DATETIME DEFAULT NULL,
				FOREIGN KEY(mahasiswa_nim) REFERENCES " . TABEL_MAHASISWA . "(nim),
				FOREIGN KEY(dosen_nip) REFERENCES " . TABEL_DOSEN . "(nip)
			);
			";
		if (!mysqli_query($con, $query)) {
			die(mysqli_error($con));
		}

		$query = "CREATE TABLE " . TABEL_REGISTER_STATUS . " (
				id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
				name VARCHAR(30) NOT NULL,
				code_name VARCHAR(30) NOT NULL,
				value FLOAT DEFAULT 0
			);
			";
		if (!mysqli_query($con, $query)) {
			die(mysqli_error($con));
		}

		$query = "CREATE TABLE " . TABEL_REGISTER_STAGE . " (
				id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
				name VARCHAR(30) NOT NULL,
				code_name VARCHAR(30) NOT NULL,
				value FLOAT DEFAULT 0
			);
			";
		if (!mysqli_query($con, $query)) {
			die(mysqli_error($con));
		}

		$query = "CREATE TABLE " . TABEL_PROGRES . " (
			id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
			created_at DATETIME NOT NULL DEFAULT NOW(),
			updated_at DATETIME DEFAULT NULL,
			mahasiswa_nim VARCHAR(20) NOT NULL,
			progres_data JSON DEFAULT NULL,
			FOREIGN KEY(mahasiswa_nim) REFERENCES " . TABEL_MAHASISWA . "(nim)
			)";
		if (!mysqli_query($con, $query)) {
			die(mysqli_error($con));
		}

		$query = "CREATE TABLE " . TABEL_FILES . " (
			id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
			created_at DATETIME NOT NULL DEFAULT NOW(),
			updated_at DATETIME DEFAULT NULL,
			file_name VARCHAR(200) NOT NULL, 
			description VARCHAR(200) DEFAULT NULL
			)";
		if (!mysqli_query($con, $query)) {
			die(mysqli_error($con));
		}

		mysqli_close($con);
		$this->load_data();
		echo "Reset Success";
	}

	public function load_data()
	{
		// user roles
		$user_roles = [
			['id' => 1, 'name' => 'tim_ta'],
			['id' => 2, 'name' => 'dosen'],
			['id' => 3, 'name' => 'mahasiswa']
		];
		if (!$this->db->insert_batch(TABEL_USER_ROLE, $user_roles)) {
		}
		// REGISTER STEP
		$prog_reg = [
			[
				'name' => '-',
				'code_name' => PROGRES_STATUS_INIT,
				'value' => 0
			],
			[
				'name' => 'Proses',
				'code_name' => PROGRES_STATUS_PROSES,
				'value' => 0.5
			],
			[
				'name' => 'Revisi',
				'code_name' => PROGRES_STATUS_REVISI,
				'value' => 0.5
			],
			[
				'name' => 'Disetujui',
				'code_name' => PROGRES_STATUS_SELESAI,
				'value' => 1
			],
		];
		if (!$this->db->insert_batch(TABEL_REGISTER_STATUS, $prog_reg)) {
		}

		// REGISTER STAGE
		$prog_reg = [
			[
				'name' => 'Bab I',
				'code_name' => 'bab_1',
				'value' => (11.11)
			],
			[
				'name' => 'Bab II',
				'code_name' => 'bab_2',
				'value' => (11.11)
			],
			[
				'name' => 'Bab III',
				'code_name' => 'bab_3',
				'value' => (11.11)
			],
			[
				'name' => 'Seminar Proposal',
				'code_name' => 'sempro',
				'value' => (0)
			],
			[
				'name' => 'Bab IV',
				'code_name' => 'bab_4',
				'value' => (44.45)
			],
			[
				'name' => 'Bab V',
				'code_name' => 'bab_5',
				'value' => (22.22)
			],
			[
				'name' => 'Sidang Akhir',
				'code_name' => 'semhas',
				'value' => (0)
			],
		];
		if (!$this->db->insert_batch(TABEL_REGISTER_STAGE, $prog_reg)) {
		}

		// user
		$new_user = $this->user_model->create('Dosen sampel 1', 'dosen1@simota.my.id', 2, SIMOTA_PASSWORD_DEFAULT);
		$new_dosen1 = $this->dosen_model->create('11111111111111111', 'AAA', $new_user->id);
		$new_user = $this->user_model->create('Dosen sampel 2', 'dosen2@simota.my.id', 2, SIMOTA_PASSWORD_DEFAULT);
		$new_dosen2 = $this->dosen_model->create('11111111111111112', 'AAB', $new_user->id);
		$new_userg = $this->user_model->create('Dosen sampel 44', 'dosen44@simota.my.id', 2, SIMOTA_PASSWORD_DEFAULT);
		$new_dosen11 = $this->dosen_model->create('11111111111111119', 'AAA', $new_userg->id);

		$new_user = $this->user_model->create('Dosen sampel 3', 'dosen3@simota.my.id', 1, SIMOTA_PASSWORD_DEFAULT);
		$new_timta1 = $this->dosen_model->create('11111111111111113', 'AAC', $new_user->id);
		$new_user = $this->user_model->create('Tim TA 1', 'timta1@simota.my.id', 1, SIMOTA_PASSWORD_DEFAULT);
		$new_timta2 = $this->dosen_model->create('11111111111111114', 'AAD', $new_user->id);

		$this->load->model('progres_model');
		$new_user = $this->user_model->create('Mahasiswa Satu', 'mahasiswa1@simota.my.id', 3, SIMOTA_PASSWORD_DEFAULT);
		$new_mahasiswa1 = $this->mahasiswa_model->create(
			'11111111',
			'Judul mhs 1 Lorem ipsum dolor sit amet consectetur adipisicing elit. Non, laboriosam.',
			$new_dosen1->nip,
			$new_timta2->nip,
			$new_user->id,
			'Baru'
		);

		$new_user = $this->user_model->create('Mahasiswa Dua', 'mahasiswa2@simota.my.id', 3, SIMOTA_PASSWORD_DEFAULT);
		$new_mahasiswa2 = $this->mahasiswa_model->create(
			'11111112',
			'Judul mhs 2 Lorem ipsum dolor sit amet consectetur adipisicing elit. Non, laboriosam.',
			$new_dosen2->nip,
			$new_timta2->nip,
			$new_user->id,
			'Baru'
		);

		// pengumuman
		$this->pengumuman_model->create(
			'Title Notif 1 Lorem ipsum dolor sit amet ',
			'Info notif 1 Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perferendis possimus doloribus facere iusto quibusdam ullam. Obcaecati assumenda nisi quod placeat necessitatibus at explicabo, velit odit perferendis suscipit quis consectetur ipsa? ',
			$new_timta1->user->id,
			'general',
			false,
			null,
			null
		);

		$this->pengumuman_model->create(
			'Title Notif 2 Lorem ipsum dolor sit amet ',
			'Info notif 2 Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perferendis possimus doloribus facere iusto quibusdam ullam. Obcaecati assumenda nisi quod placeat necessitatibus at explicabo, velit odit perferendis suscipit quis consectetur ipsa? ',
			$new_timta1->user->id,
			'general',
			false,
			null,
			null
		);

		$this->pengumuman_model->create(
			'Title Notif 3 Lorem ipsum dolor sit amet ',
			'Info notif 3 Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perferendis possimus doloribus facere iusto quibusdam ullam. Obcaecati assumenda nisi quod placeat necessitatibus at explicabo, velit odit perferendis suscipit quis consectetur ipsa? ',
			$new_timta2->user->id,
			'general',
			false,
			null,
			null
		);

		// BIMBINGAN
		$date = new DateTime('now');
		$this->load->model(['bimbingan_model', 'mailing_model']);
		$new_bimbingan1 = $this->bimbingan_model->create_permohonan(
			$new_mahasiswa1->nim,
			'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Repellat, dicta.',
			$new_mahasiswa1->dosbing_1->nip,
			$date->format('Y-m-d H:i:s'),
			'Lorem ipsum dolor sit amet consectetur adipisicing. ',
			''
		);
		$this->pengumuman_model->create_message_bimbingan_asked($new_bimbingan1->id);
		$this->mailing_model->send_mail_bimbingan_asked($new_bimbingan1->id);

		$new_bimbingan2 = $this->bimbingan_model->create_permohonan(
			$new_mahasiswa2->nim,
			'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Repellat, dicta.',
			$new_mahasiswa2->dosbing_1->nip,
			$date->format('Y-m-d H:i:s'),
			'Lorem ipsum dolor sit amet consectetur adipisicing. ',
			''
		);
		$this->pengumuman_model->create_message_bimbingan_asked($new_bimbingan2->id);
		$this->mailing_model->send_mail_bimbingan_asked($new_bimbingan2->id);

		$new_bimbingan3 = $this->bimbingan_model->create_permohonan(
			$new_mahasiswa1->nim,
			'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Repellat, dicta.',
			$new_mahasiswa1->dosbing_2->nip,
			$date->format('Y-m-d H:i:s'),
			'Lorem ipsum dolor sit amet consectetur adipisicing. ',
			''
		);
		$this->pengumuman_model->create_message_bimbingan_asked($new_bimbingan3->id);
		$this->mailing_model->send_mail_bimbingan_asked($new_bimbingan3->id);

		// KARTU KENDALI
		$date = new DateTime('2023-07-20 12:30:00');
		$pengumuman = [
			[
				'mahasiswa_nim' => '11111111',
				'dosen_nip' => '11111111111111111',
				'kegiatan' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Repellat, dicta.',
			],
			[
				'mahasiswa_nim' => '11111111',
				'dosen_nip' => '11111111111111111',
				'kegiatan' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Repellat, dicta.',
			],
			[
				'mahasiswa_nim' => '11111111',
				'dosen_nip' => '11111111111111111',
				'kegiatan' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Repellat, dicta.',
			],
			[
				'mahasiswa_nim' => '11111111',
				'dosen_nip' => '11111111111111111',
				'kegiatan' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Repellat, dicta.',
			],
		];
		if (!$this->db->insert_batch(TABEL_KARTU_KENDALI, $pengumuman)) {
		}
	}

	public function applyDocument()
	{
		$con = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);
		if (!$con) {
			die("Connection failed" . mysqli_connect_error());
		}

		if (!mysqli_query($con, 'USE ' . DB_NAME)) {
			die(mysqli_error($con));
		}

		// CLEAR DATABASE
		if (!mysqli_query($con, 'SET foreign_key_checks=0')) {
			die(mysqli_error($con));
		}
		if (!mysqli_query($con, 'DROP TABLE IF EXISTS ' . TABEL_FILES)) {
			die(mysqli_error($con));
		}
		if (!mysqli_query($con, 'SET foreign_key_checks=1')) {
			die(mysqli_error($con));
		}

		// CREATE DATABASES  
		$query = "CREATE TABLE " . TABEL_FILES . " (
			id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
			created_at DATETIME NOT NULL DEFAULT NOW(),
			updated_at DATETIME DEFAULT NULL,
			file_name VARCHAR(200) NOT NULL, 
			description VARCHAR(200) DEFAULT NULL
			)";
		if (!mysqli_query($con, $query)) {
			die(mysqli_error($con));
		}

		mysqli_close($con);
	}
}

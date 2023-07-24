<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pengumuman_model extends CI_Model
{
	private $_table = TABEL_PENGUMUMAN;

	// gets
	public function get_id($id)
	{
		$query = $this->db
			->where('id', $id)
			->get($this->_table);
		$pengumuman = $query->row();
		$pengumuman = $this->complete_data($pengumuman);
		return $pengumuman;
	}

	public function get_pengumumans()
	{
		$query = $this->db
			->order_by('release_at', 'desc')
			->get($this->_table);
		$pengumumans = $query->result();
		foreach ($pengumumans as $pengumuman) {
			$pengumuman = $this->complete_data($pengumuman);
		}
		return $pengumumans;
	}

	public function get_pengumuman_generals()
	{
		$query = $this->db
			->where('category', 'general')
			->order_by('release_at', 'desc')
			->get($this->_table);
		$pengumumans = $query->result();
		foreach ($pengumumans as $pengumuman) {
			$pengumuman = $this->complete_data($pengumuman);
		}
		return $pengumumans;
	}

	public function get_published_general()
	{
		$query = $this->db
			->where('release_at is not null')
			->where('category', 'general')
			->order_by('release_at', 'desc')
			->get($this->_table);
		$tmp_pengumumans = $query->result();
		$pengumumans = [];
		foreach ($tmp_pengumumans as $pengumuman) {
			$pengumuman = $this->complete_data($pengumuman);
			array_push($pengumumans, $pengumuman);
		}
		return $pengumumans;
	}

	public function get_published_general_unread_user_id($user_id)
	{
		$tmp_pengumumans = $this->get_published_general();
		$pengumumans = [];
		foreach ($tmp_pengumumans as $pengumuman) {
			if (!$this->check_is_read($pengumuman, $user_id))
				array_push($pengumumans, $pengumuman);
		}
		return $pengumumans;
	}

	public function get_personal_user_id($user_id)
	{
		$query = $this->db
			->where('category!=', 'general')
			->order_by('release_at', 'desc')
			->get($this->_table);
		$tmp_pengumumans = $query->result();
		$pengumumans = [];
		foreach ($tmp_pengumumans as $pengumuman) {
			$pengumuman = $this->complete_data($pengumuman);
			if ($this->check_owner($pengumuman, $user_id)) {
				array_push($pengumumans, $pengumuman);
			}
		}

		return $pengumumans;
	}

	public function get_personal_unread_user_id($user_id)
	{
		$tmp_pengumumans = $this->get_personal_user_id($user_id);
		$pengumumans = [];
		foreach ($tmp_pengumumans as $pengumuman) {
			if (!$this->check_is_read($pengumuman, $user_id))
				array_push($pengumumans, $pengumuman);
		}
		return $pengumumans;
	}

	public function get_pengumuman_creator_id($user_id)
	{
		$query = $this->db
			->where('created_by', $user_id)
			->order_by('release_at', 'desc')
			->get($this->_table);
		$pengumumans = $query->result();
		foreach ($pengumumans as $pengumuman) {
			$pengumuman = $this->complete_data($pengumuman);
		}

		return $pengumumans;
	}

	public function create($title, $info, $creator_user_id, $category = null, $immediate_release = null, $notif_to = null, $attachments = null)
	{
		if (is_null($category)) $category = '';
		if (is_null($immediate_release)) $immediate_release = false;
		if (is_null($notif_to)) $notif_to = [];
		if (is_null($attachments)) $attachments = [];

		$date = new DateTime('now');
		$data = [
			'title' => $title,
			'info' => $info,
			'attachment' => json_encode($attachments),
			'category' => $category,
			'created_by' => $creator_user_id,
			'created_at' => $date->format('Y-m-d H:i:s'),
			'notif_to' => json_encode($notif_to)
		];

		if ($immediate_release) {
			$data['release_at'] = $date->format('Y-m-d H:i:s');
		}

		if (!$this->db->insert($this->_table, $data)) {
			return [
				'status' => false,
				'message' => 'Gagal membuat pengumuman!'
			];
		}

		return [
			'status' => true,
			'message' => 'Berhasil membuat pengumuman! ' . ((!!$immediate_release) ? "Pengumuman diterbitkan" : "")
		];
	}

	public function create_message_bimbingan_asked($permohonan_id)
	{
		$permohonan = $this->bimbingan_model->get_bimbingan_id($permohonan_id);
		$dosen = $this->dosen_model->get_dosen_nip($permohonan->dosen_nip);
		$mahasiswa = $this->mahasiswa_model->get_mahasiswa_nim($permohonan->mahasiswa_nim);


		$info = 'Mahasiswa <strong>' . $mahasiswa->user->name . '</strong> telah mengajukan permohonan bimbingan. ';
		$info .= "Segera <a href='" . base_url('permohonan/') . "'>Periksa Permohonan</a>";
		$this->create(
			'Permohonan Bimbingan',
			$info,
			$mahasiswa->user->id,
			'bimbingan',
			1,
			[$dosen->user->id],
			[]
		);
	}

	public function create_message_bimbingan_accepted($bimbingan_id)
	{
		$this->load->model('bimbingan_model');

		$bimbingan = $this->bimbingan_model->get_bimbingan_id($bimbingan_id);
		$dosen = $this->dosen_model->get_dosen_nip($bimbingan->dosen_nip);
		$mahasiswa = $this->mahasiswa_model->get_mahasiswa_nim($bimbingan->mahasiswa_nim);

		$info = 'Permohonan Bimbingan anda kepada <strong>' . $dosen->user->name . '</strong>  telah disetujui. ';
		$info .= "Silakan <a href='" . base_url('bimbingan') . "'>Periksa Bimbingan</a>";
		$this->create(
			'Bimbingan Disetujui',
			$info,
			$dosen->user->id,
			'bimbingan',
			1,
			[$mahasiswa->user->id],
			[]
		);
	}

	public function create_message_bimbingan_finished($bimbingan_id, $kartu_kendali_id)
	{
		$this->load->model(['bimbingan_model', 'kartu_kendali_model']);

		$bimbingan = $this->bimbingan_model->get_bimbingan_id($bimbingan_id);
		$dosen = $this->dosen_model->get_dosen_nip($bimbingan->dosen_nip);
		$mahasiswa = $this->mahasiswa_model->get_mahasiswa_nim($bimbingan->mahasiswa_nim);
		$kartu = $this->kartu_kendali_model->get_kartu_id($kartu_kendali_id);

		$info = 'Bimbingan anda dengan <strong>' . $dosen->user->name . '</strong>  telah selesai. ';
		$info = 'Kegiatan Bimbingan telah ditambahkan ke riwayat kartu kendali. ';
		$info .= "Silakan periksa <a href='" . base_url('kartu_kendali') . "'>Kartu Kendali</a>";
		$this->create(
			'Bimbingan Selesai',
			$info,
			$dosen->user->id,
			'bimbingan',
			1,
			[$mahasiswa->user->id],
			[]
		);
	}

	public function create_message_bimbingan_rejected($bimbingan_id)
	{
		$this->load->model('bimbingan_model');

		$bimbingan = $this->bimbingan_model->get_bimbingan_id($bimbingan_id);
		$dosen = $this->dosen_model->get_dosen_nip($bimbingan->dosen_nip);
		$mahasiswa = $this->mahasiswa_model->get_mahasiswa_nim($bimbingan->mahasiswa_nim);

		$info = 'Permohonan Bimbingan anda kepada <strong>' . $dosen->user->name . '</strong>  telah ditolak. ';
		$info .= "Silakan <a href='" . base_url('bimbingan') . "'>Periksa Bimbingan</a>";

		$this->create(
			'Bimbingan Ditolak',
			$info,
			$dosen->user->id,
			'bimbingan',
			1,
			[$mahasiswa->user->id],
			[]
		);
	}

	public function create_message_kartu_sign_request($kartu_kendali_id)
	{
		$this->load->model('kartu_kendali_model');
		$kartu = $this->kartu_kendali_model->get_kartu_id($kartu_kendali_id);
		$dosen = $this->dosen_model->get_dosen_nip($kartu->dosen_nip);
		$mahasiswa = $this->mahasiswa_model->get_mahasiswa_nim($kartu->mahasiswa_nim);

		$info = 'Permintaan paraf kartu kendali dari <strong>' . $mahasiswa->user->name . '</strong>. ';
		$info .= "Silakan <a href='" . base_url('kartu_kendali/' . $kartu->id) . "'>Periksa Kartu Kendali</a>";

		$this->create(
			'Paraf Kartu Kendali',
			$info,
			$mahasiswa->user->id,
			'kartu_kendali',
			1,
			[$dosen->user->id],
			[]
		);
	}

	public function create_message_kartu_signed($kartu_kendali_id)
	{
		$this->load->model('kartu_kendali_model');
		$kartu = $this->kartu_kendali_model->get_kartu_id($kartu_kendali_id);
		$dosen = $this->dosen_model->get_dosen_nip($kartu->dosen_nip);
		$mahasiswa = $this->mahasiswa_model->get_mahasiswa_nim($kartu->mahasiswa_nim);

		$info = "<a href='" . base_url('kartu_kendali/' . $kartu->id) . "'>Kartu Kendali</a> <strong>' telah diparaf. ";

		$this->create(
			'Kartu kendali telah diparaf',
			$info,
			$dosen->user->id,
			'kartu_kendali',
			1,
			[$mahasiswa->user->id],
			[]
		);
	}

	public function update($pengumuman_id, $title, $info)
	{
		$date = new DateTime('now');

		$this->db->set('title', $title)
			->set('info', $info)
			->set('updated_at', $date->format('Y-m-d H:i:s'))
			->where('id', $pengumuman_id);
		$result = $this->db->update($this->_table);

		if (!$result) {
			return [
				'status' => false,
				'message' => 'Gagal mengupdate pengumuman!'
			];
		}

		return [
			'status' => true,
			'message' => 'Berhasil mengupdate pengumuman!'
		];
	}

	public function update_delete_file_id($id_pengumuman, $file_name)
	{
		$pengumuman = $this->get_id($id_pengumuman);
		if (!$pengumuman) return null;
		$attachment = $pengumuman->attachment;

		$tmp_attachment = array_diff($attachment, [$file_name]);
		$attachment = [];
		foreach ($tmp_attachment as $key => $value) {
			array_push($attachment, $value);
		}

		$this->db
			->set('attachment', json_encode($attachment))
			->where('id', $pengumuman->id);
		return $this->db->update($this->_table);
	}

	public function update_add_file_id($id_pengumuman, $file_name)
	{
		$pengumuman = $this->get_id($id_pengumuman);
		if (!$pengumuman) return null;
		$attachment = $pengumuman->attachment;

		array_push($attachment, $file_name);

		$this->db
			->set('attachment', json_encode($attachment))
			->where('id', $pengumuman->id);
		return $this->db->update($this->_table);
	}

	public function publish($id = null)
	{
		if (!$id) {
			return [
				'status' => false,
				'message' => 'Gagal menerbitkan pengumuman!'
			];
		}
		$date = new DateTime('now');

		$this->db
			->set('release_at', $date->format('Y-m-d H:i:s'))
			->set('category', 'general');
		$this->db->where('id', $id);
		$result = $this->db->update($this->_table);

		if (!$result) {
			return [
				'status' => false,
				'message' => 'Gagal menerbitkan pengumuman!'
			];
		}

		return [
			'status' => true,
			'message' => 'Berhasil menerbitkan pengumuman!'
		];
	}

	public function unpublish($id = null)
	{
		if (!$id) {
			return [
				'status' => false,
				'message' => 'Gagal menonaktifkan pengumuman!'
			];
		}

		$this->db->set('release_at', null);
		$this->db->where('id', $id);
		$result = $this->db->update($this->_table);

		if (!$result) {
			return [
				'status' => false,
				'message' => 'Gagal menonaktifkan!'
			];
		}

		return [
			'status' => true,
			'message' => 'Pengumuman telah dinonaktifkan!'
		];
	}

	public function update_add_seen_by($id_pengumuman, $reader_ids = [])
	{
		$pengumuman = $this->get_id($id_pengumuman);
		if (!$pengumuman) return false;

		if (!is_array($reader_ids)) {
			$reader_ids = [$reader_ids];
		}

		$seen_by = $pengumuman->seen_by;
		foreach ($reader_ids as $reader_id) {
			if (!in_array($reader_id, $seen_by)) {
				array_push($seen_by, $reader_id);
			}
		}

		$this->db
			->set('seen_by', json_encode($seen_by))
			->where('id', $pengumuman->id);
		return $this->db->update(TABEL_PENGUMUMAN);
	}

	// delete
	public function delete($id = null)
	{
		$this->db->where('id', $id);
		return $this->db->delete($this->_table);
	}

	// utils
	public function complete_data($pengumuman)
	{
		if (!$pengumuman) return null;
		if (is_null($pengumuman->attachment)) {
			$pengumuman->attachment = [];
		} else {
			$pengumuman->attachment = json_decode($pengumuman->attachment);
		}

		if (is_null($pengumuman->notif_to)) {
			$pengumuman->notif_to = [];
		} else {
			$pengumuman->notif_to = json_decode($pengumuman->notif_to);
		}

		if (is_null($pengumuman->seen_by)) {
			$pengumuman->seen_by = [];
		} else {
			$pengumuman->seen_by = json_decode($pengumuman->seen_by);
		}
		return $pengumuman;
	}

	public function check_owner($pengumuman, $user_id)
	{
		if (!$pengumuman->notif_to) {
			return false;
		}
		if (in_array($user_id, $pengumuman->notif_to)) {
			return true;
		}
	}

	public function check_is_read($pengumuman, $user_id)
	{
		if (!$pengumuman->seen_by) {
			return false;
		}
		if (in_array($user_id, $pengumuman->seen_by)) {
			return true;
		}
	}

	public function get_time_interval($txt_time = null)
	{
		if (is_null($txt_time)) return "";
		$time = new DateTime($txt_time);
		$now = new DateTime('now');

		$interval = $now->diff($time);

		$seconds = intval($interval->format('%S'));
		$minutes = intval($interval->format('%I'));
		$hours = intval($interval->format('%H'));
		$days = intval($interval->format('%d'));

		if ($days > 0) {
			return $days . ' hari';
		}
		if ($hours > 0) {
			return $hours . ' jam';
		}
		if ($minutes > 0) {
			return $minutes . ' menit';
		}
		if ($seconds > 0) {
			return $seconds . ' detik';
		}
	}

	public function rules_create()
	{
		return [
			[
				'field' => 'txtInfo',
				'label' => 'Info Pengumuman',
				'rules' => 'required'
			],
			[
				'field' => 'txtTitle',
				'label' => 'Judul Pengumuman',
				'rules' => 'required'
			],
		];
	}
}

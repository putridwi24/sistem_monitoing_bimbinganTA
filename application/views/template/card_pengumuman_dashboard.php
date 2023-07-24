<?php
$card = [];
$card_pengumuman_generals = $this->pengumuman_model->get_published_general();
$card_pengumuman_personals = $this->pengumuman_model->get_personal_user_id($this->auth_model->get_current_user_session()->id);

?>

<div class="row">
	<div class="col-12 col-md- connectedSortable">
		<!-- PENGUMUMAN -->
		<div class="card">
			<div class="card-header  ">
				<h3 class="card-title" style="color: #005643">
					<i class="fas fa-bullhorn mr-1"></i>
					<b>Pengumuman</b>
				</h3>
				<div class="card-tools">
					<!-- <button class="btn btn-primary btn-sm" onclick="pengumumanArsipkanSemua()">
						<i class="fas fa-archive mr-1"></i> Arsipkan semua
					</button> -->
				</div>
			</div>
			<!-- /.card-header -->
			<div class="card-body">
				<ul class="todo-list" data-widget="todo-list">
					<?php foreach ($card_pengumuman_generals as $pengumuman) { ?>
						<?php if (true || !$this->pengumuman_model->check_is_read($pengumuman, $this->auth_model->get_current_user_session()->id)) { ?>
							<li>
								<a href="<?= base_url('pengumuman/' . $pengumuman->id) ?>">
									<!-- waktu pengumuman -->
									<small class="badge badge-info">
										<i class="far fa-clock mr-1"></i>
										<?= $this->pengumuman_model->get_time_interval($pengumuman->release_at); ?>
									</small>
									<!-- teks pengumuman -->
									<span class="text"><?= $pengumuman->title ?></span>
								</a>
								<!-- <div class="tools">
									<button class="btn btn-primary btn-sm btn-arsipkan" onclick="pengumumanArsipkan(this)" idPengumuman="<?= $pengumuman->id ?>">
										<small>
											<i class="fas fa-archive"></i>
										</small>
									</button>
								</div> -->
							</li>
						<?php } ?>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div> 
</div>

<!-- /.card -->
<script>
	function pengumumanArsipkan(target) {
		var idPengumuman = $(target).attr('idPengumuman');
		var idPengumumans = [idPengumuman];
		$.ajax({
			type: 'post',
			url: "<?= base_url('pengumuman/archieve') ?>",
			data: {
				pengumumanIdJson: JSON.stringify(idPengumumans)
			},
			success: (data, status) => {
				location.reload();
			},
			error: (data) => {
				response = JSON.parse(data.responseText)
				console.log(response.message);
			}
		})
	}

	function pengumumanArsipkanSemua(target) {
		var buttons = $('.btn-arsipkan');
		var idPengumumans = [];
		buttons.each(index => {
			idPengumumans.push($(buttons[index]).attr('idPengumuman'));
		});
		$.ajax({
			type: 'post',
			url: "<?= base_url('pengumuman/archieve') ?>",
			data: {
				pengumumanIdJson: JSON.stringify(idPengumumans)
			},
			success: (data, status) => {
				location.reload();
			},
			error: (data) => {
				// response = JSON.parse(data.responseText)
				console.log(data.responseText);
			}
		})
	}
</script>

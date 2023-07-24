<?php $this->load->view('template/head', [
	'title' => 'Detail Mahasiswa ' . $mahasiswa->user->name,
]);
?>

<body class="sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
	<div class="wrapper">

		<!-- SIDEBAR -->
		<?php $this->load->view('template/sidebar', [
			'menu_name' => 'daftar_mahasiswa'
		]) ?>

		<!-- CONTENT -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0">Detail Mahasiswa</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
								<li class="breadcrumb-item"><a href="<?= base_url('mahasiswa') ?>">Mahasiswa</a></li>
								<li class="breadcrumb-item active">Detail</li>
							</ol>
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- /.container-fluid -->
			</div>
			<!-- /.content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					<?php $this->load->view('template/header_message') ?>
					<div class="row">
						<div class="col-12 col-md-11">
							<div class="card">
								<div class="card-header  ">
									<h3 class="card-title">
										<i class="fas fa-bullhorn mr-1"></i>
										<b>Data Akun</b>
									</h3>
									<div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse">
											<i class="fas fa-minus"></i>
										</button>
									</div>
								</div>
								<div class="card-body">
									<div class="w-100 d-flex flex-row justify-content-between">
										<div class="p-2">
											<p>
												<strong>Nama</strong>
												<br>
												<?php if ($mahasiswa->user->name) : ?>
													<span>
														<?= $mahasiswa->user->name ?>
													</span>
												<?php else : ?>
													<small><strong>Belum ditentukan</strong></small>
												<?php endif ?>
											</p>
											<p>
												<strong>NIM</strong>
												<br>
												<?php if ($mahasiswa->nim) : ?>
													<span>
														<?= $mahasiswa->nim ?>
													</span>
												<?php else : ?>
													<small><strong>Belum ditentukan</strong></small>
												<?php endif ?>
											</p>
											<p>
												<strong>Email</strong>
												<br>
												<?php if ($mahasiswa->user->email) : ?>
													<span>
														<?= $mahasiswa->user->email ?>
													</span>
												<?php else : ?>
													<small><strong>Belum ditentukan</strong></small>
												<?php endif ?>
											</p>
										</div>
										<div class="p-2 mr-2">
											<img class="img img-circle" src="<?= base_url(AVATAR_URL . $mahasiswa->user->avatar) ?>" alt="" style="width: 200px; height: 200px; object-fit:cover">
										</div>
									</div>
									<div class="">
										<button class="btn btn-sm btn-danger ml-auto" type="button" data-toggle="modal" data-target="#modal-reset-password">
											<i class="fas fa-key mr-1"></i>
											Reset Password
										</button>
										<button class="btn btn-sm btn-danger ml-auto" type="button" data-toggle="modal" data-target="#modal-hapus-mahasiswa">
											<i class="fas fa-trash mr-1"></i>
											Hapus Mahasiswa
										</button>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-11">
							<div class="card">
								<div class="card-header  ">
									<h3 class="card-title">
										<i class="fas fa-file mr-1"></i>
										<b>Data Tugas Akhir</b>
									</h3>
									<div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse">
											<i class="fas fa-minus"></i>
										</button>
									</div>
								</div>
								<div class="card-body ">
									<div class="w-100 d-flex flex-row justify-content-between">
										<div class="p-2">
											<p>
												<strong>Judul Tugas Akhir</strong>
												<br>
												<?php if ($mahasiswa->judul_ta) : ?>
													<span>
														<?= $mahasiswa->judul_ta ?>
													</span>
												<?php else : ?>
													<small><strong>Belum ditentukan</strong></small>
												<?php endif ?>
											</p>
											<p>
												<strong>Dosen Pembimbing 1</strong>
												<br>
												<?php if ($mahasiswa->dosbing_1) : ?>
													<span>
														<?= $mahasiswa->dosbing_1->user->name ?>
													</span>
												<?php else : ?>
													<small><strong>Belum ditentukan</strong></small>
												<?php endif ?>
											</p>
											<p>
												<strong>Dosen Pembimbing 2</strong>
												<br>
												<?php if ($mahasiswa->dosbing_2) : ?>
													<span>
														<?= $mahasiswa->dosbing_2->user->name ?>
													</span>
												<?php else : ?>
													<small><strong>Belum ditentukan</strong></small>
												<?php endif ?>
											</p>
										</div>
										<div class="text-center p-2 mr-2">
											<input type="text" class="knob" value="<?= $this->progres_model->calculate_percentage_progres_id($mahasiswa->progres->id) ?>%" data-width="200" data-height="200" data-fgColor="#932ab6" readonly>
											<div class="knob-label h5 mt-2"><?= $this->progres_model->calculate_percentage_progres_id($mahasiswa->progres->id) ?>%</div>
										</div>
									</div>
									<div class="">
										<button class="btn btn-sm btn-primary ml-auto" type="button" data-toggle="modal" data-target="#modal-ganti-dosbing">
											<i class="fas fa-users mr-1"></i>
											Ganti Dosen Pembimbing
										</button>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-11">
							<div class="card collapsed-card">
								<div class="card-header ">
									<h3 class="card-title">
										<i class="fas fa-hourglass-half mr-1"></i>
										<b>Progres Laporan</b>
									</h3>
									<div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse">
											<i class="fas fa-minus"></i>
										</button>
									</div>
								</div>
								<div class="card-body  ">
									<div class="d-flex flex-row justify-content-start ">
										<div class="d-flex flex-row justify-content-start ">
											<?php if ($mahasiswa->progres) { ?>
												<?php foreach ($mahasiswa->progres->progres_data as $stage => $status) { ?>
													<?php $this->load->view('template/smallbox_timeline_updater', ['stage' => $stage, 'status' => $status]) ?>
												<?php } ?>
											<?php } else { ?>
												<strong>Anda belum melengkapi data mahasiswa. Silakan melengkapi data mahasiswa pada <a href="<?= base_url('profile') ?>">Pengaturan Profil</a></strong>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-11">
							<div class="card collapsed-card">
								<div class="card-header ">
									<h3 class="card-title">
										<i class="fas fa-history mr-1"></i>
										<b>Riwayat Bimbingan</b>
									</h3>
									<div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse">
											<i class="fas fa-minus"></i>
										</button>
									</div>
								</div>
								<div class="card-body">
									<?php foreach ($bimbingan_historys as $key => $bimbingan) { ?>
										<div class="callout callout-info">
											<p>
												<span class="badge badge-light">Diajukan <?= $bimbingan->created_at ?></span>
												<?php if ($bimbingan->ditolak_at) { ?>
													<span class="badge badge-danger">Selesai <?= $bimbingan->selesai_at ?></span>
												<?php } ?>
												<?php if ($bimbingan->selesai_at) { ?>
													<span class="badge badge-success">Selesai <?= $bimbingan->selesai_at ?></span>
												<?php } ?>
											</p>
											<p>
												<span><strong>Keterangan Mahasiswa</strong></span><br>
												<?= $bimbingan->keterangan_mahasiswa ?>
											</p>
											<p>
												<span><strong>Keterangan Dosen | <?= $bimbingan->dosen->user->name ?></strong></span><br>
												<?= $bimbingan->keterangan_dosen ?>
											</p>
											<p>
												<span><strong>File Tugas Akhir</strong></span><br>
												<?php if ($bimbingan->file_ta) { ?>
													<a class="btn btn-sm btn-info" href="<?= base_url(URL_BIMBINGAN_ATTACHMENT . $bimbingan->file_ta) ?>">
														<i class="fas fa-file-alt p-1"></i>
														<span class="d-inline"> <?= $bimbingan->file_ta ?></span>
													</a>
												<?php } else { ?>
													<span class="badge badge-danger">Tidak ada file TA</span>
												<?php } ?>
											</p>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>

					<!-- /.row (main row) -->
				</div><!-- /.container-fluid -->
			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->
		<footer class="main-footer">
			<strong>Copyright &copy; Sistem Monitoring Bimbingan Tugas Akhir ITERA
			</strong>
			<div class="float-right d-none d-sm-inline-block">
				<b>Version</b> 3.2.0
			</div>
		</footer>

	</div>

	<div class="modal fade" id="modal-reset-password">
		<div class="modal-dialog">
			<div class="modal-content  ">
				<div class="modal-header">
					<h4 class="modal-title">Reset Password?</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Password untuk user <strong><?= $mahasiswa->user->name ?></strong> akan direset ke <strong>password</strong>
					</p>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
					<form action="<?= base_url('password_reset') ?>" method="post" id="formPasswordChange">
						<input type="hidden" name="userId" value="<?= $mahasiswa->user->id ?>">
						<button type="submit" class="btn btn-outline-light">Reset Sandi</button>
					</form>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>

	<div class="modal fade" id="modal-hapus-mahasiswa">
		<div class="modal-dialog">
			<div class="modal-content  ">
				<div class="modal-header">
					<h4 class="modal-title">Hapus <?= $mahasiswa->user->name ?>?</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="col-12 mb-2">
						Mahasiswa <strong><?= $mahasiswa->user->name ?></strong> akan <strong>DIHAPUS</strong> dari database!</strong>
					</div>
					<div class="col-12">
						<label for="txtAdminPassword">Masukkan Password Anda</label>
						<input class="form-control" type="password" name="txtAdminPassword" id="txtAdminPasswordInput">
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
					<form action="<?= base_url('mahasiswa/' . $mahasiswa->nim . '/delete') ?>" method="post" onsubmit="moveDataDeleteMahasiswa()">
						<input type="hidden" name="txtAdminPassword" value="dfgdfg" class="txtAdminPasswordField">
						<button type="submit" class="btn btn-danger">Hapus Mahasiswa</button>
					</form>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>

	<div class=" modal fade" id="modal-ganti-dosbing">
		<div class="modal-dialog">
			<div class="modal-content  ">
				<div class="modal-header">
					<h4 class="modal-title">Ganti dosen pembimbing <?= $mahasiswa->user->name ?></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<!-- dosen pembimbing -->
					<div class="form-group row">
						<label class="col-12 col-lg-3 col-form-label" for="txtDosbing">Dosen Pembimbing 1</label>
						<div class="col-12 col-lg-9">
							<select class="form-control" name="txtDosbing" id="dosbing1NipInput">
								<option class="fw-bold" selected value="<?= $mahasiswa->dosbing_1->nip ?>"><?= $mahasiswa->dosbing_1->user->name ?></option>
								<?php foreach ($dosens as $key => $dosen) { ?>
									<?php if ($dosen->nip !== $mahasiswa->dosbing_1->nip) : ?>
										<option value="<?= $dosen->nip ?>"><?= $dosen->user->name ?></option>
									<?php endif ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<!-- dosen pembimbing -->
					<div class="form-group row">
						<label class="col-12 col-lg-3 col-form-label" for="txtDosbing">Dosen Pembimbing 2</label>
						<div class="col-12 col-lg-9">
							<select class="form-control" name="txtDosbing" id="dosbing2NipInput">
								<option class="fw-bold" selected value="<?= $mahasiswa->dosbing_2->nip ?>"><?= $mahasiswa->dosbing_2->user->name ?></option>
								<?php foreach ($dosens as $key => $dosen) { ?>
									<?php if ($dosen->nip !== $mahasiswa->dosbing_2->nip) : ?>
										<option value="<?= $dosen->nip ?>"><?= $dosen->user->name ?></option>
									<?php endif ?>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
					<form action="<?= base_url('mahasiswa/' . $mahasiswa->nim . '/dosbing/update') ?>" method="post" onsubmit="moveDataGantiDosbing()">
						<input type="hidden" name="mahasiswaNim" value="<?= $mahasiswa->nim ?>">
						<input type="hidden" name="dosbing1Nip" value="" class="dosbing1NipField">
						<input type="hidden" name="dosbing2Nip" value="" class="dosbing2NipField">
						<button type="submit" class="btn btn-primary">
							<i class="fas fa-check mr-1"></i>
							Ganti Dosen Pembimbing
						</button>
					</form>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<?php $this->load->view('template/tile') ?>
	<script>
		$(function() {
			/* jQueryKnob */

			$('.knob').knob({})
			/* END JQUERY KNOB */
		})

		function moveDataGantiDosbing() {
			var dosbing1Nip = $('#dosbing1NipInput').val();
			var dosbing2Nip = $('#dosbing2NipInput').val();
			$('.dosbing1NipField').val(dosbing1Nip);
			$('.dosbing2NipField').val(dosbing2Nip);
		}

		function moveDataDeleteMahasiswa() {
			var adminPassword = $('#txtAdminPasswordInput').val();
			$('.txtAdminPasswordField').val(adminPassword);
		}
	</script>
</body>

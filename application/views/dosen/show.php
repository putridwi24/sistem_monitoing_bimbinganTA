<?php $this->load->view('template/head', [
	'title' => 'Profil',
]);

?>

<body class="sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
	<div class="wrapper">

		<!-- SIDEBAR -->
		<?php $this->load->view('template/sidebar', [
			'menu_name' => 'daftar_dosen'
		]) ?>

		<!-- CONTENT -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0">Detail Dosen </h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
								<li class="breadcrumb-item"><a href="<?= base_url('dosen') ?>">Dosen</a></li>
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
						<div class="col-12 col-lg-11">
							<div class="card">
								<div class="card-header">
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
									<div class="w-100 d-flex flex-row align-items-center justify-content-between">
										<div class="p-2">
											<p>
												<strong>Nama Dosen</strong>
												<br>
												<?php if ($dosen->user->name) : ?>
													<span>
														<?= $dosen->user->name ?>
													</span>
												<?php else : ?>
													<small><strong>Belum ditentukan</strong></small>
												<?php endif ?>
											</p>
											<p>
												<strong>NIP</strong>
												<br>
												<?php if ($dosen->nip) : ?>
													<span>
														<?= $dosen->nip ?>
													</span>
												<?php else : ?>
													<small><strong>Belum ditentukan</strong></small>
												<?php endif ?>
											</p>
											<p>
												<strong>Email</strong>
												<br>
												<?php if ($dosen->user->email) : ?>
													<span>
														<?= $dosen->user->email ?>
													</span>
												<?php else : ?>
													<small><strong>Belum ditentukan</strong></small>
												<?php endif ?>
											</p>
										</div>
										<div class="p-2 mr-2">
											<img class="img img-circle" src="<?= base_url(AVATAR_URL . $dosen->user->avatar) ?>" alt="" style="width: 200px; height: 200px; object-fit:cover">
										</div>
									</div>
									<div class="">
										<button class="btn btn-sm btn-danger ml-auto" type="button" data-toggle="modal" data-target="#modal-reset-password">
											<i class="fas fa-key mr-1"></i>
											Reset Password
										</button>
										<button class="btn btn-sm btn-danger ml-auto" type="button" data-toggle="modal" data-target="#modal-hapus-dosen">
											<i class="fas fa-trash mr-1"></i>
											Hapus Dosen
										</button>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-lg-11">
							<div class="card collapsed-card">
								<div class="card-header">
									<h3 class="card-title">
										<i class="fas fa-users mr-1"></i>
										<b>Mahasiswa Bimbingan 1</b>
										<span class="badge badge-info"><?= count($bimbingan1) ?></span>
									</h3>
									<div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse">
											<i class="fas fa-minus"></i>
										</button>
									</div>
								</div>
								<div class="card-body">

									<?php foreach ($bimbingan1 as $key => $mahasiswa) { ?>
										<div class="callout callout-info">
											<div class="d-flex flex-row justify-content-between">
												<div class="p-2">
													<h5>
														<a class=" " href="<?= base_url('mahasiswa/' . $mahasiswa->nim) ?>">
															<?= $mahasiswa->user->name ?>
														</a>
													</h5>
													<div class="progress-group mb-2">
														<strong>
															Progres Tugas Akhir
														</strong>
														<div class="d-flex flex-row justify-content-between">
															<small>
																<?= $this->progres_model->generate_status_report_progres_id($mahasiswa->progres->id) ?>
															</small>
															<small>
																<?= $this->progres_model->calculate_percentage_progres_id($mahasiswa->progres->id) ?> %
															</small>
														</div>
														<div class="progress progress-sm">
															<div class="progress-bar bg-primary" style="width: <?= $this->progres_model->calculate_percentage_progres_id($mahasiswa->progres->id) ?>%">
															</div>
														</div>
													</div>
													<div class="mb-2">
														<strong>Informasi Bimbingan</strong>
														<br>
														<span>
															Dengan <?= $dosen->user->name ?>: <strong><?= count($mahasiswa->bimbingans_dosen) ?></strong>
														</span>
														<br>
														<span>
															Seluruhnya: <strong><?= count($mahasiswa->bimbingans) ?></strong>
														</span>
													</div>
													<div class="mb-2">
														<strong>Informasi Kartu Kendali</strong>
														<br>
														<span>
															Dengan <?= $dosen->user->name ?>: <strong><?= count($mahasiswa->kartus_dosen) ?></strong>
														</span>
														<br>
														<span>
															Seluruhnya: <strong><?= count($mahasiswa->kartus) ?> </strong>
														</span>
													</div>
												</div>
												<div class="p-2 mr-2">
													<img class="img img-circle" src="<?= base_url(AVATAR_URL . $mahasiswa->user->avatar) ?>" alt="" style="width: 150px; height: 150px; object-fit:cover">
												</div>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="col-12 col-lg-11">
							<div class="card collapsed-card">
								<div class="card-header">
									<h3 class="card-title">
										<i class="fas fa-users mr-1"></i>
										<b>Mahasiswa Bimbingan 2</b>
										<span class="badge badge-info"><?= count($bimbingan2) ?></span>
									</h3>
									<div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse">
											<i class="fas fa-minus"></i>
										</button>
									</div>
								</div>
								<div class="card-body">
									<?php foreach ($bimbingan2 as $key => $mahasiswa) { ?>
										<div class="callout callout-info">
											<div class="d-flex flex-row justify-content-between">
												<div class="p-2">
													<h5>
														<a class=" " href="<?= base_url('mahasiswa/' . $mahasiswa->nim) ?>">
															<?= $mahasiswa->user->name ?>
														</a>
													</h5>
													<div class="progress-group mb-2">
														<strong>
															Progres Tugas Akhir
														</strong>
														<div class="d-flex flex-row justify-content-between">
															<small>
																<?= $this->progres_model->generate_status_report_progres_id($mahasiswa->progres->id) ?>
															</small>
															<small>
																<?= $this->progres_model->calculate_percentage_progres_id($mahasiswa->progres->id) ?> %
															</small>
														</div>
														<div class="progress progress-sm">
															<div class="progress-bar bg-primary" style="width: <?= $this->progres_model->calculate_percentage_progres_id($mahasiswa->progres->id) ?>%">
															</div>
														</div>
													</div>
													<div class="mb-2">
														<strong>Informasi Bimbingan</strong>
														<br>
														<span>
															Dengan <?= $dosen->user->name ?>: <strong><?= count($mahasiswa->bimbingans_dosen) ?></strong>
														</span>
														<br>
														<span>
															Seluruhnya: <strong><?= count($mahasiswa->bimbingans) ?></strong>
														</span>
													</div>
													<div class="mb-2">
														<strong>Informasi Kartu Kendali</strong>
														<br>
														<span>
															Dengan <?= $dosen->user->name ?>: <strong><?= count($mahasiswa->kartus_dosen) ?></strong>
														</span>
														<br>
														<span>
															Seluruhnya: <strong><?= count($mahasiswa->kartus) ?> </strong>
														</span>
													</div>
												</div>
												<div class="p-2 mr-2">
													<img class="img img-circle" src="<?= base_url(AVATAR_URL . $mahasiswa->user->avatar) ?>" alt="" style="width: 150px; height: 150px; object-fit:cover">
												</div>
											</div>
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
			<strong>Copyright &copy; Sistem Monitoring Bimbingan Tugas Akhir IF ITERA
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
					<p>Password untuk user <strong><?= $dosen->user->name ?></strong> akan direset ke <strong>password</strong>
					</p>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
					<form action="<?= base_url('password_reset') ?>" method="post" id="formPasswordChange">
						<input type="hidden" name="userId" value="<?= $dosen->user->id ?>">
						<button type="submit" class="btn btn-outline-light">Reset password</button>
					</form>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->

	<div class="modal fade" id="modal-hapus-dosen">
		<div class="modal-dialog">
			<div class="modal-content  ">
				<div class="modal-header">
					<h4 class="modal-title">Hapus <?= $dosen->user->name ?>?</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="col-12 mb-2">
						Dosen <strong><?= $dosen->user->name ?></strong> akan <strong>DIHAPUS</strong> dari database!</strong>
					</div>
					<div class="col-12">
						<label for="txtAdminPassword">Masukkan Password Anda</label>
						<input class="form-control" type="password" name="txtAdminPassword" id="txtAdminPasswordInput">
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
					<form action="<?= base_url('dosen/' . $dosen->nip . '/delete') ?>" method="post" onsubmit="moveDataDeleteDosen()">
						<input type="hidden" name="txtAdminPassword" value="dfgdfg" class="txtAdminPasswordField">
						<button type="submit" class="btn btn-danger">Hapus Dosen</button>
					</form>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<?php $this->load->view('template/tile') ?>
	<script>
		function moveDataDeleteDosen() {
			var adminPassword = $('#txtAdminPasswordInput').val();
			$('.txtAdminPasswordField').val(adminPassword);
		}
	</script>
</body>

<?php
if (!isset($user)) $user = $this->auth_model->get_current_user_session();
if (!isset($role)) $role = $this->role_model->get_role_id($user->role)->name;

$this->load->view('template/head', [
	'title' => 'Profile',
]);
?>

<body class="sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
	<div class="wrapper">

		<!-- SIDEBAR -->
		<?php $this->load->view('template/sidebar', [
			'menu_name' => 'profile'
		]) ?>

		<!-- CONTENT -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0">Profile </h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?php echo base_url($role . '/beranda') ?>">Beranda</a></li>
								<li class="breadcrumb-item active">Profil </li>

							</ol>
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- /.container-fluid -->
			</div>
			<!-- /.content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">

					<?php if ($this->session->flashdata('message_error')) : ?>
						<div class="alert alert-danger" role="alert">
							<?= $this->session->flashdata('message_error') ?>
						</div>
					<?php endif ?>
					<?php if ($this->session->flashdata('message_success')) : ?>
						<div class="alert alert-success" role="alert">
							<?= $this->session->flashdata('message_success') ?>
						</div>
					<?php endif ?>
					<div class="row">
						<div class="col-12 col-md-11">
							<div class="card">
								<div class="card-body">
									<div class="d-flex flex-row justify-content-end">
										<a class="btn btn-primary" href="<?php echo base_url('profile/edit') ?>">Edit Profile</a>
									</div>
									<div class="card-body">
										<div class="w-100  d-flex flex-row align-items-center justify-content-between">
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
												<p>
													<strong>NIM</strong>
													<br>
													<?php if ($mahasiswa->nim) : ?>
														<?= $mahasiswa->nim ?>
													<?php else : ?>
														<small><strong>Belum ditentukan</strong></small>
													<?php endif ?>
												</p>
												<p>
													<strong>Judul TA</strong>
													<br>
													<?php if ($mahasiswa->judul_ta) : ?>
														<?= $mahasiswa->judul_ta ?>
													<?php else : ?>
														<small><strong>Belum ditentukan</strong></small>
													<?php endif ?>
												</p>
												<p>
													<strong>Dosen Pembimbing 1</strong>
													<br>
													<?php if ($mahasiswa->dosbing_1) : ?>
														<?= $mahasiswa->dosbing_1->user->name ?>
													<?php else : ?>
														<small><strong>Belum ditentukan</strong></small>
													<?php endif ?>
												</p>
												<p>
													<strong>Dosen Pembimbing 2</strong>
													<br>
													<?php if ($mahasiswa->dosbing_2) : ?>
														<?= $mahasiswa->dosbing_2->user->name ?>
													<?php else : ?>
														<small><strong>Belum ditentukan</strong></small>
													<?php endif ?>
												</p>
											</div>
											<div class="p-2 mr-2">
												<img class="img img-circle" src="<?= base_url(AVATAR_URL . $mahasiswa->user->avatar) ?>" alt="" style="width: 200px; height: 200px; object-fit:cover">
											</div>
										</div>
									</div>
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
	<?php $this->load->view('template/tile') ?>
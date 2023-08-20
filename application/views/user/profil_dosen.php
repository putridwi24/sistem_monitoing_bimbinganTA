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
							<h1 class="m-0">Profil dosen</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?php echo base_url($role . '/beranda') ?>">Beranda</a></li>
								<li class="breadcrumb-item active">Profil Dosen</li>

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
										<a class="btn btn-primary" href="<?php echo base_url('profile/edit') ?>">
											<i class="fas fa-edit"></i>
											Edit Profile
										</a>
									</div>
									<div class="card-body">
										<div class="w-100  d-flex flex-row align-items-center justify-content-between">
											<div class="p-2">
												<p>
													<strong>Nama</strong>
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
									</div>
								</div>
							</div>
						</div>
					</div>
 
				</div>
				<!-- container-fluid -->
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

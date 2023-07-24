<?php
if (!isset($user)) $user = $this->auth_model->get_current_user_session();
if (!isset($role)) $role = $this->role_model->get_role_id($user->role)->name;

$this->load->view('template/head', [
	'title' => 'Profil',
]);
?>

<body class="sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
	<div class="wrapper">

		<!-- SIDEBAR -->
		<?php $this->load->view('template/sidebar', [
			'menu_name' => 'profil'
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
						<div class="col-12">
							<div class="card">
								<div class="p-2">
									<a class="btn btn-primary float-right" href="<?php echo base_url('profil/edit') ?>">Edit Profile</a>
								</div>
								<div class="card-body d-flex flex-row align-items-center">

									<div class="p-2 mr-2">
										<img class="img img-circle" src="<?= base_url(AVATAR_URL . $user->avatar)  ?>" alt="" style="width: 200px; height: 200px; object-fit: cover">
									</div>
									<div class="p-2">
										<table class="table text-wrap table-md table-borderless">
											<tr>
												<td>Nama</td>
												<td><?= $user->name ?></td>
											</tr>
											<tr>
												<td>Email</td>
												<td><?= $user->email ?></td>
											</tr>

											<?php if ($role == 'mahasiswa' && isset($mahasiswa)) { ?>
												<tr>
													<td>NIM</td>
													<td><?= $mahasiswa->nim ?></td>
												</tr>
												<tr>
													<td>Judul TA</td>
													<td><?= $mahasiswa->judul_ta ?></td>
												</tr>
												<tr>
													<td>Dosen Pembimbing I</td>
													<td><?= $mahasiswa->dosbing_2 ?></td>
												</tr>
												<tr>
													<td>Dosen Pembimbing II</td>
													<td><?= $mahasiswa->dosbing_2 ?></td>
												</tr>
											<?php } ?>

											<?php if (($role == 'tim_ta' || $role == 'dosen') && isset($dosen)) { ?>
												<tr>
													<td>NIP</td>
													<td><?= $dosen->nip ?></td>
												</tr>
											<?php } ?>
										</table>

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
			<strong>Copyright &copy; Sistem Monitoring Bimbingan Tugas Akhir ITERA
			</strong>
			<div class="float-right d-none d-sm-inline-block">
				<b>Version</b> 3.2.0
			</div>
		</footer>

	</div>
	<?php $this->load->view('template/tile') ?>
<?php
if (!isset($user)) $user = $this->auth_model->get_current_user_session();
if (!isset($role)) $role = $this->role_model->get_role_id($user->role)->name;

$this->load->view('template/head', [
	'title' => 'Beranda Mahasiswa',
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
								<li class="breadcrumb-item"><a href="<?php echo base_url('mahasiswa/beranda') ?>">Beranda</a></li>
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
					<div class="row">
						<div class="col-12 col-md-10">
							<div class="card">
								<!-- /.card-header -->
								<div class="card-body ">

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
									<div class="d-flex">
										<div class="p-2 w-100">
											<form action="<?= base_url('profile/password') ?>" method="post">
												<div class="form-group row">
													<label class="col-12 col-lg-3 col-form-label text-lg-left" for="txtPasswordOld">Password Lama</label>
													<div class="col-12 col-lg-9">
														<input type="password" class="form-control <?= form_error('txtPasswordOld') ? 'is-invalid' : '' ?>  " name="txtPasswordOld" id="txtPasswordOld">
														<div class=" invalid-feedback">
															<?= form_error('txtPasswordOld'); ?>
														</div>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-12 col-lg-3 col-form-label text-lg-left" for="txtPasswordNew">Password Baru</label>
													<div class="col-12 col-lg-9">
														<input type="password" class="form-control <?= form_error('txtPasswordNew') ? 'is-invalid' : '' ?>" name="txtPasswordNew" id="txtPasswordNew">
														<div class=" invalid-feedback">
															<?= form_error('txtPasswordNew'); ?>
														</div>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-12 col-lg-3 col-form-label text-lg-left" for="txtPasswordNewConfirm">Konfirmasi Password Baru</label>
													<div class="col-12 col-lg-9">
														<input type="password" class="form-control <?= form_error('txtPasswordNewConfirm') ? 'is-invalid' : '' ?>" name="txtPasswordNewConfirm" id="txtPasswordNewConfirm">
														<div class="invalid-feedback">
															<?= form_error('txtPasswordNewConfirm'); ?>
														</div>
													</div>
												</div>

												<div class="d-flex flex-column align-items-end">
													<!-- /.col -->
													<div class="">
														<button type="submit" class="btn btn-primary btn-block" style="background-color: #3C455C">Ganti Password</button>
													</div>
												</div>
											</form>
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

	<script>
		$('#fileAvatar').change((event) => {
			target = event.target;
			if (target.files && target.files[0]) {
				var reader = new FileReader();
				var filename = $(target).val();
				filename = filename.substring(filename.lastIndexOf('\\') + 1);
				reader.onload = (e) => {
					console.log("ow");
					$('#fileAvatarPreview').attr('src', e.target.result);
					$('#fileAvatarPreviewName').text(filename);
				}
				reader.readAsDataURL(target.files[0]);
			}
		});
	</script>

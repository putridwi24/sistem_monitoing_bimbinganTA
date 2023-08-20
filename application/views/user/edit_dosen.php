<?php
if (!isset($user)) $user = $this->auth_model->get_current_user_session();
if (!isset($role)) $role = $this->role_model->get_role_id($user->role)->name;

$this->load->view('template/head', [
	'title' => 'Edit profil dosen',
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
								<li class="breadcrumb-item"><a href="<?php echo base_url('profile') ?>">Profil</a> </li>
								<li class="breadcrumb-item active">Edit </li>

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
								<!-- /.card-header -->
								<div class="card-body">
									<div class="row p-4">
										<div class="col-12 mb-4">
											<div class="row">
												<div class="col-0 col-lg-3">
												</div>
												<div class="col-0 col-lg-9 d-flex flex-column align-items-center">
													<img class="img img-circle p-2 mb-2" id="imgAvatarPreview" src="<?= base_url(AVATAR_URL . $user->avatar)  ?>" alt="" style="width: 200px; height: 200px; object-fit: cover;">
													<form class="w-100" action="<?= base_url('avatar/update') ?>" method="post" enctype="multipart/form-data">
														<input type="hidden" name="idUser" value="<?= $user->id ?>">
														<div class="input-group w-100">
															<div class="custom-file">
																<input type="file" class="custom-file-input" id="imgAvatar" name="imgAvatar" accept=".jpg, .jpeg, .png">
																<label class="custom-file-label" for="imgAvatar" id="imgAvatarPreviewName">Pilih avatar</label>
															</div>
															<div class="input-group-append">
																<button class="btn btn-outline-secondary" type="submit">Update</button>
															</div>
														</div>
													</form>
												</div>
											</div>
										</div>
										<div class="col-12 mb-4">
											<form action="<?= base_url('profile/edit') ?>" method="post" novalidate>
												<div class="form-group row">
													<label class="col-12 col-lg-3 col-form-label text-lg-right" for="txtName">Nama Lengkap</label>
													<div class="col-12 col-lg-9 ">
														<input type="text" class="form-control <?= form_error('txtName') ? 'is-invalid' : '' ?>" name="txtName" id="txtName" required value="<?= $user->name ?>">
														<div class="invalid-feedback">
															<?= form_error('txtName'); ?>
														</div>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-12 col-lg-3 col-form-label text-lg-right" for="txtEmail">Email</label>
													<div class="col-12 col-lg-9">
														<input type="email" class="form-control <?= form_error('txtEmail') ? 'is-invalid' : '' ?>" name="txtEmail" id="txtEmail" disabled value="<?= $user->email ?>">
														<div class="invalid-feedback">
															<?= form_error('txtEmail'); ?>
														</div>
													</div>
												</div>

												<?php if ($dosen) { ?>
													<div class="form-group row">
														<label class="col-12 col-lg-3 col-form-label text-lg-right" for="txtNip">NIP</label>
														<div class="col-12 col-lg-9">
															<input type="text" class="form-control <?= form_error('txtNip') ? 'is-invalid' : '' ?>" name="txtNip" id="txtNip" disabled value="<?= set_value('txtNip') ? set_value('txtNip') : ($dosen->nip ? $dosen->nip : '') ?>">
															<div class="invalid-feedback">
																<?= form_error('txtNip'); ?>
															</div>
														</div>
													</div>
												<?php } else { ?>
													<div class="form-group row">
														<label class="col-12 col-lg-3 col-form-label text-lg-right" for="txtNip">NIP</label>
														<div class="col-12 col-lg-9">
															<input type="text" class="form-control <?= form_error('txtNip') ? 'is-invalid' : '' ?>" name="txtNip" id="txtNip" required value="<?= set_value('txtNip') ?>">
															<div class="invalid-feedback">
																<?= form_error('txtNip'); ?>
															</div>
														</div>
													</div>
												<?php } ?>
												<div class="row">
													<div class="col-0 col-lg-3"></div>
													<div class="col-12 col-lg-9 mt-2 d-flex flex-row justify-content-between no-stretch">
														<div>
															<a class="btn btn-primary" href="<?= base_url('profile/password') ?>">
																<i class="fas fa-key"></i>
																Ganti Password
															</a>
														</div>
														<div>
															<button type="submit" class="btn btn-primary">
																<i class="fas fa-save"></i>
																Simpan
															</button>
														</div>
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
		$('#imgAvatar').change((event) => {
			target = event.target;
			if (target.files && target.files[0]) {
				var reader = new FileReader();
				var filename = $(target).val();
				filename = filename.substring(filename.lastIndexOf('\\') + 1);
				reader.onload = (e) => {
					console.log("ow");
					$('#imgAvatarPreview').attr('src', e.target.result);
					$('#imgAvatarPreviewName').text(filename);
				}
				reader.readAsDataURL(target.files[0]);
			}
		});
	</script>

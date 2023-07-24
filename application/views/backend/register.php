<?php $this->load->view(
	'template/head',
	['title' => 'Register Sistem Monitoring Bimbingan Tugas Akhir']
)
?>
<style>
	body {
		background: url('https://www.itera.ac.id/wp-content/uploads/2020/01/4-1024x683.jpg');
		padding-top: 100px;
		background-size: cover;
	}

	.register-card {
		align-self: center;
		min-width: 600px;
		max-width: 1000px;
	}
</style>

<body class="hold-transition">
	<div class="container d-flex justify-content-center">
		<div class="card register-card">
			<div class="login-logo mt-3">
				<strong>
					Buat Akun
				</strong>
			</div>
			<div class="card-body login-card-body">

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
				<form method="post" action="register" novalidate>
					<div class="form-group row">
						<label class="col-4 col-form-label" for="txtName">Nama Lengkap</label>
						<div class="col-8">
							<input type="text" class="form-control <?= form_error('txtName') ? 'is-invalid' : '' ?>" name="txtName" id="txtName" value="<?= set_value('txtName') ?>">
							<div class="invalid-feedback">
								<?= form_error('txtName') ?>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-4 col-form-label" for="txtEmail">Email</label>
						<div class="col-sm-8">
							<input type="email" class="form-control <?= form_error('txtEmail') ? 'is-invalid' : '' ?>" name="txtEmail" id="txtEmail" placeholder="someone@somewhere.itera.ac.id" value="<?= set_value('txtEmail') ?>">
							<div class="invalid-feedback">
								<?= form_error('txtEmail') ?>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-4 col-form-label" for="txtUsername">Username</label>
						<div class="col-sm-8">
							<input type="email" class="form-control <?= form_error('txtUsername') ? 'is-invalid' : '' ?>" name="txtUsername" id="txtUsername" placeholder="" value="<?= set_value('txtUsername') ?>">
							<div class="invalid-feedback">
								<?= form_error('txtUsername') ?>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-4 col-form-label" for="txtTel">No. Telepon</label>
						<div class="col-sm-8">
							<input class="form-control <?= form_error('txtTel') ? 'is-invalid' : '' ?>" type="tel" name="txtTel" id="txtTel" value="<?= set_value('txtTel') ?>">
							<div class="invalid-feedback">
								<?= form_error('txtTel') ?>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-4 col-form-label" for="txtPassword">Password</label>
						<div class="col-sm-8">
							<input class="form-control <?= form_error('txtPassword') ? 'is-invalid' : '' ?>" type="password" name="txtPassword" id="txtPassword" value="<?= set_value('txtPassword') ?>">
							<div class="invalid-feedback">
								<?= form_error('txtPassword') ?>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-4 col-form-label" for="txtPasswordConfirm">Konfirmasi Password</label>
						<div class="col-sm-8">
							<input class="form-control <?= form_error('txtPasswordConfirm') ? 'is-invalid' : '' ?>" type="password" name="txtPasswordConfirm" id="txtPasswordConfirm" value="<?= set_value('txtPasswordConfirm') ?>">
							<div class="invalid-feedback">
								<?= form_error('txtPasswordConfirm') ?>
							</div>
						</div>
					</div>

					<div class="d-flex flex-column align-items-end">
						<!-- /.col -->
						<div class="">
							<button type="submit" class="btn btn-primary btn-block">Daftar</button>
						</div>
						<!-- /.col -->
						<p class="mb-0 mt-3">
							<a href="login" class="text-center">Sudah punya akun? Login di sini</a>
						</p>
					</div>
				</form>
			</div>
		</div>
		<!-- /.login-card-body -->
	</div>

	</div>
	<!-- /.login-box -->
	<?php $this->load->view('template/tile') ?>

</body>
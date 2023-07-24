<?php $this->load->view(
	'template/head',
	['title' => 'Buat Password Baru']
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
					Buat Password Baru
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
				<form method="post" action="<?= base_url('password_reset?token=' . $token) ?>" novalidate>
					<input type="hidden" name="token" value="<?= $token ?>">
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
							<button type="submit" class="btn btn-primary btn-block">Buat Password</button>
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
<?php $this->load->view(
	'template/head',
	['title' => 'Lupa Password']
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
					Lupa Password
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
				<p class="text-center">
					Silakan masukkan email anda.
					<br>
					Jika email terdaftar, tautan akan dikirim untuk membuat password baru.
				</p>
				<form method="post" action="<?= base_url('lupa_password') ?>" novalidate>
					<div class="form-group row">
						<div class="col-12">
							<input class="form-control <?= form_error('txtEmail') ? 'is-invalid' : '' ?>" type="email" name="txtEmail" id="txtEmail" value="<?= set_value('txtEmail') ?>">
							<div class="invalid-feedback">
								<?= form_error('txtEmail') ?>
							</div>
						</div>
					</div>
					<div class="d-flex flex-column align-items-end">
						<!-- /.col -->
						<div class="">
							<button type="submit" class="btn btn-primary btn-block">Kirim</button>
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
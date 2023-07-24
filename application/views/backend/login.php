<?php $this->load->view(
	'template/head',
	['title' => 'Login Sistem Monitoring Bimbingan Tugas Akhir']
)
?>
<style>
	body {
		background: url('https://www.itera.ac.id/wp-content/uploads/2020/01/4-1024x683.jpg');
		padding-top: 100px;
		background-size: cover;
	}
</style>

<body class="hold-transition login-page">
	<div class="login-box" style="color: black;">
		<div class="login-logo">
			<h2>SELAMAT DATANG DI
				SISTEM MONITORING BIMBINGAN TUGAS AKHIR </h2>
			
		</div>
		<?php if ($this->session->flashdata('message_error')) { ?>
			<div class="alert alert-danger" role="alert">
				<?= $this->session->flashdata('message_error') ?>
			</div>
		<?php } ?>
		<?php if ($this->session->flashdata('message_success')) { ?>
			<div class="alert alert-success" role="alert">
				<?= $this->session->flashdata('message_success') ?>
			</div>
		<?php } ?>
		<div class="card border-secondary">
			<!-- <div class="card text-center"> -->
			<div class="card-body login-card-body bg-light">
				<p class="login-box-msg">
					Silahkan Login Terlebih Dahulu
				</p>
				<form action="login" method="post" novalidate>
					<div class="col-12 mb-3 input-group">
						<input name="txtEmail" type="email" placeholder="Email" class='form-control text-black <?= form_error('txtEmail') ? 'is-invalid' : '' ?>' value="<?= set_value('txtEmail') ?>" required>
						<div class="input-group-append">
							<div class="input-group-text" type="text" style="color: white;">
								<span class="fas fa-envelope"></span>
							</div>
						</div>
						<div class="invalid-feedback">
							<?= form_error('txtEmail') ?>
						</div>
					</div>

					<div class="col-12 mb-3 input-group">
						<input name="txtPassword" type="password" placeholder="Password" class=' form-control <?= form_error('txtPassword') ? 'is-invalid' : '' ?>'>
						<div class="input-group-append">
							<div class="input-group-text" type="text" style="color: white;">
								<span class="fas fa-lock"></span>
							</div>
						</div>
						<div class="invalid-feedback ">
							<?= form_error('txtPassword') ?>
						</div>
					</div>

					<div class="row">
						<div class="col-8">
							<div class="icheck-primary">
								<input type="checkbox" class="form-check-input" id="remember">
								<label for="remember">
									Ingat Saya
								</label>
							</div>
						</div>
						<!-- /.col -->
						<div class="col-4">
							<button type="submit" class="btn btn-primary btn-block">Masuk</button>
						</div>
						<!-- /.col -->
						<div class="col-12 mt-3">
							<p class="">
								Belum punya akun? <a href="<?= base_url('register') ?>" class="text-center">Daftar disini</a>
								<br>
								Atau <a href="<?= base_url('lupa_password') ?>">Lupa Password</a>
							</p>
						</div>
					</div>
				</form>
			</div>
			<!-- /.login-card-body -->
		</div>
	</div>
	<!-- </div> -->
	<!-- /.login-box -->
	<?php $this->load->view('template/tile') ?>
</body>
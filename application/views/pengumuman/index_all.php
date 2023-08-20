<?php $this->load->view('template/head', [
	'title' => 'Pengumuman'
]);
?>

<body class="sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
	<div class="wrapper">

		<!-- SIDEBAR -->
		<?php $this->load->view('template/sidebar', [
			'menu_name' => 'pengumuman_all'
		]) ?>

		<!-- CONTENT -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0">Pengumuman</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?= base_url('beranda') ?>">Beranda</a></li>
								<li class="breadcrumb-item active">Pengumuman</li>
							</ol>
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- /.container-fluid -->
				<hr>
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
						<div class="col-12 col-lg-6">
							<?php $this->load->view('template/card_pengumuman', ['pengumumans' => $pengumumans]) ?>
						</div>
					</div>

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
</body>
<script>
	function pengumumanPublish(target) {
		var idPengumuman = $(target).attr('idPengumuman');
		var formField = $('#inputIdPengumumanPublish');
		$(formField).val(idPengumuman);
	}

	function pengumumanUnpublish(target) {
		var idPengumuman = $(target).attr('idPengumuman');
		var formField = $('#inputIdPengumumanUnpublish');
		$(formField).val(idPengumuman);
	}

	function pengumumanDelete(target) {
		var idPengumuman = $(target).attr('idPengumuman');
		var formField = $('#inputIdPengumumanDelete');
		$(formField).val(idPengumuman);
	}
</script>

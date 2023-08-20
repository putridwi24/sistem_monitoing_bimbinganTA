<?php $this->load->view('template/head', [
	'title' => 'Dokumen Pendukung TA'
]); ?>

<link rel="stylesheet" href="<?= base_url('plugins') ?>/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('plugins') ?>/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('plugins') ?>/datatables-buttons/css/buttons.bootstrap4.min.css">

<body class="sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
	<div class="wrapper">

		<!-- SIDEBAR -->
		<?php $this->load->view('template/sidebar', [
			'menu_name' => 'dokumen'
		]) ?>


		<!-- CONTENT -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0">Dokumen</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Dashboard</a></li>
								<li class="breadcrumb-item active">Dokumen</li>
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
					<?php $this->load->view('template/header_message') ?>
					<div class="row">
						<div class="col-12">
							<div class="card">
								<!-- /.card-header -->
								<div class="card-body">
									<form class="w-100" action="<?= base_url('dokumen/add') ?>" method="post" enctype="multipart/form-data">
										<div class="form-group row">
											<div class="input-group col-12 col-lg-9">
												<div class="custom-file">
													<input type="file" class="custom-file-input" id="fileDokumen" name="fileDokumen" accept="*">
													<label class="custom-file-label" for="fileDokumen" id="fileDokumenPreviewName">Pilih dokumen</label>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-12 col-lg-3 col-form-label" for="txtDeskripsi">Deskripsi dokumen</label>
											<div class="col-12 col-lg-9 ">
												<input type="text" class="form-control <?= form_error('txtDeskripsi') ? 'is-invalid' : '' ?>" name="txtDeskripsi" id="txtDeskripsi">
												<div class="invalid-feedback">
													<?= form_error('txtDeskripsi'); ?>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col">
												<div class="d-flex flex-row justify-content-end">
													<button class="btn btn-outline-secondary" type="submit">Simpan File</button>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
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

	<script>
		$('#fileDokumen').change((event) => {
			target = event.target;
			if (target.files && target.files[0]) {
				var reader = new FileReader();
				var filename = $(target).val();
				filename = filename.substring(filename.lastIndexOf('\\') + 1);
				reader.onload = (e) => {
					$('#fileDokumenPreviewName').text(filename);
				}
				reader.readAsDataURL(target.files[0]);
			}
		});
	</script>

</body>

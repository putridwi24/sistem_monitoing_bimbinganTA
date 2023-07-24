<?php $this->load->view('template/head', [
	'title' => 'Pengumuman',
]);
?>

<body class="sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
	<div class="wrapper">

		<!-- SIDEBAR -->
		<?php $this->load->view('template/sidebar', [
			'menu_name' => 'pengaturan_pengumuman'
		]) ?>

		<!-- CONTENT -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0">Buat Pengumuman </h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Dashboard</a></li>
								<li class="breadcrumb-item"><a href="<?php echo base_url('pengumuman') ?>">Pengumuman</a></li>
								<li class="breadcrumb-item active">Buat</li>

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
					<?php if (form_error('txtTitle')) { ?>
						<div class="alert  alert-danger  ">
							<?= form_error('txtTitle') ?>
						</div>
					<?php } ?>
					<?php if (form_error('txtInfo')) { ?>
						<div class="alert  alert-danger  ">
							<?= form_error('txtInfo') ?>
						</div>
					<?php } ?>
					<form action="<?= base_url('pengumuman/create') ?>" method="post" enctype="multipart/form-data">
						<div class="row">
							<div class="col-12 col-md-12">
								<div class="card">
									<!-- /.card-header -->
									<div class="card-header">
										<div class="d-flex flex-row justify-content-end no-stretch">
											<div class="custom-control custom-checkbox ml-2">
												<input type="checkbox" class="custom-control-input" id="immediateRelease" name="immediateRelease" checked>
												<label class="custom-control-label" for="immediateRelease">Terbitkan langsung</label>
											</div>
											<div class="ml-2">
												<button type="submit" class="btn btn-sm btn-primary btn-block">Simpan</button>
											</div>
										</div>
									</div>
									<div class="card-body ">
										<div class="form-group">
											<input type="text" class="form-control" id="txtTitle" placeholder="Judul pengumuman" name="txtTitle" value="<?= set_value('txtTitle') ?>">
										</div>
										<textarea id="summernote" name="txtInfo">
											<?= set_value('txtInfo') ?>
										</textarea>
										<div class="custom-file">
											<input type="file" class="custom-file-input" id="fileAttach" name="fileAttach" accept=".pdf, .doc, .docx, .jpg, .jpeg, .png, .csv, .xlsx">
											<label class="custom-file-label" for="fileAttach" id="fileAttachName">Pilih sisipan</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
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

	<script>
		$(function() {
			// Summernote
			$('#summernote').summernote()

		})
		$('#fileAttach').change((event) => {
			target = event.target;
			if (target.files && target.files[0]) {
				var reader = new FileReader();
				var filename = $(target).val();
				filename = filename.substring(filename.lastIndexOf('\\') + 1);
				reader.onload = (e) => {
					$('#fileAttachName').text(filename);
				}
				reader.readAsDataURL(target.files[0]);
			}
		});
	</script>

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
							<h1 class="m-0">Edit Pengumuman </h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Dashboard</a></li>
								<li class="breadcrumb-item"><a href="<?php echo base_url('pengumuman') ?>">Pengumuman</a></li>
								<li class="breadcrumb-item active">Edit</li>

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
					<?php if (form_error('txtInfo')) { ?>
						<div class="alert  alert-danger  ">
							<?= form_error('txtInfo') ?>
						</div>

					<?php } ?>
					<?php if (form_error('txtTitle')) { ?>
						<div class="alert  alert-danger  ">
							<?= form_error('txtTitle') ?>
						</div>

					<?php } ?>
					<div class="row">
						<div class="col-12 col-md-12 ">
							<div class="card">
								<form action="<?= base_url('pengumuman/' . $pengumuman->id . '/edit') ?>" method="post">

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
											<input type="text" class="form-control" id="txtTitle" placeholder="Judul pengumuman" name="txtTitle" value="<?= $pengumuman->title ?>">
										</div>
										<textarea id="summernote" name="txtInfo">
											<?= $pengumuman->info ?>
										</textarea>
								</form>
								<form action="<?= base_url('pengumuman/file/add') ?>" method="post" enctype="multipart/form-data">
									<input type="hidden" name="idPengumuman" id="idPengumuman" value="<?= $pengumuman->id ?>">
									<div class="input-group w-100">
										<div class="custom-file">
											<input type="file" class="custom-file-input" id="fileAttach" name="fileAttach" accept=".pdf, .doc, .docx, .jpg, .jpeg, .png, .csv, .xlsx">
											<label class="custom-file-label" for="fileAttach" id="fileAttachName">Pilih sisipan</label>
										</div>
										<div class="input-group-append">
											<button class="btn btn-outline-primary" type="submit">Tambahkan</button>
										</div>
									</div>
								</form>
								<div class="mt-3">
									<?php if ($pengumuman->attachment) foreach ($pengumuman->attachment as $attach) { ?>
										<div class="input-group w-100 mb-2">
											<a class="btn btn-sm btn-primary" href="<?= base_url(ATTACHMENT_URL . $attach) ?>">
												<i class="fas fa-file-alt"></i>
												<span> <?= ($attach) ?></span>
											</a>
											<div class="input-group-append">
												<button class="btn btn-outline-danger" type="button" onclick="deleteFile(this)" fileName="<?= $attach ?>" data-toggle="modal" data-target="#modal-delete-file">
													Hapus
												</button>
											</div>
										</div>
									<?php } ?>
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

	<div class="modal fade" id="modal-delete-file">
		<div class="modal-dialog">
			<div class="modal-content  ">
				<div class="modal-header">
					<h4 class="modal-title">Hapus file?</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>
						File sisipan akan dihapus
					</p>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-outline-light" data-dismiss="modal">Tutup</button>
					<form action="<?= base_url('pengumuman/file/delete') ?>" method="post" id="formPasswordChange">
						<input type="hidden" name="idPengumuman" id="idPengumuman" value="<?= $pengumuman->id ?>">
						<input type="hidden" name="fileName" id="fileNameField" value="">
						<button type="submit" class="btn btn-outline-light">Hapus</button>
					</form>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
</body>
<script src="<?php echo base_url('plugins') ?>/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>
	$(function() {
		// Summernote
		$('#summernote').summernote()

	})

	function deleteFile(target) {
		var fileName = $(target).attr('fileName');
		var formField = $('#fileNameField');
		$(formField).val(fileName);
	}
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

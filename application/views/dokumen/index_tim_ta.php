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
			'menu_name' => 'dokumen_tim'
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
								<div class="card-header">
									<div class="card-tools">
										<a href="<?= base_url('dokumen/add') ?>" class="btn btn-primary btn-sm" style="background-color: #1578C6">
											<i class="fas fa-plus pr-1"></i>
											Tambah Dokumen Pendukung
										</a>
									</div>
								</div>
								<!-- /.card-header -->
								<div class="card-body">
									<table class="table table-hover table-striped" id="tabel-mahasiswa" data-order='[[ 0, "asc" ]]' data-page-length='10'>
										<thead>
											<tr>
												<th>No</th>
												<th>Dokumen</th>
												<th>Deskripsi</th>
												<th class="col-2">Aksi</th>
											</tr>
										</thead>
										<tbody>
											<?php $no = 1;
											foreach ($documents as $document) { ?>
												<tr>
													<td><?= $no++ ?></td>
													<td>
														<a class="badge badge-info p-2" target="_blank" href="<?= base_url(URL_DOCUMENTS  . $document->file_name) ?>">
															<i class="fas fa-file mr-1"></i>
															<?= $document->file_name ?>
														</a>
													</td>
													<td><?= $document->description ?></td>
													<td>
														<div class="d-flex flex-column flex-lg-row">
															<button class="btn btn-sm btn-outline-danger p-1 mr-1 mb-1" documentId="<?= $document->id ?>" documentName="<?= $document->file_name ?>" onclick="documentDelete(this)" data-toggle="modal" data-target="#modal-delete-document">
																<i class="fas fa-trash m-1 "></i>
															</button>
														</div>
													</td>
												</tr>

											<?php } ?>
										</tbody>
									</table>
								</div>
								<!-- /.card-body -->
								<div class="card-footer">
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
			<strong>Copyright &copy; Sistem Monitoring Bimbingan Tugas Akhir ITERA
			</strong>
			<div class="float-right d-none d-sm-inline-block">
				<b>Version</b> 3.2.0
			</div>
		</footer>

	</div>
	<?php $this->load->view('template/tile') ?>


	<div class="modal fade" id="modal-delete-document">
		<div class="modal-dialog">
			<div class="modal-content  ">
				<div class="modal-header">
					<h4 class="modal-title">Hapus File?</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Anda akan menghapus file <span class="documentName"></span></p>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-sm btn-outline-light" data-dismiss="modal">Tutup</button>
					<form action="<?= base_url('dokumen/delete') ?>" method="post">
						<input type="hidden" name="documentId" class="inputDocumentId" value="">
						<button type="submit" class="btn btn-sm btn-danger btn-block">
							<i class="fas fa-trash"></i>
							Hapus
						</button>
					</form>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>


	<script src="<?= base_url('plugins') ?>/datatables/jquery.dataTables.min.js"></script>
	<script src="<?= base_url('plugins') ?>/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?= base_url('plugins') ?>/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="<?= base_url('plugins') ?>/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<script src="<?= base_url('plugins') ?>/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script src="<?= base_url('plugins') ?>/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
	<script src="<?= base_url('plugins') ?>/jszip/jszip.min.js"></script>
	<script src="<?= base_url('plugins') ?>/pdfmake/pdfmake.min.js"></script>
	<script src="<?= base_url('plugins') ?>/pdfmake/vfs_fonts.js"></script>
	<script src="<?= base_url('plugins') ?>/datatables-buttons/js/buttons.html5.min.js"></script>
	<script src="<?= base_url('plugins') ?>/datatables-buttons/js/buttons.print.min.js"></script>
	<script src="<?= base_url('plugins') ?>/datatables-buttons/js/buttons.colVis.min.js"></script>
	<script>
		$(function() {
			$('.spinner-loading').hide();
			$("#tabel-mahasiswa").DataTable({
				"responsive": true,
				"lengthChange": true,
				"autoWidth": true,
				"buttons": []
			}).buttons().container().appendTo('#tabel-mahasiswa_wrapper .col-md-6:eq(0)');
		});

		function documentDelete(target) {
			var documentId = $(target).attr('documentId');
			var documentName = $(target).attr('documentName');

			$('.documentName').val(documentName);
			$('.inputDocumentId').val(documentId);
		}
	</script>
</body>

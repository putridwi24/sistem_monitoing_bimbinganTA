<?php $this->load->view('template/head', [
	'title' => 'Pengumuman'
]);
?>

<link rel="stylesheet" href="<?= base_url('plugins') ?>/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('plugins') ?>/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('plugins') ?>/datatables-buttons/css/buttons.bootstrap4.min.css">

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
							<h1 class="m-0">Pengumuman</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Dashboard</a></li>
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
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<div class="card-tools">
										<a class="btn btn-sm btn-primary ml-auto " href="<?= base_url('pengumuman/create') ?>" style="background-color: #1578C6">
											<i class="fas fa-plus pr-1"></i>
											Buat Pengumuman
										</a>
									</div>
								</div>
								<!-- /.card-header -->
								<div class="card-body">
									<table class="table table-hover table-striped" id="tabel-pengumuman" data-order='[[ 0, "asc" ]]' data-page-length='10'>
										<thead>
											<tr>
												<th class="col-1">No</th>
												<th class="col-4">Judul</th>
												<th class="col-3">File</th>
												<th class="col-2">Waktu</th>
												<th class="col-2">Aksi</th>
											</tr>
										</thead>
										<tbody>
											<?php $no = 1;
											foreach ($pengumumans as $item) { ?>
												<tr>
													<td class="col-1"><?= $no++ ?></td>
													<td class="col-4">
														<?= $item->title ?>
													</td>
													<td class="col-3">
														<p>
															<?php if ($item->attachment) foreach ($item->attachment as $attach) { ?>
																<a class="btn btn-sm btn-primary mb-1" href="<?= base_url(ATTACHMENT_URL . $attach) ?>">
																	<i class="fas fa-file-alt"></i>
																	<span> <?= ($attach) ?></span>
																</a>
																<br>
															<?php } ?>
														</p>
													</td>
													<td class="col-2">
														<p>
															<small class="badge badge-info">Dibuat <?= $item->created_at ?></small>
															<br>
															<?php if ($item->updated_at) { ?>
																<small class="badge badge-info">Diupdate <?= $item->updated_at ?></small>
															<?php } else { ?>
															<?php } ?>
															<?php if ($item->release_at) { ?>
																<small class="badge badge-info">Terbit <?= $item->release_at ?></small>
															<?php } else { ?>
																<small class="badge badge-danger">Belum terbit</small>
															<?php } ?>
														</p>
													</td>
													<td class="col-2 ">
														<div class="w-100 d-flex flex-row justify-content-end">

															<?php if ($item->release_at) { ?>
																<button class="btn btn-success btn-sm mr-1 btn-pengumuman-unpublish" idPengumuman="<?= $item->id ?>" onclick="pengumumanUnpublish(this)" data-toggle="modal" data-target="#modal-unpublish-pengumuman">
																	<i class="fas fa-pause  "></i>
																</button>
															<?php } else { ?>
																<button class="btn btn-success btn-sm mr-1 btn-pengumuman-publish" idPengumuman="<?= $item->id ?>" onclick="pengumumanPublish(this)" data-toggle="modal" data-target="#modal-publish-pengumuman">
																	<i class="fas fa-bullhorn  "></i>
																</button>
															<?php } ?>
															<a class="btn btn-primary btn-sm   mr-1" href="<?= base_url('pengumuman/' . $item->id . '/edit') ?>">
																<i class="fas fa-edit  "></i>
															</a>
															<button class="btn btn-danger btn-sm btn-pengumuman-delete" id="btnPasswordChange" idPengumuman="<?= $item->id ?>" onclick="pengumumanDelete(this)" data-toggle="modal" data-target="#modal-delete-pengumuman">
																<i class="fas fa-trash  "></i>
															</button>

														</div>
													</td>
												</tr>


											<?php } ?>
										</tbody>
									</table>
									<div class="modal fade" id="modal-delete-pengumuman">
										<div class="modal-dialog">
											<div class="modal-content  ">
												<div class="modal-header">
													<h4 class="modal-title">Yakin menghapus pengumuman?</h4>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<p>Pengumuman akan dihapus</p>
												</div>
												<div class="modal-footer justify-content-between">
													<button type="button" class="btn btn-outline-light" data-dismiss="modal">Tutup</button>
													<form action="<?= base_url('pengumuman/delete') ?>" method="post">
														<input type="hidden" name="idPengumuman" id="inputIdPengumumanDelete" value="">
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
									<div class="modal fade" id="modal-publish-pengumuman">
										<div class="modal-dialog">
											<div class="modal-content  ">
												<div class="modal-header">
													<h4 class="modal-title">Publish pengumuman?</h4>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<p>Pengumuman akan diterbitkan
													</p>
												</div>
												<div class="modal-footer justify-content-between">
													<button type="button" class="btn btn-outline-light" data-dismiss="modal">Tutup</button>
													<form action="<?= base_url('pengumuman/publish') ?>" method="post">
														<input type="hidden" name="idPengumuman" id="inputIdPengumumanPublish" value="">
														<button type="submit" class="btn btn-outline-light">Terbitkan</button>
													</form>
												</div>
											</div>
											<!-- /.modal-content -->
										</div>
										<!-- /.modal-dialog -->
									</div>
									<div class="modal fade" id="modal-unpublish-pengumuman">
										<div class="modal-dialog">
											<div class="modal-content  ">
												<div class="modal-header">
													<h4 class="modal-title">Batalkan penerbitan pengumuman?</h4>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<p>Penerbitan pengumuman akan dibatalkan dan hanya dapat dilihat oleh Admin TA
													</p>
												</div>
												<div class="modal-footer justify-content-between">
													<button type="button" class="btn btn-outline-light" data-dismiss="modal">Tutup</button>
													<form action="<?= base_url('pengumuman/unpublish') ?>" method="post" id="formPasswordChange">
														<input type="hidden" name="idPengumuman" id="inputIdPengumumanUnpublish" value="">
														<button type="submit" class="btn btn-outline-light">Batalkan Terbit</button>
													</form>
												</div>
											</div>
											<!-- /.modal-content -->
										</div>
										<!-- /.modal-dialog -->
									</div>
								</div>
								<!-- /.card-body -->
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

	<script src="<?= base_url('plugins') ?>/dropzone/min/dropzone.min.js"></script>
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
			$("#tabel-pengumuman").DataTable({
				"responsive": true,
				"lengthChange": true,
				"autoWidth": true,
				"buttons": ["colvis", "pageLength"]
			}).buttons().container().appendTo('#tabel-pengumuman_wrapper .col-md-6:eq(0)');
		});
	</script>
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
</body>

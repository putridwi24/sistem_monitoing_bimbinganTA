<?php $this->load->view('template/head', [
	'title' => 'Bimbingan Mahasiswa'
]); ?>

<link rel="stylesheet" href="<?= base_url('plugins') ?>/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('plugins') ?>/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('plugins') ?>/datatables-buttons/css/buttons.bootstrap4.min.css">

<body class="sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
	<div class="wrapper">

		<!-- SIDEBAR -->
		<?php $this->load->view('template/sidebar', [
			'menu_name' => 'kartu_kendali'
		]) ?>


		<!-- CONTENT -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0">Kartu Kendali / Histori Bimbingan</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?php echo base_url('mahasiswa/beranda') ?>">Beranda</a></li>
								<li class="breadcrumb-item active">Kartu Kendali</li>
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
										<a type="button" class="btn btn-primary btn-sm" href="<?= base_url('kartu_kendali/create') ?>">
											<i class="fas fa-plus pr-1"></i>
											Tambah Kartu Kendali
										</a>
									</div>
								</div>
								<!-- /.card-header -->
								<div class="card-body">
									<table class="table table-hover table-striped" id="tabel-kartu" data-order='[[ 0, "asc" ]]' data-page-length='10'>
										<thead>
											<tr>
												<th>No</th>
												<th>Hari/Tanggal</th>
												<th>Kegiatan</th>
												<th>Dosen Pembimbing</th>
												<th>Paraf Dosen</th>
												<th>Aksi</th>
											</tr>
										</thead>
										<tbody>
											<?php $no = 1;
											foreach ($kartus as $kartu) { ?>
												<tr>
													<td>
														<?= $no++ ?>
													</td>
													<td>
														<?= $kartu->created_at ?>
													</td>
													<td>
														<?= $kartu->kegiatan ?>
													</td>
													<td>
														<?= $kartu->dosen->user->name ?>
													</td>
													<td>
														<?php if ($kartu->paraf) { ?>
															<small class="badge badge-success"><i class="fas fa-check"></i> Diparaf</small>
														<?php } else { ?>
															<?php if (!is_null($kartu->request_paraf_at)) { ?>
																<small class="badge badge-warning"><i class="fas fa-clock"></i> Menunggu Paraf</small>
															<?php } else { ?>
																<small class="badge badge-danger"><i class="fas fa-clock"></i> Belum diparaf</small>
															<?php } ?>
														<?php } ?>
													</td>
													<td>
														<div class="d-flex flex-column flex-lg-row">
															<a class="btn btn-sm btn-outline-primary p-1 mr-1 mb-1" href="<?= base_url('kartu_kendali/' . $kartu->id . '') ?>">
																<i class="fas fa-eye mr-1"></i>
																Lihat
															</a>
															<?php if (is_null($kartu->paraf) && is_null($kartu->request_paraf_at)) { ?>
																<button class="btn btn-sm btn-outline-success p-1 mr-1 mb-1" kartuId="<?= $kartu->id ?>" onclick="kartuRequestSign(this)" data-toggle="modal" data-target="#modal-request-sign">
																	<i class="fas fa-edit m-1 "></i>
																	Minta Paraf
																</button>
															<?php } ?>
														</div>
													</td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
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
			<strong>Copyright &copy; Sistem Monitoring Bimbingan Tugas Akhir ITERA
			</strong>
			<div class="float-right d-none d-sm-inline-block">
				<b>Version</b> 3.2.0
			</div>
		</footer>
	</div>

	<div class="modal fade" id="modal-request-sign">
		<div class="modal-dialog">
			<div class="modal-content  ">
				<div class="modal-header">
					<h4 class="modal-title">Minta Paraf Dosen?</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Anda akan meminta paraf dosen untuk kartu kendali ini.</p>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-sm btn-outline-light" data-dismiss="modal">Tutup</button>
					<form action="<?= base_url('kartu_kendali/sign/request') ?>" method="post">
						<input type="hidden" name="kartuId" id="kartuIdField" value="">
						<button type="submit" class="btn btn-sm btn-success btn-block">
							<i class="fas fa-check"></i>
							Minta Paraf
						</button>
					</form>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<?php $this->load->view('template/tile') ?>
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
			$("#tabel-kartu").DataTable({
				"responsive": true,
				"lengthChange": true,
				"autoWidth": true,
				"buttons": ["colvis", "pageLength"]
			}).buttons().container().appendTo('#tabel-kartu_wrapper .col-md-6:eq(0)');

		});
	</script>
	<script>
		function kartuRequestSign(target) {
			var kartuId = $(target).attr('kartuId');
			$('#kartuIdField').val(kartuId);
		}
	</script>
</body>

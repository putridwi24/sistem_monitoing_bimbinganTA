<?php $this->load->view('template/head', [
	'title' => 'Timeline Laporan Mahasiswa'
]); ?>

<link rel="stylesheet" href="<?= base_url('plugins') ?>/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('plugins') ?>/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('plugins') ?>/datatables-buttons/css/buttons.bootstrap4.min.css">

<body class="sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
	<div class="wrapper">

		<!-- SIDEBAR -->
		<?php $this->load->view('template/sidebar', [
			'menu_name' => 'timeline_laporan'
		]) ?>

		<!-- CONTENT -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0">Progres Tugas Akhir Mahasiswa</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?php echo base_url('beranda/dosen') ?>">Beranda</a></li>
								<li class="breadcrumb-item active">Timeline Laporan</li>
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
								<div class="card-body">
									<table class="table table-hover table-striped" id="tabel-timeline" data-order='[[ 0, "asc" ]]' data-page-length='10'>
										<thead>
											<tr>
												<th class="col-1">No</th>
												<th class="col-3">Nama Mahasiswa</th>
												<th class="col-1">NIM</th>
												<th class="col-3">Judul Tugas Akhir</th>
												<!-- <th>Status Laporan TA</th> -->
												<th class="col-2">Persentase Progres</th>
												<th class="col-2">Aksi</th>
											</tr>
										</thead>
										<tbody>
											<?php $no = 1;
											foreach ($mahasiswas as $mahasiswa) { ?>
												<tr>
													<td class="col-1">
														<?= $no++; ?>
													</td>
													<td class="col-3">
														<?= $mahasiswa->user->name; ?>
													</td>
													<td class="col-1">
														<?= $mahasiswa->nim ?>
													</td>
													<td class="col-3">
														<?= $mahasiswa->judul_ta ?>
													</td>
													<td class="col-2">
														<?php if (isset($mahasiswa->progres)) { ?>
															<div class="progress-group">
																<?= $this->progres_model->calculate_percentage_progres_id($mahasiswa->progres->id) ?> %
																<div class="progress progress-sm">
																	<div class="progress-bar bg-primary" style="width: <?= $this->progres_model->calculate_percentage_progres_id($mahasiswa->progres->id) ?>%"></div>
																</div>
															</div>
														<?php } ?>
														<?php if (isset($mahasiswa->progres)) { ?>
															<div class="badge   p-2">
																<?= $this->progres_model->generate_status_report_progres_id($mahasiswa->progres->id) ?>
															</div>
														<?php } ?>
													</td>
													<td class="col-2">
														<div class="d-flex flex-row">
															<?php if (isset($mahasiswa->progres)) { ?>
																<a class="btn btn-primary btn-sm" href="<?= base_url('timeline/' . $mahasiswa->progres->id . '') ?>">
																	<i class="fas fa-eye  "></i>
																</a>
															<?php } else { ?>
																<small class="badge badge-light font-weight-normal"> Mahasiswa belum melengkapi data</small>

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
			$("#tabel-timeline").DataTable({
				"responsive": true,
				"lengthChange": true,
				"autoWidth": true,
				"buttons": ["colvis", "pageLength"]
			}).buttons().container().appendTo('#tabel-timeline_wrapper .col-md-6:eq(0)');
		});
	</script>
</body>

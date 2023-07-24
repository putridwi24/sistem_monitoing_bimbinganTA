<?php $this->load->view('template/head', [
	'title' => 'Daftar Mahasiswa Bimbingan'
]); ?>

<link rel="stylesheet" href="<?= base_url('plugins') ?>/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('plugins') ?>/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('plugins') ?>/datatables-buttons/css/buttons.bootstrap4.min.css">

<body class="sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
	<div class="wrapper">

		<!-- SIDEBAR -->
		<?php $this->load->view('template/sidebar', [
			'menu_name' => 'my_mahasiswa'
		]) ?>


		<!-- CONTENT -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0">Daftar Mahasiswa Bimbingan</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Dashboard</a></li>
								<li class="breadcrumb-item active">Mahasiswa</li>
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
					<div class="row">
						<div class="col-12">

							<div class="card">
								<div class="card-body">
									<table class="table table-hover table-striped" id="tabel-mahasiswa" data-order='[[ 0, "asc" ]]' data-page-length='10'>
										<thead>
											<tr>
												<th>No</th>
												<th>Nama
												<th>NIM</th>
												<th>Status TA</th>
												<th>Judul TA</th>
												<th>Dosen Pembimbing</th>
												<th>Persentase Progres</th>
												<!-- <th class="col-2">Aksi</th> -->
											</tr>
										</thead>
										<tbody>
											<?php $no = 1;
											foreach ($mahasiswas as $mahasiswa) { ?>
												<tr>
													<td><?= $no++ ?></td>
													<td>
														<a href="<?= base_url('mahasiswa/' . $mahasiswa->nim) ?>">
															<?= $mahasiswa->user->name ?>
														</a>
													</td>
													<td>
														<?php if ($mahasiswa->nim) : ?>
															<?= $mahasiswa->nim ?>
														<?php else : ?>
															<small><strong>Belum ditentukan</strong></small>
														<?php endif ?>
													</td>
													<td style="max-width: 1rem;">
														<?php if (isset($mahasiswa->status)) : ?>
															<small class="badge badge-info text-wrap text-left">
																<?= $mahasiswa->status ?>
															</small>
														<?php else : ?>
															<small><strong>Belum ditentukan</strong></small>
														<?php endif; ?>
													</td>
													<td>
														<?php if ($mahasiswa->judul_ta) : ?>
															<?= $mahasiswa->judul_ta ?>
														<?php else : ?>
															<small><strong>Belum ditentukan</strong></small>
														<?php endif ?>
													</td>
													<td>
														<span>
															<?php if ($mahasiswa->dosbing_1) : ?>
																<small class="badge badge-info text-wrap text-left">
																	<?= $mahasiswa->dosbing_1->user->name ?>
																</small>
															<?php else : ?>
																<small><strong>Belum ditentukan</strong></small>
															<?php endif ?>
														</span>
														<br>
														<span>
															<?php if ($mahasiswa->dosbing_2) : ?>
																<small class="badge badge-info text-wrap text-left">
																	<?= $mahasiswa->dosbing_2->user->name ?>
																</small>
															<?php else : ?>
																<small><strong>Belum ditentukan</strong></small>
															<?php endif ?>
														</span>
													</td>
													<td>
														<?php if (isset($mahasiswa->progres)) { ?>
															<div class="progress-group">
																<?= $this->progres_model->calculate_percentage_progres_id($mahasiswa->progres->id) ?> %
																<div class="progress progress-sm">
																	<div class="progress-bar bg-primary" style="width: <?= $this->progres_model->calculate_percentage_progres_id($mahasiswa->progres->id) ?>%"></div>
																</div>
															</div>
															<div class="badge   p-2">
																<?= $this->progres_model->generate_status_report_progres_id($mahasiswa->progres->id) ?>
															</div>
														<?php } ?>
													</td>
													<!-- <td>
														<i class="fas fa-check text-success font-weight-bold"></i>
													</td> -->
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
			$("#tabel-mahasiswa").DataTable({
				"responsive": true,
				"lengthChange": true,
				"autoWidth": true,
				"buttons": ["colvis", "pageLength"]
			}).buttons().container().appendTo('#tabel-mahasiswa_wrapper .col-md-6:eq(0)');
		});
	</script>
</body>

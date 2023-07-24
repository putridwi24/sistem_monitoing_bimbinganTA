<?php $this->load->view('template/head', [
	'title' => 'Permohonan Bimbingan Mahasiswa'
]); ?>

<link rel="stylesheet" href="<?= base_url('plugins') ?>/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('plugins') ?>/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('plugins') ?>/datatables-buttons/css/buttons.bootstrap4.min.css">

<body class="sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
	<div class="wrapper">

		<!-- SIDEBAR -->
		<?php $this->load->view('template/sidebar', [
			'menu_name' => 'bimbingan'
		]) ?>


		<!-- CONTENT -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0">Antrian Bimbingan Mahasiswa</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?php echo base_url('dosen/beranda') ?>">Beranda</a></li>
								<li class="breadcrumb-item active">Bimbingan</li>
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
					<?php
					$this->load->view('template/header_message');
					?>
					<div class="row">
						<div class="col-12">
							<div class="card">
								<!-- /.card-header -->
								<div class="card-body ">
									<table class="table table-hover table-striped" id="tabelBimbingan" data-order='[[ 0, "asc" ]]' data-page-length='10'>
										<thead>
											<tr>
												<th>No</th>
												<th>Nama Mahasiswa</th>
												<!-- <th>Judul Tugas Akhir</th>
												<th>File TA</th> -->
												<th>Tanggal/Waktu</th>
												<th>Keterangan Mahasiswa</th>
												<th>Keterangan Dosen</th>
												<th>Aksi</th>
											</tr>
										</thead>
										<tbody>
											<?php $no = 1;
											foreach ($bimbingans as $bimbingan) { ?>
												<tr>
													<td>
														<?= $no++; ?>
													</td>
													<td>
														<?= $bimbingan->mahasiswa->user->name; ?>
													</td>
													<!-- <td>
														<?= $bimbingan->dosen->user->name ?>
													</td>
													<td>
														<?= $bimbingan->judul_ta ?>
													</td>
													<td>
														<?php if ($bimbingan->file_ta) { ?>
															<a class="btn btn-sm btn-info d-flex" href="<?= base_url(URL_BIMBINGAN_ATTACHMENT . $bimbingan->file_ta) ?>">
																<i class="fas fa-file-alt p-1"></i>
																<span class="d-inline"> <?= $bimbingan->file_ta ?></span>
															</a>
														<?php } ?>
													</td> -->
													<td>
														<?= $bimbingan->waktu_bimbingan ?>
													</td>
													<td>
														<?= $bimbingan->keterangan_mahasiswa ?>
													</td>
													<td>
														<?= $bimbingan->keterangan_dosen ?>
													</td>
													<td class="">
														<?php if (is_null($bimbingan->selesai_at)) { ?>
															<a class="btn btn-sm btn-outline-primary p-1 mr-1" href="<?= base_url('bimbingan/' . $bimbingan->id . '/process') ?>">
																<i class="fas fa-users m-1"></i>
																Bimbingan
															</a>
														<?php } else { ?>
															<small class="badge badge-success"><i class="fas fa-check"></i> Selesai</small>
														<?php } ?>
													</td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
								<!-- /.card-body -->
								<div class="card-footer">
									<ul class="pagination pagination-sm m-0 float-right">
										<li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
										<li class="page-item"><a class="page-link" href="#">1</a></li>
										<li class="page-item"><a class="page-link" href="#">2</a></li>
										<li class="page-item"><a class="page-link" href="#">3</a></li>
										<li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
									</ul>
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
			$("#tabelBimbingan").DataTable({
				"responsive": true,
				"lengthChange": true,
				"autoWidth": true,
				"buttons": ["colvis", "pageLength"]
			}).buttons().container().appendTo('#tabelBimbingan_wrapper .col-md-6:eq(0)');

		});
	</script>
</body>

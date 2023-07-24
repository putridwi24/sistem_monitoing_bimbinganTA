<?php $this->load->view('template/head', [
	'title' => 'Bimbingan Mahasiswa'
]);

?>

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
							<h1 class="m-0">Bimbingan Mahasiswa</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?php echo base_url('mahasiswa/bimbingan') ?>">Beranda</a></li>
								<li class="breadcrumb-item active">Bimbingan Mahasiswa</li>
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
										<a type="submit" class="btn btn-primary btn-sm" href="<?= base_url('permohonan/create') ?>">
											<i class="fas fa-plus pr-1"></i>
											Tambah bimbingan
										</a>
									</div>
								</div>
								<!-- /.card-header -->
								<div class="card-body">
									<table class="table table-hover table-striped" id="tabelBimbingan" data-order='[[ 0, "asc" ]]' data-page-length='10'>
										<thead>
											<tr>
												<th>No</th>
												<th>Dosen Pembimbing</th>
												<th>Judul TA</th>
												<th>File TA</th>
												<th>Tanggal/Waktu</th>
												<th>Keterangan Mahasiswa</th>
												<th>Keterangan Dosen</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no = 1;
											foreach ($bimbingans as $bimbingan) { ?>
												<tr>
													<td><?= $no++ ?></td>
													<td><?= $bimbingan->dosen->user->name ?></td>
													<td><?= $bimbingan->judul_ta ?></td>
													<td>
														<?php if ($bimbingan->file_ta) { ?>
															<a class="btn btn-sm btn-info" href="<?= base_url(URL_BIMBINGAN_ATTACHMENT . $bimbingan->file_ta) ?>">
																<i class="fas fa-file p-1"></i>
																<span class="d-inline">File TA</span>
															</a>
														<?php } ?>
													</td>
													<td><?= $bimbingan->waktu_bimbingan ?></td>
													<td><?= $bimbingan->keterangan_mahasiswa ?></td>
													<td><?= $bimbingan->keterangan_dosen ?></td>
													<td>
														<?php if (
															is_null($bimbingan->disetujui_at)
															&& is_null($bimbingan->selesai_at)
															&& is_null($bimbingan->ditolak_at)
														) { ?>
															<small class="badge badge-warning mr-1 mb-1"><i class="far fa-clock"></i> Menunggu persetujuan</small>

															<?php if (is_null($bimbingan->disetujui_at) && is_null($bimbingan->selesai_at)) { ?>
																<button class="btn btn-sm btn-outline-danger p-1 mr-1 mb-1 btn-bimbingan-reject" idBimbingan="<?= $bimbingan->id ?>" onclick="permohonanCancel(this)" data-toggle="modal" data-target="#modal-cancel-permohonan">
																	<i class="fas fa-times m-1"></i>
																	Batalkan
																</button>
															<?php } ?>
														<?php } ?>
														<?php if (!is_null($bimbingan->disetujui_at) && is_null($bimbingan->selesai_at)) { ?>
															<small class="badge badge-primary"><i class="fas fa-check"></i> Disetujui</small>
														<?php } ?>
														<?php if (!is_null($bimbingan->ditolak_at)) { ?>
															<small class="badge badge-danger"><i class="fas fa-times"></i> Ditolak</small>
														<?php } ?>
														<?php if (!is_null($bimbingan->selesai_at)) { ?>
															<small class="badge badge-success"><i class="fas fa-check"></i> Selesai</small>
														<?php } ?>
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

	<div class="modal fade" id="modal-cancel-permohonan">
		<div class="modal-dialog">
			<div class="modal-content  ">
				<div class="modal-header">
					<h4 class="modal-title">Batalkan permohonan bimbingan?</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Anda yakin membatalkan permohonan bimbingan?</p>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-sm btn-outline-light" data-dismiss="modal">Tutup</button>
					<form action="<?= base_url('permohonan/cancel') ?>" method="post">
						<input type="hidden" name="idBimbingan" id="inputIdBimbinganCancel" value="">
						<button type="submit" class="btn btn-sm btn-danger btn-block">
							<i class="fas fa-times"></i>
							Batalkan
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
			$("#tabelBimbingan").DataTable({
				"responsive": true,
				"lengthChange": true,
				"autoWidth": true,
				"buttons": ["colvis", "pageLength"]
			}).buttons().container().appendTo('#tabelBimbingan_wrapper .col-md-6:eq(0)');

		});
	</script>
	<script>
		function permohonanCancel(target) {
			var idBimbingan = $(target).attr('idBimbingan');
			var formField = $('#inputIdBimbinganCancel');
			$(formField).val(idBimbingan);
		}
	</script>
</body>

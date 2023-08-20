<?php $this->load->view('template/head', [
	'title' => 'Kartu Kendali Mahasiswa'
]);

?>

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
							<h1 class="m-0">Kartu Kendali</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?php echo base_url('dosen/kartu_kendali') ?>">Beranda</a></li>
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
								<!-- /.card-header -->
								<div class="card-body">
									<table class="table table-hover table-striped" id="tabelKartuKendali" data-order='[[ 0, "asc" ]]' data-page-length='10'>
										<thead>
											<tr>
												<th>No</th>
												<th>Tanggal/waktu</th>
												<th>Nama Mahasiswa</th>
												<th>Kegiatan</th>
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
														<?= $kartu->mahasiswa->user->name ?>
													</td>
													<td>
														<?= $kartu->kegiatan ?>
													</td>
													<td>
														<?php if (!$kartu->paraf) { ?>
															<button class="btn btn-sm btn-outline-success  mr-1 " idKartu="<?= $kartu->id ?>" onclick="kartuParaf(this)" data-toggle="modal" data-target="#modal-paraf-kartu">
																<i class="fas fas mr-1 fa-pen"></i>
																Paraf
															</button>
														<?php } else { ?>
															<small class="badge badge-success">
																<i class="fas fa-check mr-1"></i>
																Diparaf pada <?= $kartu->diparaf_at ?>
															</small>
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
			<strong>Copyright &copy; Sistem Monitoring Bimbingan Tugas Akhir IF ITERA
			</strong>
			<div class="float-right d-none d-sm-inline-block">
				<b>Version</b> 3.2.0
			</div>
		</footer>
	</div>


	<div class="modal fade" id="modal-paraf-kartu">
		<div class="modal-dialog">
			<div class="modal-content  ">
				<div class="modal-header">
					<h4 class="modal-title">Paraf Bimbingan ini?</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn  btn-sm btn-outline-light" data-dismiss="modal">Tutup</button>
					<form action="<?= base_url('kartu_kendali/sign') ?>" method="post">
						<input type="hidden" name="idKartu" id="inputIdKartuParaf" value="">
						<button type="submit" class="btn btn-sm btn-success btn-block">
							<i class="fas fa-pen mr-1"></i>
							Paraf
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
		function kartuParaf(target) {
			var idKartu = $(target).attr('idKartu');
			var formField = $('#inputIdKartuParaf');
			$(formField).val(idKartu);

		}
		$(function() {
			$("#tabelKartuKendali").DataTable({
				"responsive": true,
				"lengthChange": true,
				"autoWidth": true,
				"buttons": ["colvis"]
			}).buttons().container().appendTo('#tabelKartuKendali_wrapper .col-md-6:eq(0)');

		});
	</script>

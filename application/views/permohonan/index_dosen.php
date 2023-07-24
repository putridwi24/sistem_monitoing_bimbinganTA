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
			'menu_name' => 'permohonan_bimbingan'
		]) ?>


		<!-- CONTENT -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0">Permohonan Bimbingan Mahasiswa</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?php echo base_url('dosen/beranda') ?>">Beranda</a></li>
								<li class="breadcrumb-item active">Permohonan Bimbingan</li>
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
								<div class="card-header">
									<div class="card-tools">
										<a href="<?= base_url('bimbingan') ?>" class="btn btn-primary btn-sm" style="background-color: #3C455C">
											<!-- <i class="fas fa-plus pr-1"></i> -->
											Lihat Antrian Bimbingan
										</a>
									</div>
								</div>
								<!-- /.card-header -->
								<div class="card-body">
									<table class="table table-hover table-striped" id="tabelPermohonan" data-order='[[ 0, "asc" ]]' data-page-length='10'>
										<thead>
											<tr>
												<th class="col-1">No</th>
												<th class="col-2">Nama Mahasiswa</th>
												<th class="col-3">Judul Tugas Akhir</th>
												<!-- <th class="col-2">File TA</th> -->
												<th class="col-1">Waktu Bimbingan</th>
												<th class="col-2">Status</th>
												<th class="col-2">Aksi</th>
											</tr>
										</thead>
										<tbody>
											<?php $no = 1;
											foreach ($permohonans as $permohonan) { ?>
												<tr>
													<td class="col-1">
														<?= $no++; ?>
													</td>
													<td class="col-2">
														<?= $permohonan->mahasiswa->user->name; ?>
													</td>
													<td class="col-3">
														<?= $permohonan->judul_ta ?>
													</td>
													<!-- <td class="col-2">
														<?php if ($permohonan->file_ta) { ?>
															<a class="btn btn-sm btn-info d-flex" href="<?= base_url(URL_BIMBINGAN_ATTACHMENT . $permohonan->file_ta) ?>">
																<i class="fas fa-file-alt p-1"></i>
																<span class="d-inline"> <?= $permohonan->file_ta ?></span>
															</a>
														<?php } ?>
													</td> -->
													<td class="col-1">
														<?php
														$waktu_diajukan = new DateTime($permohonan->waktu_bimbingan);
														?>
														<small class="badge badge-light text-left">
															<?= $waktu_diajukan->format('D, d F Y') ?>
															<br>
															<?= $waktu_diajukan->format('H:i:s') ?>
														</small>

													</td>
													<td class="col-1">
														<?php if (
															is_null($permohonan->disetujui_at)
															&& is_null($permohonan->selesai_at)
															&& is_null($permohonan->ditolak_at)
														) { ?>
															<small class="badge badge-light">Diajukan <?= $this->pengumuman_model->get_time_interval($permohonan->created_at) ?> lalu</small>
															<small class="badge badge-danger mr-1"><i class="far fa-clock mr-1"></i> Menunggu persetujuan</small>
														<?php } ?>
														<?php if (!is_null($permohonan->disetujui_at) && is_null($permohonan->selesai_at)) { ?>
															<small class="badge badge-warning"><i class="fas fa-check mr-1"></i> Disetujui</small>
														<?php } ?>
														<?php if (!is_null($permohonan->ditolak_at)) { ?>
															<small class="badge badge-danger"><i class="fas fa-times mr-1"></i> Ditolak</small>
														<?php } ?>
														<?php if (!is_null($permohonan->selesai_at)) { ?>
															<small class="badge badge-success"><i class="fas fa-check mr-1"></i>Bimbingan Selesai</small>
														<?php } ?>
													</td>
													<td class="col-2">
														<div class="d-flex flex-column flex-lg-row">
															<?php if (
																is_null($permohonan->disetujui_at)
																&& is_null($permohonan->ditolak_at)
															) { ?>
																<?php if (is_null($permohonan->disetujui_at) && is_null($permohonan->selesai_at)) { ?>
																	<button class="btn btn-sm btn-outline-success p-1 mr-1 mb-1 btn-bimbingan-accept" idBimbingan="<?= $permohonan->id ?>" onclick="bimbinganAccept(this)" data-toggle="modal" data-target="#modal-accept-bimbingan">
																		<i class="fas fa-check m-1 "></i>
																	</button>
																<?php } ?>
																<?php if (is_null($permohonan->ditolak_at) && is_null($permohonan->selesai_at)) { ?>
																	<button class="btn btn-sm btn-outline-danger p-1 mr-1 mb-1 btn-bimbingan-reject" idBimbingan="<?= $permohonan->id ?>" onclick="bimbinganReject(this)" data-toggle="modal" data-target="#modal-reject-bimbingan">
																		<i class="fas fa-times m-1"></i>
																	</button>
																<?php } ?>
															<?php } ?>
															<a class="btn btn-sm btn-outline-primary p-1 mr-1 mb-1" href="<?= base_url('permohonan/' . $permohonan->id . '') ?>">
																<i class="fas fa-eye m-1"></i>
															</a>
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

	<div class="modal fade" id="modal-accept-bimbingan">
		<div class="modal-dialog">
			<div class="modal-content  ">
				<div class="modal-header">
					<h4 class="modal-title">Terima Permohonan Bimbingan?</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Anda akan menerima permohonan bimbingan</p>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-sm btn-outline-light" data-dismiss="modal">Tutup</button>
					<form action="<?= base_url('permohonan/accept') ?>" method="post">
						<input type="hidden" name="idBimbingan" id="inputIdBimbinganAccept" value="">
						<button type="submit" class="btn btn-sm btn-success btn-block">
							<i class="fas fa-check"></i>
							Terima
						</button>
					</form>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<div class="modal fade" id="modal-reject-bimbingan">
		<div class="modal-dialog">
			<div class="modal-content  ">
				<div class="modal-header">
					<h4 class="modal-title">Tolak Permohonan Bimbingan?</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Anda akan menolak permohonan bimbingan. Mohon berikan keterangan.</p>
					<label for="txtKeteranganDosenArea">Keterangan menolak</label>
					<textarea class="form-control" name="txtKeteranganDosenArea" id="txtKeteranganDosenArea" cols="30" rows="4"></textarea>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-sm btn-outline-light" data-dismiss="modal">Tutup</button>
					<form action="<?= base_url('permohonan/reject') ?>" method="post" onsubmit="moveKeterangan()">
						<input type="hidden" name="idBimbingan" id="inputIdBimbinganReject" value="">
						<input type="hidden" name="txtKeteranganDosen" id="txtKeteranganDosenField" value="">
						<button type="submit" class="btn btn-sm btn-danger btn-block">
							<i class="fas fa-times"></i>
							Tolak
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
		function bimbinganAccept(target) {
			var idBimbingan = $(target).attr('idBimbingan');
			var formField = $('#inputIdBimbinganAccept');
			$(formField).val(idBimbingan);
			console.log(formField);
		}

		function bimbinganReject(target) {
			var idBimbingan = $(target).attr('idBimbingan');
			var formField = $('#inputIdBimbinganReject');
			$(formField).val(idBimbingan);
		}

		function moveKeterangan() {
			var txtKeterangan = $('#txtKeteranganDosenArea').val();
			var keteranganField = $('#txtKeteranganDosenField');
			$(keteranganField).val(txtKeterangan);
		}

		$(function() {
			$("#tabelPermohonan").DataTable({
				"responsive": true,
				"lengthChange": true,
				"autoWidth": true,
				"buttons": ["colvis", "pageLength"]
			}).buttons().container().appendTo('#tabelPermohonan_wrapper .col-md-6:eq(0)');

		});
	</script>

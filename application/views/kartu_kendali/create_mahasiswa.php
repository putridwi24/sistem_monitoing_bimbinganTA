<?php $this->load->view('template/head', [
	'title' => 'Buat Kartu Kendali',
]);
?>

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
							<h1 class="m-0">Buat Kartu Kendali </h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Dashboard</a></li>
								<li class="breadcrumb-item"><a href="<?php echo base_url('kartu_kendali') ?>">Kartu Kendali</a></li>
								<li class="breadcrumb-item active">Buat</li>
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
						<div class="col-12 col-md-11">
							<form action="<?= base_url('kartu_kendali/create') ?>" method="post">
								<div class="card">
									<div class="card-body">
										<div class="d-flex ">
											<div class="p-2  w-100">
												<form action="<?= base_url('permohonan/create') ?>" method="post" novalidate>
													<!-- dosen pembimbing -->
													<div class="form-group row">
														<label class="col-12 col-lg-3 col-form-label" for="txtDosenNip">Dosen Pembimbing</label>
														<div class="col-12 col-lg-9">
															<select class="form-control <?= form_error('txtDosenNip') ? 'is-invalid' : '' ?>" name="txtDosenNip">
																<option selected value="">Pilih dosen</option>
																<option value="<?= $mahasiswa->dosbing_1->nip ?>"><?= $mahasiswa->dosbing_1->user->name ?></option>
																<option value="<?= $mahasiswa->dosbing_2->nip ?>"><?= $mahasiswa->dosbing_2->user->name ?></option>
															</select>
															<div class="invalid-feedback">
																<?= form_error('txtDosenNip'); ?>
															</div>
														</div>
													</div>
													<!-- kegiatan -->
													<div class="form-group row">
														<label class="col-12 col-lg-3 col-form-label" for="txtKegiatan">Kegiatan</label>
														<div class="col-12 col-lg-9">
															<textarea class="form-control <?= form_error('txtKegiatan') ? 'is-invalid' : '' ?>" name="txtKegiatan" id="txtKegiatan" rows="3" placeholder="Tambahkan keterangan"><?= set_value('txtKegiatan') ?></textarea>
															<div class="invalid-feedback">
																<?= form_error('txtKegiatan'); ?>
															</div>
														</div>
													</div>
													<!-- submit -->
													<div class="d-flex flex-row justify-content-end no-stretch">
														<div>
															<button type="submit" class="btn btn-primary btn-block">Simpan</button>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!-- /.row (main row) -->
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
	<script src="<?= base_url('public/plugins') ?>/bs-custom-file-input/bs-custom-file-input.min.js"></script>
	<script>
		$(function() {
			// Summernote
			$('#txtKegiatan').summernote()
		})
	</script>
</body>

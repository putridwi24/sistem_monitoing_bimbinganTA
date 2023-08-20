<?php $this->load->view('template/head', [
	'title' => 'Pengumuman',
]);
?>

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
							<h1 class="m-0">Permohonan Bimbingan </h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?php echo base_url('dosen/beranda') ?>">Beranda</a></li>
								<li class="breadcrumb-item"><a href="<?= base_url('permohonan') ?>"> Permohonan Bimbingan</a></li>
								<li class="breadcrumb-item active">Detail</li>

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
						<div class="col-12 col-md-11">
							<div class="card">
								<!-- /.card-header -->
								<div class="card-body  ">
									<!-- /.card-header -->
									<div class="d-flex">
										<div class="p-2  w-100">
											<!-- nama mahasiswa ineditable -->
											<div class="form-group row">
												<span class="col-12 col-lg-3 text-lg-left">
													<strong>
														Nama Mahasiswa
													</strong>
												</span>
												<span class="col-12 col-lg-9">
													<?= $mahasiswa->user->name ?>
												</span>
											</div>
											<!-- judul ta -->
											<div class="form-group row">
												<span class="col-12 col-lg-3 text-lg-left">
													<strong>
														Judul Tugas Akhir
													</strong>
												</span>
												<span class="col-12 col-lg-9">
													<?= $permohonan->judul_ta ?>
												</span>
											</div>
											<!-- dosen pembimbing -->
											<div class="form-group row">
												<span class="col-12 col-lg-3 text-lg-left">
													<strong>
														Dosen Pembimbing
													</strong>
												</span>
												<span class="col-12 col-lg-9">
													<?= $dosen->nip ?>
												</span>
											</div>
											<!-- waktu dan tanggal bimbingan -->
											<div class="form-group row">
												<span class="col-12 col-lg-3 text-lg-left">
													<strong>
														Tanggal Bimbingan
													</strong>
												</span>
												<span class="col-12 col-lg-9">
													<?= $permohonan->waktu_bimbingan ?>
												</span>
											</div>
											<!-- keterangan mahasiswa -->
											<div class="form-group row">
												<span class="col-12 col-lg-3 text-lg-left">
													<strong>
														Keterangan Mahasiswa
													</strong>
												</span>
												<span class="col-12 col-lg-9">
													<?= $permohonan->keterangan_mahasiswa ?>
												</span>
											</div>

											<?php if (!is_null($permohonan->ditolak_at)) { ?>
												<!-- keterangan dosen -->
												<div class="form-group row">
													<span class="col-12 col-lg-3 text-lg-left">
														<strong>
															Keterangan Dosen
														</strong>
													</span>
													<span class="col-12 col-lg-9">
														<?= $permohonan->keterangan_dosen ?>
													</span>
												</div>
											<?php } ?>

											<!-- file ta -->
											<div class="form-group row">
												<span class="col-12 col-lg-3 text-lg-left">
													<strong>
														File TA
													</strong>
												</span>
												<span class="col-12 col-lg-9">
													<?php if ($permohonan->file_ta) { ?>
														<a class="btn btn-sm btn-info mt-1" href="<?= base_url(URL_BIMBINGAN_ATTACHMENT . $permohonan->file_ta) ?>">
															<i class="fas fa-file-alt p-1"></i>
															<span class="d-inline"><?= $permohonan->file_ta ?></span>
														</a>
													<?php } ?>
												</span>

											</div>

											<!-- submit -->
											<div class="d-flex flex-row justify-content-end no-stretch">
												<?php if (is_null($permohonan->disetujui_at) && is_null($permohonan->ditolak_at) && is_null($permohonan->selesai_at)) { ?>
													<form action="<?= base_url('permohonan/accept') ?>" method="post" class="ml-2">
														<input type="hidden" name="idBimbingan" id="inputIdBimbinganAccept" value="<?= $permohonan->id ?>">
														<button type="submit" class="btn btn-sm btn-success btn-block">
															<i class="fas fa-check"></i>
															Terima
														</button>
													</form>
												<?php } ?>
												<?php if (is_null($permohonan->ditolak_at) && is_null($permohonan->disetujui_at) && is_null($permohonan->selesai_at)) { ?>
													<form action="<?= base_url('permohonan/reject') ?>" method="post" class="ml-2">
														<input type="hidden" name="idBimbingan" id="inputIdBimbinganReject" value="<?= $permohonan->id ?>">
														<button type="submit" class="btn btn-sm btn-danger btn-block">
															<i class="fas fa-times"></i>
															Tolak
														</button>
													</form>
												<?php } ?>
											</div>
										</div>

									</div>
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
			<strong>Copyright &copy; Sistem Monitoring Bimbingan Tugas Akhir IF ITERA
			</strong>
			<div class="float-right d-none d-sm-inline-block">
				<b>Version</b> 3.2.0
			</div>
		</footer>

	</div>
	<?php $this->load->view('template/tile') ?>

	<script src="<?= base_url('public/plugins') ?>/bs-custom-file-input/bs-custom-file-input.min.js"></script>
	<script>
		$(function() {
			// Summernote
			$('#summernote').summernote()

			// CodeMirror
			CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
				mode: "htmlmixed",
				theme: "monokai"
			});
		})


		//Date and time picker
		$('#txtTanggalWaktuBimbingan').datetimepicker({
			icons: {
				time: 'far fa-clock'
			}
		});


		$(function() {
			bsCustomFileInput.init();
		});
	</script>

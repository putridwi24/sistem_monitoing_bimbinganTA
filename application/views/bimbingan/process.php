<?php $this->load->view('template/head', [
	'title' => 'Pengumuman',
]);

?>

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
							<h1 class="m-0">Bimbingan <?= $mahasiswa->user->name ?></h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?php echo base_url('beranda/dosen') ?>">Beranda</a></li>
								<li class="breadcrumb-item"><a href="<?php echo base_url('bimbingan') ?>">Bimbingan</a></li>
								<li class="breadcrumb-item active">Proses</li>

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
							<form class="" action="<?= base_url('bimbingan/' . $bimbingan->id . '/process') ?>" method="post">
								<input type="hidden" name="idBimbingan" id="inputIdBimbinganAccept" value="<?= $bimbingan->id ?>">
								<div class="card">
									<!-- /.card-header -->
									<div class="card-header">
										<div class="d-flex flex-row justify-content-end no-stretch">
											<div class="custom-control custom-checkbox ml-3">
												<input type="checkbox" class="custom-control-input" id="txtBimbinganSelesai" name="txtBimbinganSelesai" <?= ($bimbingan->selesai_at) ? 'checked' : '' ?> value="1">
												<label class="custom-control-label" for="txtBimbinganSelesai">Bimbingan Selesai</label>
											</div>
											<div class="ml-3">
												<button type="submit" class="btn btn-sm btn-success btn-block">Simpan</button>
											</div>
										</div>
									</div>
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
														<strong>Judul Tugas Akhir
														</strong>
													</span>
													<span class="col-12 col-lg-9">
														<?= $bimbingan->judul_ta ?>
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
														<?= $bimbingan->waktu_bimbingan ?>
													</span>
												</div>
												<!-- keterangan mahasiswa -->
												<div class="form-group row">
													<span class="col-12 col-lg-3 text-lg-left">
														<strong>
															Dosen
														</strong>
													</span>
													<span class="col-12 col-lg-9">
														<?= $bimbingan->keterangan_mahasiswa ?>
													</span>
												</div>

												<!-- file ta -->
												<div class="form-group row">
													<span class="col-12 col-lg-3 text-lg-left">
														<strong>
															File TA
														</strong>
													</span>
													<span class="col-12 col-lg-9">
														<?php if ($bimbingan->file_ta) { ?>
															<a class="btn btn-sm btn-info mt-1" href="<?= base_url(URL_BIMBINGAN_ATTACHMENT . $bimbingan->file_ta) ?>">
																<i class="fas fa-file-alt p-1"></i>
																<span class="d-inline"><?= $bimbingan->file_ta ?></span>
															</a>
														<?php } ?>
													</span>

												</div>
												<!-- keterangan dosen -->
												<hr>
												<div class=" form-group row">
													<span class="col-12 col-lg-3 text-lg-left mb-2">
														<strong>
															Keterangan Dosen
														</strong>
													</span>
													<div class="col-12 col-lg-9">
														<textarea class="col-12 <?= form_error('txtKeteranganDosen') ? 'is-invalid' : '' ?> " name="txtKeteranganDosen" id="txtKeteranganDosen" cols="30" rows="8">
															<?= $bimbingan->keterangan_dosen ?>
														</textarea>
														<div class="invalid-feedback ">
															<?= form_error('txtKeteranganDosen') ?>
														</div>
														<?php if (form_error('txtKeteranganDosen')) { ?>
														<?php } ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
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
			$('#txtKeteranganDosen').summernote()

			// CodeMirror
			CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
				mode: "htmlmixed",
				theme: "monokai"
			});
		})
	</script>

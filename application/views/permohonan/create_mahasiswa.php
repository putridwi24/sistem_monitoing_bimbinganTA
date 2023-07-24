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
							<h1 class="m-0">Tambah Permohonan Bimbingan </h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?php echo base_url('mahasiswa/beranda') ?>">Beranda</a></li>
								<li class="breadcrumb-item active">Tambah Bimbingan </li>

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
						<div class="col-sm-12">
							<div class="card">
								<!-- /.card-header -->
								<div class="card-body flex-fill">
									<!-- /.card-header -->
									<div class="d-flex ">
										<div class="p-2  w-100">
											<form action="<?= base_url('permohonan/create') ?>" method="post" enctype="multipart/form-data" novalidate>
												<!-- nama mahasiswa ineditable -->
												<div class="form-group row">
													<label class="col-12 col-lg-3 col-form-label" for="txtName">Nama Mahasiswa</label>
													<div class="col-12 col-lg-9 ">
														<input type="text" class="form-control" name="txtName" id="txtName" disabled value="<?= $mahasiswa->user->name ?>">
													</div>
												</div>
												<!-- judul ta -->
												<div class="form-group row">
													<label class="col-12 col-lg-3 col-form-label" for="txtEmail">Judul Tugas Akhir</label>
													<div class="col-12 col-lg-9">
														<input type="text" class="form-control <?= form_error('txtJudulTa') ? 'is-invalid' : '' ?>" name="txtJudulTa" id="txtJudulTa" value="<?= $mahasiswa->judul_ta ?>">
														<div class="invalid-feedback">
															<?= form_error('txtJudulTa'); ?>
														</div>
													</div>
												</div>
												<!-- dosen pembimbing -->
												<div class="form-group row">
													<label class="col-12 col-lg-3 col-form-label" for="txtDosbing">Dosen Pembimbing</label>
													<div class="col-12 col-lg-9">
														<select class="form-control <?= form_error('txtDosbing') ? 'is-invalid' : '' ?>" name="txtDosbing">
															<option selected value="">Pilih dosen</option>
															<option value="<?= $mahasiswa->dosbing_1->nip ?>"><?= $mahasiswa->dosbing_1->user->name ?></option>
															<option value="<?= $mahasiswa->dosbing_2->nip ?>"><?= $mahasiswa->dosbing_2->user->name ?></option>
														</select>
														<div class="invalid-feedback">
															<?= form_error('txtDosbing'); ?>
														</div>
													</div>
												</div>
												<!-- waktu dan tanggal bimbingan -->
												<div class="form-group row">
													<label class="col-12 col-lg-3 col-form-label">Date and time</label>
													<div name="txtTanggalWaktuBimbingan" class="input-group date col-12 col-lg-9" id="c" data-target-input="nearest">
														<input type="text" class="form-control datetimepicker-input <?= form_error('txtTanggalWaktu') ? 'is-invalid' : '' ?> " data-target="#txtTanggalWaktuBimbingan" name="txtTanggalWaktu" id="txtTanggalWaktuBimbingan" value="<?= set_value('txtTanggalWaktu') ?>" />
														<div class="input-group-append" data-target="#txtTanggalWaktuBimbingan" data-toggle="datetimepicker">
															<div class="input-group-text"><i class="fa fa-calendar"></i></div>
														</div>
														<div class="invalid-feedback">
															<?= form_error('txtTanggalWaktu'); ?>
														</div>
													</div>
												</div>
												<!-- keterangan mahasiswa -->
												<div class="form-group row">
													<label class="col-12 col-lg-3 col-form-label" for="txtKeteranganMahasiswa">Keterangan Mahasiswa</label>
													<div class="col-12 col-lg-9">
														<textarea class="form-control <?= form_error('txtKeteranganMahasiswa') ? 'is-invalid' : '' ?>" name="txtKeteranganMahasiswa" id="txtKeteranganMahasiswa" rows="3" placeholder="Tambahkan keterangan"><?= set_value('txtKeteranganMahasiswa') ?></textarea>
														<div class="invalid-feedback">
															<?= form_error('txtKeteranganMahasiswa'); ?>
														</div>
													</div>
												</div>

												<!-- file ta -->
												<div class="form-group row">
													<label class="col-12 col-lg-3 col-form-label" for="fileAttach">File Sisipan</label>
													<div class="input-group col-12 col-lg-9">
														<div class="custom-file">
															<input type="file" class="custom-file-input <?= form_error('fileAttach') ? 'is-invalid' : '' ?>" id="fileAttach" name="fileAttach">
															<label class="custom-file-label" for="exampleInputFile">Pilih file</label>
														</div>
														<div class="invalid-feedback">
															<?= form_error('fileAttach'); ?>
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

	<script src="<?= base_url('public/plugins') ?>/bs-custom-file-input/bs-custom-file-input.min.js"></script>
	<script>
		$(function() {
			// Summernote
			$('#summernote').summernote()
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

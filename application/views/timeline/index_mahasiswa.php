<?php $this->load->view('template/head', [
	'title' => 'Bimbingan Mahasiswa'
]); ?>

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
							<h1 class="m-0">Timeline Laporan Tugas Akhir</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?php echo base_url('mahasiswa/beranda') ?>">Beranda</a></li>
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
					<div class="row">
						<div class="col-12">
							<div class="card">
								<!-- /.card-header -->
								<div class="card-body  ">
									<div class="row">
										<div class="col-8">
											<div class="p-2  w-100">
												<!-- nama mahasiswa ineditable -->
												<div class="form-group row">
													<span class="col-12 col-lg-3 text-lg-right">
														<strong>
															Nama Mahasiswa
														</strong>
													</span>
													<span class="col-12 col-lg-9">
														<?= $mahasiswa->user->name ?>
													</span>
												</div>
												<div class="form-group row">
													<span class="col-12 col-lg-3 text-lg-right">
														<strong>
															Email
														</strong>
													</span>
													<span class="col-12 col-lg-9">
														<?= $mahasiswa->user->email ?>
													</span>
												</div>
												<!-- nim -->
												<div class="form-group row">
													<span class="col-12 col-lg-3 text-lg-right">
														<strong>NIM
														</strong>
													</span>
													<span class="col-12 col-lg-9">
														<?= $mahasiswa->nim ?>
													</span>
												</div>
												<!-- judul ta -->
												<div class="form-group row">
													<span class="col-12 col-lg-3 text-lg-right">
														<strong>Judul Tugas Akhir
														</strong>
													</span>
													<span class="col-12 col-lg-9">
														<?= $mahasiswa->judul_ta ?>
													</span>
												</div>
												<!-- dosen pembimbing -->
												<div class="form-group row">
													<span class="col-12 col-lg-3 text-lg-right">
														<strong>
															Dosen Pembimbing 1
														</strong>
													</span>
													<span class="col-12 col-lg-9">
														<?= $mahasiswa->dosbing_1->user->name ?>
													</span>
												</div>
												<div class="form-group row">
													<span class="col-12 col-lg-3 text-lg-right">
														<strong>
															Dosen Pembimbing 2
														</strong>
													</span>
													<span class="col-12 col-lg-9">
														<?= $mahasiswa->dosbing_2->user->name ?>
													</span>
												</div>
											</div>

										</div>
										<div class="col-4 col-lg-4 d-flex flex-column justify-content-center align-items-center">
											<div class="text-center">
												<input type="text" class="knob" value="<?= $this->progres_model->calculate_percentage_progres_id($progres->id) ?>%" data-width="180" data-height="180" data-fgColor="#932ab6" readonly>
												<div class="knob-label h5 mt-2"><?= $this->progres_model->calculate_percentage_progres_id($progres->id) ?>%</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<!-- /.card-header -->
								<div class="card-body  ">
									<h3 class="pb-2">Timeline Laporan TA</h3>
									<div class="d-flex flex-row justify-content-start ">
										<?php if ($progres) { ?>
											<?php foreach ($progres->progres_data as $stage => $status) { ?>
												<?php $this->load->view('template/smallbox_timeline', ['stage' => $stage, 'status' => $status]) ?>
											<?php } ?>
										<?php } else { ?>
											<strong>Anda belum melengkapi data mahasiswa. Silakan melengkapi data mahasiswa pada <a href="<?= base_url('profile') ?>">Pengaturan Profil</a></strong>
										<?php } ?>
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
</body>
<script src="<?= base_url('plugins/jquery-knob/jquery.knob.min.js') ?>"></script>

<script>
	$(function() {
		/* jQueryKnob */

		$('.knob').knob({})
		/* END JQUERY KNOB */
	})
</script>

<?php $this->load->view('template/head', [
	'title' => 'Beranda Mahasiswa',
]); ?>

<body class="layout-fixed layout-navbar-fixed layout-footer-fixed">
	<div class="wrapper">

		<!-- SIDEBAR -->
		<?php $this->load->view('template/sidebar', [
			'menu_name' => 'beranda_mahasiswa'
		]) ?>


		<!-- CONTENT -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0">Beranda</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?php echo base_url('mahasiswa/beranda') ?>">Beranda</a></li>
							</ol>
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- /.container-fluid -->
			</div>
			<!-- /.content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					<?php $this->load->view('template/header_message') ?>
					<!-- Small boxes (Stat box) -->
					<div class="row ">
						<div class="col-6 col-lg-3">
							<div class="small-box p-2 bg-info p-2">
								<div class="inner  ">
									<p>Jumlah Bimbingan </p>
									<h3>
										<?= count($bimbingans) ?>
									</h3>
								</div>
								<div class="icon">
									<i class="fas fa-clipboard"></i>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<section class="col-12">
							<div class="card">
								<!-- /.card-header -->
								<div class="card-body  ">
									<h5 class="pb-2">Timeline Laporan TA</h5>
									<div class="d-flex flex-row justify-content-start ">
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
						</section>
					</div>
					<!-- /.row -->
					<!-- Main row -->
					<div class="row">
						<!-- Left col -->
						<section class=" col-12 connectedSortable">
							<?php $this->load->view('template/card_pengumuman') ?>
						</section>
						<!-- /.Left col -->
						<!-- right col -->
					</div>
					<!-- /.row (main row) -->
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

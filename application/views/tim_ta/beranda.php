<?php $this->load->view('template/head', [
	'title' => 'Dashboard Tim TA',
]); ?>

<body class="sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
	<div class="wrapper">

		<!-- SIDEBAR -->
		<?php $this->load->view('template/sidebar', [
			'menu_name' => 'dashboard'
		]) ?>


		<!-- CONTENT -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<!-- <h1 class="m-0">Beranda</h1> -->
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Dashboard</a></li>
							</ol>
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- /.container-fluid -->
			</div>
			<!-- /.content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					<!-- Small boxes (Stat box) -->
					<div class="row">
						<!-- <section class="col-lg-8 col-12 row connectedSortable"> -->
						<div class=" col-3 col-lg-3">
							<div class="small-box bg-info p-2">
								<div class="inner text-center">
									<p>
									<h5>Jumlah Dosen Pembimbing </h5>
									</p>
									<h4><?= count($dosbings) ?></h4>
								</div>
								<div class="icon">
									<i class="fas fa-users"></i>
								</div>
							</div>
						</div>
						<div class="col-3 col-lg-3">
							<div class="small-box bg-info p-2">
								<div class="inner text-center">
									<p>
									<h5>Jumlah Mahasiswa </h5>
									</p>
									<h4><?= count($mahasiswas) ?></h4>
								</div>
								<div class="icon">
									<i class="fas fa-graduation-cap"></i>
								</div>
							</div>
						</div>

						<div class="col-3 col-lg-3">
							<div class="small-box bg-info p-2">
								<div class="inner text-center">
									<p>
									<h5>Telah Seminar Proposal </h5>
									</p>
									<h4><?= count($sempros) ?></h4>
								</div>
								<div class="icon">
									<i class="fas fa-graduation-cap"></i>
								</div>
							</div>
						</div>

						<div class="col-3 col-lg-3">
							<div class="small-box bg-info p-2">
								<div class="inner text-center">
									<p>
									<h5>Telah Sidang Akhir </h5>
									</p>
									<h4><?= count($sidangs) ?></h4>
								</div>
								<div class="icon">
									<i class="fas fa-graduation-cap"></i>
								</div>
							</div>
						</div>
						<!-- </section> -->
					</div>
					<!-- /.row -->
					<!-- Main row -->
					<div class="row">
						<!-- Left col -->
						<section class="col-lg-12 col-12 connectedSortable">
							<?php $this->load->view('template/card_pengumuman_dashboard') ?>
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

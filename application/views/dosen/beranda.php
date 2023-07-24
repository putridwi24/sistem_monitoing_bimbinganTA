<?php $this->load->view('template/head', [
	'title' => 'Beranda Dosen',
]);

?>

<body class="sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
	<div class="wrapper">

		<!-- SIDEBAR -->
		<?php $this->load->view('template/sidebar', [
			'menu_name' => 'beranda_dosen'
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
								<li class="breadcrumb-item"><a href="<?php echo base_url('dosen/beranda') ?>">Beranda</a></li>
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
						<div class="col-6 col-lg-3">
							<div class="small-box p-2" style="background-color: #1D6AA7">
								<div class="inner" style="color: white">
									<p>Jumlah Mahasiswa Bimbingan </p>
									<h3><?= count($mahasiswas) ?></h3>
								</div>
								<div class="icon">
									<i class="fas fa-user-friends"></i>
								</div>
							</div>
						</div>
						<?php foreach ($stages as $key => $stage) { ?>
							<div class="col-6 col-lg-3">
								<div class="small-box p-2" style="background-color: #1D6AA7">
									<div class="inner" style="color: white">
										<p>Mahasiswa Selesai <?= $stage->name ?></p>
										<h3><?= count($stage->mahasiswas) ?></h3>
									</div>
									<div class="icon">
										<i class="fas fa-book"></i>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
					<!-- /.row -->
					<!-- Main row -->
					<div class="row">
						<!-- Left col -->
						<section class=" col-12 connectedSortable">
							<?php $this->load->view('template/card_pengumuman_beranda') ?>
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

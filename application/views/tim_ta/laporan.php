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
							<h1 class="m-0">Timeline Tugas Akhir Mahasiswa</h1>
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
									<h3 class="pb-2">Data Mahasiswa</h3>
									<table class="table text-wrap table-md table-borderless">
										<tr>
											<td>Nama</td>
											<td>Lorem ipsum dolor sit amet.</td>
										</tr>
										<tr>
											<td>NIM</td>
											<td>1234567</td>
										</tr>
										<tr>
											<td>Email</td>
											<td>email@site.com</td>
										</tr>
										<tr>
											<td>Judul TA</td>
											<td>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Exercitationem eaque quas cum eos consectetur perspiciatis. Consectetur eligendi esse hic cumque!</td>
										</tr>
										<tr>
											<td>Dosen Pembimbing I</td>
											<td>Lorem ipsum dolor sit.</td>
										</tr>
										<tr>
											<td>Dosen Pembimbing II</td>
											<td>Lorem ipsum dolor sit.</td>
										</tr>
									</table>
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
										<div class="small-box mr-2 bg-success p-2">
											<div class="inner text-center">
												<span class="h5">BAB I</span>
											</div>
										</div>
										<div class="small-box mr-2 bg-success p-2">
											<div class="inner text-center">
												<span class="h5">BAB II</span>
											</div>
										</div>
										<div class="small-box mr-2 bg-secondary p-2">
											<div class="inner text-center">
												<span class="h5">BAB III</span>
											</div>
										</div>
										<div class="small-box mr-2 bg-secondary p-2">
											<div class="inner text-center">
												<span class="h5">SEMINAR PROPOSAL</span>
											</div>
										</div>
										<div class="small-box mr-2 bg-secondary p-2">
											<div class="inner text-center">
												<span class="h5">BAB IV</span>
											</div>
										</div>
										<div class="small-box mr-2 bg-secondary p-2">
											<div class="inner text-center">
												<span class="h5">BAB V</span>
											</div>
										</div>
										<div class="small-box mr-2 bg-secondary p-2">
											<div class="inner text-center">
												<span class="h5">SIDANG AKHIR</span>
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

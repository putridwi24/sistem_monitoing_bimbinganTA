<?php $this->load->view('template/head', [
	'title' => 'Bimbingan Mahasiswa'
]); ?>

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
							<h1 class="m-0">Bimbingan Mahasiswa</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?php echo base_url('mahasiswa/bimbingan') ?>">Beranda</a></li>
								<li class="breadcrumb-item active">Bimbingan Mahasiswa</li>
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
								<div class="card-header">
									<button type="submit" class="btn btn-primary btn-sm">
										<i class="fas fa-plus pr-1"></i>
										Tambah bimbingan
									</button>
									<div class="card-tools">
										<div class="input-group input-group-sm" style="width: 150px;">
											<input type="text" name="table_search" class="form-control float-right" placeholder="Cari">

											<div class="input-group-append">
												<button type="submit" class="btn btn-default">
													<i class="fas fa-search"></i>
												</button>
											</div>
										</div>
									</div>
								</div>
								<!-- /.card-header -->
								<div class="card-body table-responsive p-0">
									<table class="table table-hover  text-wrap">
										<thead>
											<tr>
												<th>No</th>
												<th>Dosen Pembimbing</th>
												<th>Judul TA</th>
												<th>Tanggal/Waktu</th>
												<th>File TA</th>
												<th>Keterangan Mahasiswa</th>
												<th>Keterangan Dosen</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>1</td>
												<td>Nama Dosen</td>
												<td>Judul TA</td>
												<td>
													30-03-2023 13:30:00
												</td>
												<td>
													<a class="btn btn-sm btn-info" href="#">
														<i class="fas fa-file p-1"></i>
														<span class="d-inline">File TA</span>
													</a>
												</td>
												<td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati voluptate, rem eveniet animi omnis sed.</td>
												<td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero assumenda nostrum ut. Voluptatem, nulla necessitatibus?</td>
											</tr>
										</tbody>
									</table>
								</div>
								<!-- /.card-body -->
								<div class="card-footer">
									<ul class="pagination pagination-sm m-0 float-right">
										<li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
										<li class="page-item"><a class="page-link" href="#">1</a></li>
										<li class="page-item"><a class="page-link" href="#">2</a></li>
										<li class="page-item"><a class="page-link" href="#">3</a></li>
										<li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
									</ul>
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

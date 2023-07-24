<?php $this->load->view('template/head', [
	'title' => 'Pengumuman',
]);
?>

<body class="sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
	<div class="wrapper">

		<!-- SIDEBAR -->
		<?php $this->load->view('template/sidebar', [
			'menu_name' => 'pengumuman_all'
		]) ?>

		<!-- CONTENT -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0">Pengumuman </h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?php echo base_url('tim_ta/beranda') ?>">Beranda</a></li>
								<li class="breadcrumb-item active">Pengumuman </li>

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
						<div class="col-sm d-flex">
							<div class="card card-body flex-fill">
								<!-- /.card-header -->
								<div class="card-header">
									<div class="d-flex flex-row justify-content-between">
										<div class="d-inline">
											<h3 class="card-title" style="color: #449BEC">
												<b>
													<?= $pengumuman->title ?>
												</b>
											</h3>
										</div>
										<div class="d-inline">
											<div class="btn btn-sm bg-light ">
												<i class="fas fa-edit"></i>
												Diupdate pada <?= $pengumuman->updated_at ?>
											</div>
											<div class="btn btn-sm bg-light ">
												<i class="fas fa-bullhorn"></i>
												Diupload pada <?= $pengumuman->release_at ?>
											</div>
										</div>
									</div>
								</div>
								<div class="card-body ">
									<div class="">
										<div class="row">
											<div class="col-12 py-2">
												<?= $pengumuman->info ?>
											</div>
											<div class="col-12 py-2">
												<hr>
												<div class="d-flex">
													<?php foreach ($pengumuman->attachment as $attachment) { ?>
														<div class="mr-1 mt-1">
															<a class="btn btn-sm btn-primary" href="<?= base_url(ATTACHMENT_URL . $attachment) ?>">
																<i class="fas fa-file-alt"></i>
																<span> <?= ($attachment) ?></span>
															</a>
														</div>
													<?php } ?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
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
	</script>

<?php $this->load->view('template/head', [
	'title' => 'Progres ' . $mahasiswa->user->name
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
							<h1 class="m-0">Timeline <?= $mahasiswa->user->name ?> </h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?php echo base_url('beranda/dosen') ?>">Beranda</a></li>
								<li class="breadcrumb-item"><a href="<?php echo base_url('timeline') ?>">Timeline Laporan</a></li>
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
					<?php $this->load->view('template/header_message') ?>
					<div class="row">
						<div class="col-12 col-md-11">
							<div class="card">
								<!-- /.card-header -->
								<div class="card-body  ">
									<div class="row">
										<div class="col-8 col-lg-8">
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
												<div class="form-group row">
													<span class="col-12 col-lg-3 text-lg-left">
														<strong>
															Email
														</strong>
													</span>
													<span class="col-12 col-lg-9">
														<?= $mahasiswa->user->email ?>
													</span>
												</div>
												<!-- judul ta -->
												<div class="form-group row">
													<span class="col-12 col-lg-3 text-lg-left">
														<strong>Judul Tugas Akhir
														</strong>
													</span>
													<span class="col-12 col-lg-9">
														<?= $mahasiswa->judul_ta ?>
													</span>
												</div>
												<!-- dosen pembimbing -->
												<div class="form-group row">
													<span class="col-12 col-lg-3 text-lg-left">
														<strong>
															Dosen Pembimbing 1
														</strong>
													</span>
													<span class="col-12 col-lg-9">
														<?= $mahasiswa->dosbing_1->user->name ?>
													</span>
												</div>
												<div class="form-group row">
													<span class="col-12 col-lg-3 text-lg-left">
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
						<div class="col-12 col-md-11">
							<div class="card">
								<!-- /.card-header -->
								<div class="card-body  ">
									<h4 class="pb-2">Timeline Laporan TA</h4>
									<div class="d-flex flex-row justify-content-start ">
										<div class="d-flex flex-row justify-content-start ">
											<?php if ($progres) { ?>
												<?php foreach ($progres->progres_data as $stage => $status) { ?>
													<?php $this->load->view('template/smallbox_timeline_updater', ['stage' => $stage, 'status' => $status]) ?>
												<?php } ?>
											<?php } else { ?>
												<strong>Anda belum melengkapi data mahasiswa. Silakan melengkapi data mahasiswa pada <a href="<?= base_url('profile') ?>">Pengaturan Profil</a></strong>
											<?php } ?>
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

	<div class="modal fade" id="modal-update-progres">
		<div class="modal-dialog">
			<div class="modal-content  ">
				<div class="modal-header">
					<h4 class="modal-title">Update progres <span class="stageNameField"></span></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<div class="col-12 d-flex flex-row align-content-stretch">
							<?php
							$statuses = $this->progres_model->get_statuses();
							?>
							<?php foreach ($statuses as $key => $status) { ?>
								<form class="p-2" action="<?= base_url('timeline/update') ?>" method="post">
									<input type="hidden" name="txtProgresId" value="<?= $progres->id ?>">
									<input type="hidden" name="txtStageId" value="" class="stageIdField">
									<input type="hidden" name="txtStatusId" value="<?= $status->id ?>" class="">
									<button type="submit" class="btn btn-lg <?= $this->progres_model->get_display_color_class_status_id($status->id) ?>"><?= $status->name ?></button>
								</form>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-sm btn-outline-light" data-dismiss="modal">Tutup</button>
					<!-- <button type="submit" class="btn btn-sm btn-success ">
							<i class="fas fa-check"></i>
							Terima
						</button> -->
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>

	<?php $this->load->view('template/tile') ?>
</body>
<!-- jQuery Knob -->
<script src="<?= base_url('plugins/jquery-knob/jquery.knob.min.js') ?>"></script>
<script>
	function updateProgres(target) {
		var stageId = $(target).attr('stageId');
		$('.stageIdField').val(stageId);
		var stageName = $(target).attr('stageName');
		$('.stageNameField').text(stageName);

		console.log(stageId);
	}
	$(function() {
		/* jQueryKnob */

		$('.knob').knob({})
		/* END JQUERY KNOB */
	})
</script>

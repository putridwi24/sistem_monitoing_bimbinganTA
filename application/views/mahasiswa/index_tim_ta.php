<?php $this->load->view('template/head', [
	'title' => 'Daftar Mahasiswa'
]); ?>

<link rel="stylesheet" href="<?= base_url('plugins') ?>/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('plugins') ?>/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('plugins') ?>/datatables-buttons/css/buttons.bootstrap4.min.css">

<body class="sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
	<div class="wrapper">

		<!-- SIDEBAR -->
		<?php $this->load->view('template/sidebar', [
			'menu_name' => 'daftar_mahasiswa'
		]) ?>


		<!-- CONTENT -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0">Daftar Mahasiswa</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Dashboard</a></li>
								<li class="breadcrumb-item active">Mahasiswa</li>
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
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<div class="card-tools">
										<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-import" style="background-color: #1578C6">
											<i class="fas fa-plus pr-1"></i>
											Import Data Mahasiswa
										</button>
									</div>
								</div>
								<!-- /.card-header -->
								<div class="card-body">
									<table class="table table-hover table-striped" id="tabel-mahasiswa" data-order='[[ 0, "asc" ]]' data-page-length='10'>
										<thead>
											<tr>
												<th>No</th>
												<th>Nama
												<th>NIM</th>
												<th>Status TA</th>
												<th>Judul TA</th>
												<th>Dosen Pembimbing</th>
												<th>Persentase Progres</th>
												<!-- <th class="col-2">Aksi</th> -->
											</tr>
										</thead>
										<tbody>
											<?php $no = 1;
											foreach ($mahasiswas as $mahasiswa) { ?>
												<tr>
													<td><?= $no++ ?></td>
													<td>
														<a href="<?= base_url('mahasiswa/' . $mahasiswa->nim) ?>">
															<?= $mahasiswa->user->name ?>
														</a>
													</td>
													<td>
														<?php if ($mahasiswa->nim) : ?>
															<?= $mahasiswa->nim ?>
														<?php else : ?>
															<small><strong>Belum ditentukan</strong></small>
														<?php endif ?>
													</td>
													<td style="max-width: 1rem;">
														<?php if (isset($mahasiswa->status)) : ?>
															<small class="badge text-wrap text-left">
																<?= $mahasiswa->status ?>
															</small>
														<?php else : ?>
															<small><strong>Belum ditentukan</strong></small>
														<?php endif; ?>
													</td>
													<td>
														<?php if ($mahasiswa->judul_ta) : ?>
															<?= $mahasiswa->judul_ta ?>
														<?php else : ?>
															<small><strong>Belum ditentukan</strong></small>
														<?php endif ?>
													</td>
													<td>
														<span>
															<?php if ($mahasiswa->dosbing_1) : ?>
															<small class="badge badge-info text-wrap text-left">
																<?= $mahasiswa->dosbing_1->user->name ?>
															</small>
															<?php else : ?>
																<small><strong>Belum ditentukan</strong></small>
															<?php endif ?>
														</span>
														<br>
														<span>
															<?php if ($mahasiswa->dosbing_2) : ?>
															<small class="badge badge-info text-wrap text-left">
																<?= $mahasiswa->dosbing_2->user->name ?>
															</small>
															<?php else : ?>
																<small><strong>Belum ditentukan</strong></small>
															<?php endif ?>
														</span>
													</td>
													<td>
														<?php if (isset($mahasiswa->progres)) { ?>
															<div class="progress-group">
																<?= $this->progres_model->calculate_percentage_progres_id($mahasiswa->progres->id) ?> %
																<div class="progress progress-sm">
																	<div class="progress-bar bg-primary" style="width: <?= $this->progres_model->calculate_percentage_progres_id($mahasiswa->progres->id) ?>%"></div>
																</div>
															</div>
															<div class="badge   p-2">
																<?= $this->progres_model->generate_status_report_progres_id($mahasiswa->progres->id) ?>
															</div>
														<?php } ?>
													</td>
													<!-- <td>
														<i class="fas fa-check text-success font-weight-bold"></i>
													</td> -->
												</tr>

											<?php } ?>
										</tbody>
									</table>
								</div>
								<!-- /.card-body -->
								<div class="card-footer">
								</div>
							</div>
						</div>
					</div>

				</div><!-- /.container-fluid -->
			</section>
			<!-- /.content -->
		</div>

		<div class="modal fade" id="modal-import">
			<div class="modal-dialog">
				<div class="modal-content  ">
					<div class="modal-header">
						<h4 class="modal-title">Import Data Mahasiswa</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">

						<div class="row mb-2">
							<div class="col">
								<a class="btn col btn-info" href="<?= base_url('mahasiswa/import/format') ?>">
									<i class="fas fa-download"></i>
									Download template file
								</a>
							</div>
						</div>
						<div id="actions" class="row mb-2">
							<div class="col-12">
								<div class="btn-group w-100">
									<span class="btn btn-success fileinput-button">
										<i class="fas fa-plus"></i>
										<span>Pilih file</span>
									</span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="table table-striped files" id="previews">
									<div id="template" class="row mt-2 bg-secondary p-2 rounded">
										<div class="col-auto mb-1">
											<span class="preview"><img src="data:," alt="" data-dz-thumbnail /></span>
										</div>
										<div class="col d-flex flex-column align-items-center mb-1 ">
											<p class="mb-0">
												<span class="lead" data-dz-name></span>
												(<span data-dz-size></span>)
											</p>
											<strong class="error text-danger result-error" data-dz-errormessage></strong>
										</div>
										<div class="col-12 d-flex align-items-center mb-2 ">
											<div class="progress progress-striped active w-100 rounded" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
												<div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
											</div>
										</div>
										<div class="col-auto d-flex align-items-center mb-1 ">
											<div class="btn-group">
												<button class="btn btn-primary start">
													<i class="fas fa-upload"></i>
													<span>Start</span>
												</button>
												<button data-dz-remove class="btn btn-warning cancel">
													<i class="fas fa-times-circle"></i>
													<span>Cancel</span>
												</button>
												<button data-dz-remove class="btn btn-danger delete">
													<i class="fas fa-trash"></i>
													<span>Delete</span>
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12 spinner-loading">
								<div class="d-flex flex-row justify-content-center align-items-center ">
									<div class="spinner-border" role="status">
										<span class="sr-only">Loading...</span>
									</div>
									<span class="ml-2">Memproses file...</span>
								</div>
							</div>
							<div class="col result-info">
							</div>
						</div>
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->

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

	<script src="<?= base_url('plugins') ?>/dropzone/min/dropzone.min.js"></script>
	<script src="<?= base_url('plugins') ?>/datatables/jquery.dataTables.min.js"></script>
	<script src="<?= base_url('plugins') ?>/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?= base_url('plugins') ?>/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="<?= base_url('plugins') ?>/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<script src="<?= base_url('plugins') ?>/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script src="<?= base_url('plugins') ?>/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
	<script src="<?= base_url('plugins') ?>/jszip/jszip.min.js"></script>
	<script src="<?= base_url('plugins') ?>/pdfmake/pdfmake.min.js"></script>
	<script src="<?= base_url('plugins') ?>/pdfmake/vfs_fonts.js"></script>
	<script src="<?= base_url('plugins') ?>/datatables-buttons/js/buttons.html5.min.js"></script>
	<script src="<?= base_url('plugins') ?>/datatables-buttons/js/buttons.print.min.js"></script>
	<script src="<?= base_url('plugins') ?>/datatables-buttons/js/buttons.colVis.min.js"></script>
	<script>
		// DropzoneJS Demo Code Start
		Dropzone.autoDiscover = false

		// Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
		var previewNode = document.querySelector("#template")
		previewNode.id = ""
		var previewTemplate = previewNode.parentNode.innerHTML
		previewNode.parentNode.removeChild(previewNode)

		var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
			url: "<?= base_url('/mahasiswa/import') ?>", // Set the url
			paramName: "file_mahasiswa",
			thumbnailWidth: 80,
			thumbnailHeight: 80,
			parallelUploads: 20,
			previewTemplate: previewTemplate,
			autoQueue: false, // Make sure the files aren't queued until manually added
			previewsContainer: "#previews", // Define the container to display the previews
			clickable: ".fileinput-button", // Define the element that should be used as click trigger to select files.
			success: (file, response) => {
				console.log(file);
				console.log(response);
				var response = JSON.parse(response);

				var info = "<p>";
				info += "<h5>" + response.message + "</h5>";
				if (response.data.length == 0) {
					info += "Tidak ada data dosen";
				} else {
					info += "<ul>";
					response.data.forEach(data => {
						info += "<li>";
						info += data.name;
						info += " | ";
						info += data.message;
						info += "</li>";
					});
					info += "</ul>";
				}
				info += "</p>";

				$('.spinner-loading').fadeOut(500, () => {
					$('.result-info').html(info);
				});
			},
			error: (error, message) => {
				$('.result-error').html(message);
				$('.spinner-loading').fadeOut();

			},
			maxFilesize: 5, // 2 MB
			acceptedFiles: ".xlsx,.csv", // Allowed extensions

		})

		myDropzone.on("addedfile", function(file) {
			// Hookup the start button
			file.previewElement.querySelector(".start").onclick = function() {
				$('.spinner-loading').fadeIn();
				myDropzone.enqueueFile(file);
			}
		})
		myDropzone.on("removedfile", function(file) {
			// Hookup the start button 
			$('.result-info').html('');
		})


		$(function() {
			$('.spinner-loading').hide();
			$("#tabel-mahasiswa").DataTable({
				"responsive": true,
				"lengthChange": true,
				"autoWidth": true,
				"buttons": ["colvis", "pageLength"]
			}).buttons().container().appendTo('#tabel-mahasiswa_wrapper .col-md-6:eq(0)');
		});
	</script>
</body>
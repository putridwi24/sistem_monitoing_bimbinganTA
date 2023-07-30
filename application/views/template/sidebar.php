<?php
if (!isset($menu_name)) $menu_name = '';
if (!isset($user)) $user = $this->auth_model->get_current_user_session();
if (!isset($role)) $role = $this->role_model->get_role_id($user->role)->name;
?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
	<!-- Left navbar links -->
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		</li>
		<li class="nav-item d-none d-sm-inline-block">
			<a href="#" class="nav-link" style="color: black">
				<h5>Sistem Monitoring Bimbingan Tugas Akhir</h5>
			</a>
		</li>
	</ul>

	<!-- Right navbar links -->
	<ul class="navbar-nav ml-auto">
		<!-- Notifications Dropdown Menu -->
		<li class="nav-item dropdown">
			<?php
			$pengumuman_generals = $this->pengumuman_model->get_published_general_unread_user_id($this->auth_model->get_current_user_session()->id);
			$pengumuman_personals = $this->pengumuman_model->get_personal_unread_user_id($this->auth_model->get_current_user_session()->id);

			$pengumuman_bimbingans = [];
			$pengumuman_kartu_kendali = [];
			foreach ($pengumuman_personals as $pengumuman) {
				switch ($pengumuman->category) {
					case 'bimbingan':
						if (count($pengumuman_bimbingans) < 5) {
							array_push($pengumuman_bimbingans, $pengumuman);
						}
						break;
					case 'kartu_kendali':
						if (count($pengumuman_kartu_kendali) < 5) {
							array_push($pengumuman_kartu_kendali, $pengumuman);
						}
						break;
					default:
						break;
				}
			}
			?>
			<a class="nav-link" data-toggle="dropdown" href="#">
				<i class="far fa-bell"></i>
				<?php if (count($pengumuman_bimbingans) || count($pengumuman_kartu_kendali)) { ?>
					<span class="badge badge-danger navbar-badge">
						<?= count($pengumuman_bimbingans) + count($pengumuman_kartu_kendali) ?>
					</span>
				<?php } ?>
			</a>
			<div class="dropdown-menu dropdown-menu-xl dropdown-menu-right overflow-hidden">
				<span class="dropdown-item dropdown-header">
					<i class="fas fa-users mr-2"></i>
					<?= count($pengumuman_bimbingans) ?>
					Notifikasi Bimbingan
				</span>
				<?php foreach ($pengumuman_bimbingans as $pengumuman) { ?>
					<?php if (!$this->pengumuman_model->check_is_read($pengumuman, $this->auth_model->get_current_user_session()->id)) { ?>
						<a href="<?= base_url('pengumuman/' . $pengumuman->id) ?>" class="dropdown-item">
							<!-- <i class="fas fa-envelope mr-2"></i> -->
							<?= $pengumuman->title ?>
							<span class="badge">
								<i class="fas fa-clock"></i> <?= $this->pengumuman_model->get_time_interval($pengumuman->release_at) ?>
							</span>
						</a>
					<?php } ?>
				<?php } ?>
				<div class="dropdown-divider"></div><span class="dropdown-item dropdown-header">
					<i class="fas fa-users mr-2"></i>
					<?= count($pengumuman_kartu_kendali) ?>
					Notifikasi Kartu Kendali
				</span>
				<?php foreach ($pengumuman_kartu_kendali as $pengumuman) { ?>
					<?php if (!$this->pengumuman_model->check_is_read($pengumuman, $this->auth_model->get_current_user_session()->id)) { ?>
						<a href="<?= base_url('pengumuman/' . $pengumuman->id) ?>" class="dropdown-item">
							<!-- <i class="fas fa-envelope mr-2"></i> -->
							<?= $pengumuman->title ?>
							<span class="badge">
								<i class="fas fa-clock"></i> <?= $this->pengumuman_model->get_time_interval($pengumuman->release_at) ?>
							</span>
						</a>
					<?php } ?>
				<?php } ?>
				<div class="dropdown-divider"></div>
				<a href="<?= base_url('pengumuman/all') ?>" class="dropdown-item dropdown-footer">Semua Notifikasi</a>
			</div>
		</li>
	</ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #07263D">
	<!-- Sidebar -->
	<div class="sidebar">
		<div class="user-panel mt-3 pb-3 mb-3  d-flex flex-column text-center">
			<div class="image">
				<img src="<?= base_url(AVATAR_URL . $user->avatar)  ?>" class="img-circle " alt="User Image" style="height: 150px;width: 150px; object-fit: cover;">
			</div>

			<!-- TODO OVEFRLOW TEXT -->
			<div class="info mt-2">
				<a href="#" class="h4">
					<?= $user->name ?>
				</a>
			</div>
		</div>

		<!-- Sidebar Menu -->

		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

				<?php if ($role == 'mahasiswa') {
				?>
					<li class="nav-item">
						<a href="<?= base_url('beranda/mahasiswa') ?>" class="nav-link 
					   <?= $menu_name == 'beranda_mahasiswa' ? 'active' : '' ?> ">
							<i class="fas fa-house-user nav-icon"></i>
							<p>Beranda</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= base_url('bimbingan') ?>" class="nav-link 
					<?= $menu_name == 'bimbingan' ? 'active' : '' ?>">
							<i class="fas fa-user-friends nav-icon"></i>
							<p>Bimbingan</p>
						</a>
					</li>
					</li>
					<li class="nav-item">
						<a href="<?= base_url('kartu_kendali') ?>" class="nav-link 
					<?= $menu_name == 'kartu_kendali' ? 'active' : '' ?>">
							<i class="far fa-list-alt nav-icon"></i>
							<p>Kartu Kendali</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= base_url('timeline') ?>" class="nav-link 
					<?= $menu_name == 'timeline_laporan' ? 'active' : '' ?>">
							<i class="fa fa-poll nav-icon"></i>
							<p>Timeline Laporan</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= base_url('dokumen') ?>" class="nav-link 
						<?= $menu_name === 'dokumen' ? 'active' : '' ?>">
							<i class="fa fa-file nav-icon"></i>
							<p>Dokumen Pendukung</p>
						</a>
					</li>
				<?php
				} ?>

				<!-- DOSEN -->
				<?php if ($role == 'dosen' || $role == 'tim_ta') {
				?>
					<li class="nav-header">Dosen</li>
					<li class="nav-item">
						<a href="<?= base_url('beranda/dosen') ?>" class="nav-link 
						<?= $menu_name == 'beranda_dosen' ? 'active' : '' ?> ">
							<i class="fas fa-house-user nav-icon"></i>
							<p>Beranda</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= base_url('permohonan') ?>" class="nav-link 
					<?= $menu_name == 'permohonan_bimbingan' ? 'active' : '' ?>">
							<i class="fas fa-user-clock nav-icon"></i>
							<p>Permohonan Bimbingan</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= base_url('bimbingan') ?>" class="nav-link 
					<?= $menu_name == 'bimbingan' ? 'active' : '' ?>">
							<i class="fas fa-user-friends nav-icon"></i>
							<p>Bimbingan</p>
						</a>
					</li>
					</li>
					<li class="nav-item">
						<a href="<?= base_url('timeline') ?>" class="nav-link 
					<?= $menu_name == 'timeline_laporan' ? 'active' : '' ?>">
							<i class="fa fa-poll nav-icon"></i>
							<p>Timeline Laporan</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= base_url('kartu_kendali') ?>" class="nav-link 
					<?= $menu_name == 'kartu_kendali' ? 'active' : '' ?>">
							<i class="far fa-list-alt nav-icon"></i>
							<p>Kartu Kendali</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= base_url('mahasiswa') ?>" class="nav-link
					<?= $menu_name == 'my_mahasiswa' ? 'active' : '' ?>">
							<i class="fas fa-users nav-icon"></i>
							<p>Mahasiswa Saya</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= base_url('dokumen') ?>" class="nav-link 
						<?= $menu_name === 'dokumen' ? 'active' : '' ?>">
							<i class="fa fa-file nav-icon"></i>
							<p>Dokumen Pendukung</p>
						</a>
					</li>
				<?php
				} ?>

				<?php if ($role === 'tim_ta') { ?>
					<li class="nav-header">Tim TA</li>
					<li class="nav-item">
						<a href="<?= base_url('dashboard') ?>" class="nav-link 
					<?= $menu_name == 'dashboard' ? 'active' : '' ?> ">
							<i class="fas fa-tachometer-alt nav-icon"></i>
							<p>Dashboard</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= base_url('dosen') ?>" class="nav-link 
					<?= $menu_name == 'daftar_dosen' ? 'active' : '' ?>">
							<i class="fas fa-user-tie nav-icon"></i>
							<p>Daftar Dosen</p>
						</a>
					</li>
					</li>
					<li class="nav-item">
						<a href="<?= base_url('mahasiswa/all') ?>" class="nav-link 
					<?= $menu_name == 'daftar_mahasiswa' ? 'active' : '' ?>">
							<i class="fas fa-user-graduate nav-icon"></i>
							<p>Daftar Mahasiswa</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= base_url('pengumuman') ?>" class="nav-link 
					<?= $menu_name == 'pengaturan_pengumuman' ? 'active' : '' ?>">
							<i class="fas fa-bullhorn nav-icon"></i>
							<p>Pengumuman</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= base_url('dokumen/all') ?>" class="nav-link 
						<?= $menu_name === 'dokumen_tim' ? 'active' : '' ?>">
							<i class="fa fa-file nav-icon"></i>
							<p>Dokumen Pendukung</p>
						</a>
					</li>
				<?php } ?>

				<li class="nav-header">Aplikasi</li>
				<!-- <li class="nav-item">
					<a href="<?= base_url('pengumuman/all') ?>" class="nav-link 
					<?= $menu_name == 'pengumuman_all' ? 'active' : '' ?>">
						<i class="fa fa-poll nav-icon"></i>
						<p>Pengumuman</p>
					</a>
				</li> -->
				<li class="nav-item">
					<a href="/profile" class="nav-link 
					<?= $menu_name == 'profile' ? 'active' : '' ?>">
						<i class="fas fa-user-circle nav-icon"></i>
						<p>Profile</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="/logout" class="nav-link">
						<i class="fas fa-sign-out-alt nav-icon"></i>
						<p>Keluar</p>
					</a>
				</li>
			</ul>
		</nav>

		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>

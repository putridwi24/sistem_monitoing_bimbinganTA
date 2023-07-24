<!-- jQuery -->
<script src="<?php echo base_url('public/plugins') ?>/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url('public/plugins') ?>/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
	$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url('public/plugins') ?>/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url('public/plugins') ?>/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url('public/plugins') ?>/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?php echo base_url('public/plugins') ?>/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo base_url('public/plugins') ?>/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url('public/plugins') ?>/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url('public/plugins') ?>/moment/moment.min.js"></script>
<script src="<?php echo base_url('public/plugins') ?>/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url('public/plugins') ?>/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url('public/plugins') ?>/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url('public/plugins') ?>/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('public/dist') ?>/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->


<script>
	$(document).ready(function() {
		setTimeout(() => {
			$('.alert').slideUp(1000, () => {
				$('.alert').hide();
			});
		}, 2000);
	});

	// $('body').addClass('dark-mode');
	// $('body').removeClass('sidebar-collapse')
</script>

</html>

<?php if ($this->session->flashdata('message_error')) : ?>
	<div class="alert alert-danger" role="alert">
		<?= $this->session->flashdata('message_error') ?>
	</div>
<?php endif ?>
<?php if ($this->session->flashdata('message_success')) : ?>
	<div class="alert alert-success" role="alert">
		<?= $this->session->flashdata('message_success') ?>
	</div>
<?php endif ?>
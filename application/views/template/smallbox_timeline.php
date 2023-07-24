<?php
$stage = $this->progres_model->get_stage_code_name($stage);
$status = $this->progres_model->get_status_id($status);
?>
<div class="small-box mr-2 p-2 d-flex flex-column justify-content-between
<?= $this->progres_model->get_display_color_class_status_id($status->id) ?>
	">
	<div class="inner text-center">
		<span class="h5"><?= $stage->name ?></span>
	</div>
	<span href="#" class="small-box-footer p-1">
		<?= $status->name ?>
	</span>
</div>

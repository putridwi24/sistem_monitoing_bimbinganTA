	<?php
	$stage = $this->progres_model->get_stage_code_name($stage);
	$status = $this->progres_model->get_status_id($status);
	?>

	<div class="
	small-box btn btn-bg m-1 p-2 
	d-flex flex-column justify-content-between btn-step-box
	<?= $this->progres_model->get_display_color_class_status_id($status->id) ?>
	" stageName="<?= $stage->name ?>" stageId="<?= $stage->id ?>" data-toggle="modal" data-target="#modal-update-progres" onclick="updateProgres(this)">
		<div class="inner text-center">
			<span class="h5"><?= $stage->name ?></span>
		</div>
		<span href="#" class="small-box-footer align-self-stretch p-1">
			<?= $status->name ?>
		</span>
	</div>

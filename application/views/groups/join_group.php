<?php echo form_open('', array('role'=>'form', 'class' => 'form-horizontal')); ?>

<?php echo (validation_errors()) ? '<div class="alert alert-danger">' . validation_errors() . '</div>' : ''; ?>

<div class="row">
	<div class="col-md-12">
		<?php echo form_fieldset('Join a Group'); ?>
		<div class="form-group">
			<?php echo form_label('Invitation Code', 'invitation_code', array('class'=>'col-lg-3 control-label')); ?>
			<div class="col-lg-9">
				<?php echo form_input(array('name'=>'invitation_code', 'class'=>'form-control', 'value'=>$this->input->get_post('invitation_code'))); ?>
			</div>
		</div>
		<?php echo form_fieldset_close(); ?>
	</div>
</div>

<div class="row">
	<div style="text-align:right;">
		<?php echo form_submit(array('value'=>'Join the Group', 'class'=>'btn btn-primary')); ?>
	</div>
</div>

<?php echo form_close(); ?>
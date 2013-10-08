
<?php echo form_open('', array('role'=>'form', 'class' => 'form-horizontal')); ?>

<?php echo (validation_errors()) ? '<div class="alert alert-danger">' . validation_errors() . '</div>' : ''; ?>

<?php echo form_fieldset('Join a Group'); ?>
<p class="lead">To join a group, please enter the invitation code provided to you from the group administrator. It may have been included in an email.</p>
<div class="form-group">
	<?php echo form_label('Invitation Code', 'invitation_code', array('class'=>'col-md-3 control-label')); ?>
	<div class="col-md-9">
		<?php echo form_input(array('name'=>'invitation_code', 'class'=>'form-control', 'placeholder'=>'ABCDEFG123', 'value'=>$this->input->get_post('invitation_code'))); ?>
	</div>
</div>
<?php echo form_fieldset_close(); ?>

<div style="text-align:right;">
	<?php echo form_submit(array('value'=>'Join the Group', 'class'=>'btn btn-primary')); ?>
</div>

<?php echo form_close(); ?>
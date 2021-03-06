<?php echo form_open('', array('role'=>'form', 'class' => 'form-horizontal')); ?>

<?php echo (validation_errors()) ? '<div class="alert alert-danger">' . validation_errors() . '</div>' : ''; ?>

<div class="row">
	<div class="col-md-12">
		<?php echo form_fieldset('Invite members'); ?>
		<div class="form-group">
			<?php echo form_label('Email Address', 'email', array('class'=>'col-md-3 control-label')); ?>
			<div class="col-md-9">
				<?php echo form_input(array('name'=>'email', 'class'=>'form-control', 'placeholder'=>'someone@example.com', 'autocapitalize'=>'off', 'autocorrect'=>'off', 'value'=>$this->input->post('email'))); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo form_label('Message', 'message', array('class'=>'col-md-3 control-label')); ?>
			<div class="col-md-9">
				<?php echo form_textarea(array('name'=>'message', 'class'=>'form-control', 'placeholder'=>'Write a personal message so they know it\'s you. (optional)', 'value'=>$this->input->post('message'))); ?>
			</div>
		</div>
		<?php echo form_fieldset_close(); ?>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<p class="text-right">
			<?php echo form_submit(array('value'=>'Send Invite', 'class'=>'btn btn-primary')); ?>
		</p>
	</div>
</div>

<?php echo form_close(); ?>
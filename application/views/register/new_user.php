<?php echo form_open('', array('role'=>'form', 'class' => 'form-horizontal')); ?>

<?php echo (validation_errors()) ? '<div class="alert alert-danger">' . validation_errors() . '</div>' : ''; ?>

<div class="row">
	<div class="col-md-12">
		<?php echo form_fieldset('Your details'); ?>
		<div class="form-group">
			<?php echo form_label('First Name', 'first_name', array('class'=>'col-lg-3 control-label')); ?>
			<div class="col-lg-9">
				<?php echo form_input(array('name'=>'first_name', 'class'=>'form-control', 'value'=>$this->input->post('first_name'))); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo form_label('Last Name', 'last_name', array('class'=>'col-lg-3 control-label')); ?>
			<div class="col-lg-9">
				<?php echo form_input(array('name'=>'last_name', 'class'=>'form-control', 'value'=>$this->input->post('last_name'))); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo form_label('Email', 'email', array('class'=>'col-lg-3 control-label')); ?>
			<div class="col-lg-9">
				<?php echo form_input(array('name'=>'email', 'class'=>'form-control', 'value'=>$this->input->post('email'))); ?>
			</div>
		</div>
		<hr />
		<div class="form-group">
			<?php echo form_label('Username', 'username', array('class'=>'col-lg-3 control-label')); ?>
			<div class="col-lg-9">
				<?php echo form_input(array('name'=>'username', 'class'=>'form-control', 'value'=>$this->input->post('username'))); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo form_label('Password', 'password', array('class'=>'col-lg-3 control-label')); ?>
			<div class="col-lg-9">
				<?php echo form_password(array('name'=>'password', 'class'=>'form-control')); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo form_label('Confirm Password', 'password_confirm', array('class'=>'col-lg-3 control-label')); ?>
			<div class="col-lg-9">
				<?php echo form_password(array('name'=>'password_confirm', 'class'=>'form-control')); ?>
			</div>
		</div>
		<?php echo form_fieldset_close(); ?>
	</div>
</div>

<div class="row">
	<div style="text-align:right;">
		<?php echo form_hidden(array('invitation_code' => $this->input->get('invitation_code'))); ?>
		<?php echo form_submit(array('value'=>'Create Account', 'class'=>'btn btn-primary')); ?>
	</div>
</div>

<?php echo form_close(); ?>
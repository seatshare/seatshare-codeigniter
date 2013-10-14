<?php echo form_open('', array('role'=>'form', 'class' => 'form-horizontal')); ?>

<?php echo (validation_errors()) ? '<div class="alert alert-danger">' . validation_errors() . '</div>' : ''; ?>

<div class="row">
	<div class="col-md-12">
		<?php echo form_fieldset('Your details'); ?>
		<div class="form-group">
			<?php echo form_label('First Name', 'first_name', array('class'=>'col-md-3 control-label')); ?>
			<div class="col-md-9">
				<?php echo form_input(array('name'=>'first_name', 'class'=>'form-control', 'placeholder'=>'John', 'value'=>$this->input->post('first_name'))); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo form_label('Last Name', 'last_name', array('class'=>'col-md-3 control-label')); ?>
			<div class="col-md-9">
				<?php echo form_input(array('name'=>'last_name', 'class'=>'form-control', 'placeholder'=>'Doe', 'value'=>$this->input->post('last_name'))); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo form_label('Email', 'email', array('class'=>'col-md-3 control-label')); ?>
			<div class="col-md-9">
				<?php echo form_input(array('name'=>'email', 'class'=>'form-control', 'placeholder'=>'someone@example.com', 'value'=>$this->input->post('email'))); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo form_label('Newsletter Signup', 'newsletter', array('class'=>'col-md-3 control-label')); ?>
			<div class="col-md-9">
				<div class="checkbox">
					<label><?php echo form_checkbox(array('name'=>'newsletter', 'class'=>'', 'value'=>'features', 'checked'=>true)); ?> Ocassional new feature announcements for <?php echo $this->config->item('application_name'); ?>.<label>
				</div>
			</div>
		</div>
		<hr />
		<div class="form-group">
			<?php echo form_label('Username', 'username', array('class'=>'col-md-3 control-label')); ?>
			<div class="col-md-9">
				<?php echo form_input(array('name'=>'username', 'class'=>'form-control', 'placeholder'=>'johndoe', 'value'=>$this->input->post('username'))); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo form_label('Password', 'password', array('class'=>'col-md-3 control-label')); ?>
			<div class="col-md-9">
				<?php echo form_password(array('name'=>'password', 'class'=>'form-control')); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo form_label('Confirm Password', 'password_confirm', array('class'=>'col-md-3 control-label')); ?>
			<div class="col-md-9">
				<?php echo form_password(array('name'=>'password_confirm', 'class'=>'form-control')); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo form_label('', 'tos', array('class'=>'col-md-3 control-label')); ?>
			<div class="col-md-9">
				<div class="checkbox">
					<label><?php echo form_checkbox(array('name'=>'tos', 'class'=>'', 'value'=>'features', 'checked'=>false)); ?> I agree to the <a href="<?php echo site_url('tos'); ?>">terms of service</a>.<label>
				</div>
			</div>
		</div>
		<?php echo form_fieldset_close(); ?>
	</div>
</div>

<div style="display:none;">
	This field is left blank on purpose. :)
	<input type="text" name="url" value="" />
</div>

<div class="row">
	<div class="col-md-12">
		<p class="text-right">
			<?php echo form_hidden(array('invitation_code' => $invitation_code)); ?>
			<?php echo form_submit(array('value'=>'Create Account', 'class'=>'btn btn-primary')); ?>
		</p>
	</div>
</div>

<?php echo form_close(); ?>
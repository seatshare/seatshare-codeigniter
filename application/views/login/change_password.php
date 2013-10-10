<?php echo form_open('', array('class'=>'form-signin')); ?>

	<?php echo form_password(array('name'=>'password', 'class'=>'form-control', 'placeholder'=>'New password')); ?>
	<?php echo form_password(array('name'=>'password_confirm', 'class'=>'form-control', 'placeholder'=>'Confirm password')); ?>
	<button class="btn btn-lg btn-primary btn-block" type="submit">Change Password</button>

<?php form_close(); ?>
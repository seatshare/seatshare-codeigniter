<?php echo form_open('login', array('class'=>'form-signin')); ?>

	<?php echo form_input(array('name'=>'username', 'class'=>'form-control', 'placeholder'=>'Username or email address', 'autofocus'=>'autofocus', 'autocapitalize'=>'off', 'autocorrect'=>'off')); ?>
	<?php echo form_password(array('name'=>'password', 'class'=>'form-control', 'placeholder'=>'Password')); ?>
	<button class="btn btn-lg btn-primary btn-block" type="submit">Sign In</button>

<?php form_close(); ?>

<div class="help-block">
	<p class="text-center">
		<a href="<?php echo site_url('login/forgot_password'); ?>">I forgot my password</a>
	</p>
</div>
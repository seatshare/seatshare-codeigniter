<?php echo form_open('login', array('class'=>'form-signin')); ?>

	<?php echo form_input(array('name'=>'username', 'class'=>'form-control', 'placeholder'=>'Username', 'autofocus'=>'autofocus')); ?>
	<?php echo form_password(array('name'=>'password', 'class'=>'form-control', 'placeholder'=>'Password')); ?>
	<label class="checkbox">
      <input type="checkbox" value="remember-me"> Remember me
    </label>
	<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
<?php form_close(); ?>
<?php echo form_open('', array('class'=>'form-signin')); ?>

	<?php echo form_input(array('name'=>'email', 'class'=>'form-control', 'placeholder'=>'Email address', 'autofocus'=>'autofocus')); ?>
	<button class="btn btn-lg btn-primary btn-block" type="submit">Retrieve Password</button>

<?php form_close(); ?>
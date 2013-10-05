<?php echo form_open('', array('role'=>'form', 'class' => 'form-horizontal')); ?>

<?php echo (validation_errors()) ? '<div class="alert alert-danger">' . validation_errors() . '</div>' : ''; ?>

<div class="alert alert-danger alert-block">
	<h3>Are you sure you want to leave "<strong><?php echo $group->group; ?></strong>?"</h3>
	<ul class="list">
		<li>Your created tickets will be deleted</li>
		<li>Your assigned tickets will show "Unassigned"</li>
		<li>You will have to be invited again to join the group</li>
	</ul>
	<p class="text-right">
		<?php echo form_hidden(array('confirmed' => 1)); ?>
		<?php echo form_submit(array('value'=>'Leave the Group', 'class'=>'btn btn-danger')); ?>
	</p>
</div>

<?php echo form_close(); ?>
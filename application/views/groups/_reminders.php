<?php echo form_open('', array('role'=>'form', 'class' => 'form-horizontal')); ?>

<?php echo form_fieldset('Reminders'); ?>

<div class="form-group">
	<div class="col-md-12">
		<?php echo form_label('Set Preferences', 'reminders', array('class'=>'control-label')); ?>
		<?php foreach ($reminders as $reminder): ?>
		<div class="checkbox">
			<label><?php echo form_checkbox(array('name'=>'reminders[]', 'class'=>'', 'value'=>$reminder->reminder_type_id, 'checked'=>in_array($reminder->reminder_type_id, $subscribed))); ?> <?php echo $reminder->description; ?></label>
		</div>
		<?php endforeach; ?>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<p class="text-right">
			<?php echo form_submit(array('value'=>'Update Preferences', 'class'=>'btn btn-primary')); ?>
		</p>
	</div>
</div>

<?php echo form_close(); ?>
<?php echo form_open('', array('role'=>'form', 'class' => 'form-horizontal')); ?>

<?php echo (validation_errors()) ? '<div class="alert alert-danger">' . validation_errors() . '</div>' : ''; ?>

<?php echo form_fieldset('Group message'); ?>
<div class="form-group">
	<?php echo form_label('Subject', 'subject', array('class'=>'col-md-3 control-label')); ?>
	<div class="col-md-9">
		<?php echo form_input(array('name'=>'subject', 'class'=>'form-control', 'placeholder'=>'Email subject line', 'value'=>$this->input->post('subject'))); ?>
	</div>
</div>
<div class="form-group">
	<?php echo form_label('Message', 'message', array('class'=>'col-md-3 control-label')); ?>
	<div class="col-md-9">
		<?php echo form_textarea(array('name'=>'message', 'class'=>'form-control', 'placeholder'=>'The message to be sent to the selected group members.', 'value'=>$this->input->post('message'))); ?>
	</div>
</div>
<?php echo form_fieldset_close(); ?>

<div class="row">
	<div class="col-md-12">
	<?php echo form_fieldset('Recipients'); ?>
		<div class="form-group">
		<?php echo form_label('Select Recipients', 'recipients', array('class'=>'col-md-3 control-label')); ?>
		<div class="col-md-9">
				<?php foreach ($group_users as $user): ?>
				<div class="checkbox">
					<label>
						<?php echo form_checkbox(array(
							'name' => sprintf('recipients[%d]', $user->user_id),
							'value' => $user->user_id,
							'id' => sprintf('user_%d', $user->user_id),
							'checked' => true
						)); ?>
						<?php echo gravatar($user->email); ?>
						<?php echo $user->first_name; ?> <?php echo $user->last_name; ?>
					</label>
				</div>
				<?php endforeach; ?>
		</div>
	<?php echo form_fieldset_close(); ?>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<p style="text-align:right;">
			<?php echo form_submit(array('value'=>'Send Message', 'class'=>'btn btn-primary')); ?>
		</p>
	</div>
</div>
<?php echo form_close(); ?>
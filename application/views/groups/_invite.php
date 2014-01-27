<?php echo form_open('groups/invite', array('role'=>'form', 'class' => 'form-inline')); ?>

<div class="row">
	<div class="col-md-12">
		<?php echo form_fieldset('Invite members'); ?>
		<p class="text-muted">Invite your friends to join this group. If you need a link to share in a personal email, visit the <a href="<?php echo site_url('groups/group/' . $this->current_group->group_id); ?>">group page</a>.</p>
		<div class="form-group">
			<?php echo form_label('Email Address', 'email', array('class'=>'sr-only')); ?>
			<?php echo form_input(array('name'=>'email', 'id'=>'email', 'class'=>'form-control', 'style'=>'width:240px;', 'placeholder'=>'someone@example.com', 'autocapitalize'=>'off', 'autocorrect'=>'off', 'value'=>$this->input->post('email'))); ?>
		</div>
		<?php echo form_submit(array('value'=>'Send Invite', 'class'=>'btn btn-primary')); ?>
		<p>
			<a href="javascript:void();" data-toggle="collapse" data-target="#personal_message">Include a personal message</a>
		</p>
		<div class="collapse" id="personal_message">
			<div class="form-group">
				<?php echo form_label('Personal Message', 'message', array('class'=>'')); ?>
				<?php echo form_textarea(array('name'=>'message', 'id'=>'message', 'class'=>'form-control', 'value'=>$this->input->post('message'))); ?>
			</div>
		</div>
		<?php echo form_fieldset_close(); ?>
	</div>
</div>

<?php echo form_close(); ?>
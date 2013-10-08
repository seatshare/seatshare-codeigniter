<?php if (count($events)): ?>

<div class="well text-center">
	<ul class="list-inline" style="margin-bottom:0;">
		<li><strong>Have tickets?</strong></li>
		<li><a href="<?php echo site_url('tickets/create_season'); ?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-calendar"></span> Add Season Tickets</a></li>			
	</ul>
</div>

<?php echo form_fieldset('Calendar'); ?>
<div id="sidebar_calendar"></div>
<?php echo form_fieldset_close(); ?>

<?php endif; ?>

<?php echo form_fieldset('Group members'); ?>

<ul class="list-unstyled">
	<?php foreach ($group_users as $row): ?>
	<li><?php echo gravatar($row->email, 32); ?> <a href="<?php echo site_url('user/' . $row->username); ?>"><?php echo $row->first_name; ?> <?php echo $row->last_name; ?></a></li>
	<?php endforeach; ?>
</ul>

<?php echo form_fieldset_close(); ?>

<?php echo form_open('groups/invite', array('role'=>'form', 'class' => 'form-inline')); ?>

<div class="row">
	<div class="col-md-12">
		<?php echo form_fieldset('Invite members'); ?>
		<div class="form-group">
			<?php echo form_label('Email Address', 'email', array('class'=>'sr-only')); ?>
			<?php echo form_input(array('name'=>'email', 'class'=>'form-control', 'style'=>'width:240px;', 'placeholder'=>'someone@example.com', 'value'=>$this->input->post('email'))); ?>
		</div>
		<?php echo form_submit(array('value'=>'Send Invite', 'class'=>'btn btn-primary')); ?>
		<?php echo form_fieldset_close(); ?>
	</div>
</div>

<?php echo form_close(); ?>
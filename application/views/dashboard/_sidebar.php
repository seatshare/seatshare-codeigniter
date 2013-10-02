<ul class="list-inline">
	<li><a href="<?php echo site_url('tickets/create_season'); ?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-calendar"></span> Add Season Tickets</a></li>			
</ul>

<?php echo form_fieldset('Group members'); ?>

<ul class="list-unstyled">
	<?php foreach ($group_users as $row): ?>
	<li><img src="http://gravatar.com/avatar/<?php echo md5($row->email); ?>?s=32"> <?php echo $row->first_name; ?> <?php echo $row->last_name; ?></li>
	<?php endforeach; ?>
</ul>

<?php echo form_fieldset_close(); ?>


<?php echo form_open('groups/invite', array('role'=>'form', 'class' => 'form-horizontal')); ?>

<div class="row">
	<div class="col-md-12">
		<?php echo form_fieldset('Invite members'); ?>
		<div class="form-group">
			<?php echo form_label('Email Address', 'email', array('class'=>'col-lg-3 control-label')); ?>
			<div class="col-lg-9">
				<?php echo form_input(array('name'=>'email', 'class'=>'form-control', 'placeholder'=>'someone@example.com', 'value'=>$this->input->post('email'))); ?>
			</div>
		</div>
		<?php echo form_fieldset_close(); ?>
	</div>
</div>

<div class="row">
	<div style="text-align:right;">
		<?php echo form_submit(array('value'=>'Send Invite', 'class'=>'btn btn-primary')); ?>
	</div>
</div>

<?php echo form_close(); ?>
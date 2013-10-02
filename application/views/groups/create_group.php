<?php echo form_open('', array('role'=>'form', 'class' => 'form-horizontal')); ?>

<?php echo (validation_errors()) ? '<div class="alert alert-danger">' . validation_errors() . '</div>' : ''; ?>

<div class="row">
	<div class="col-md-12">
		<?php echo form_fieldset('Group details'); ?>

		<p class="lead">Groups of users exchange tickets among its membership. You can assign tickets to other users, or request their available tickets.</p> 

		<div class="form-group">
			<?php echo form_label('Group Name', 'group', array('class'=>'col-lg-3 control-label')); ?>
			<div class="col-lg-9">
				<?php echo form_input(array('name'=>'group', 'class'=>'form-control', 'placeholder'=>'Cellblock 303', 'value'=>$this->input->post('group'))); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo form_label('Team / Venue', 'entity_id', array('class'=>'col-lg-3 control-label')); ?>
			<div class="col-lg-9">
			<?php echo form_dropdown('entity_id', $entities, null, 'class="form-control"'); ?>
			<p class="help-block"><strong>Choose carefully!</strong> You cannot change your team / venue after the group is created.</p>
			</div>
		</div>
		<?php echo form_fieldset_close(); ?>
	</div>
</div>

<div class="row">
	<div style="text-align:right;">
		<?php echo form_submit(array('value'=>'Create Group', 'class'=>'btn btn-primary')); ?>
	</div>
</div>

<?php echo form_close(); ?>
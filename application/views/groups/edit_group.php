<?php echo form_open('', array('role'=>'form', 'class' => 'form-horizontal')); ?>

<?php echo (validation_errors()) ? '<div class="alert alert-danger">' . validation_errors() . '</div>' : ''; ?>

<div class="row">
	<div class="col-md-12">
		<?php echo form_fieldset('Group details'); ?>
		<div class="form-group">
			<?php echo form_label('Group Name', 'group', array('class'=>'col-md-3 control-label')); ?>
			<div class="col-md-9">
				<?php echo form_input(array('name'=>'group', 'class'=>'form-control', 'placeholder'=>'Cellblock 303', 'value'=>$group->group)); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo form_label('Reset Invitation Code', 'reset_invitation_code', array('class'=>'col-md-3 control-label')); ?>
			<div class="col-md-9">
				<div class="checkbox">
					<label><?php echo form_checkbox(array('name'=>'reset_invitation_code', 'class'=>'', 'value'=>'1', 'checked'=>false)); ?> <strong>Warning!</strong> Invalidates all existing invitation emails.<label>
				</div>
			</div>
		</div>
		<?php echo form_fieldset_close(); ?>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<p class="text-right">
			<?php echo form_submit(array('value'=>'Update Group', 'class'=>'btn btn-primary')); ?>
		</p>
	</div>
</div>

<?php echo form_close(); ?>
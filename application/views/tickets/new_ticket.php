<?php include '_event.php'; ?>

<?php echo form_open('', array('role'=>'form', 'class' => 'form-horizontal')); ?>

<?php echo (validation_errors()) ? '<div class="alert alert-danger">' . validation_errors() . '</div>' : ''; ?>

<div class="row">
	<div class="col-md-12">
		<?php echo form_fieldset('Ticket details'); ?>
		<div class="form-group">
			<?php echo form_label('Section', 'section', array('class'=>'col-lg-3 control-label')); ?>
			<div class="col-lg-9">
				<?php echo form_input(array('name'=>'section', 'class'=>'form-control', 'value'=>$this->input->post('section'))); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo form_label('Row', 'row', array('class'=>'col-lg-3 control-label')); ?>
			<div class="col-lg-9">
				<?php echo form_input(array('name'=>'row', 'class'=>'form-control', 'value'=>$this->input->post('row'))); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo form_label('Seat', 'seat', array('class'=>'col-lg-3 control-label')); ?>
			<div class="col-lg-9">
				<?php echo form_input(array('name'=>'seat', 'class'=>'form-control', 'value'=>$this->input->post('seat'))); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo form_label('Cost', 'cost', array('class'=>'col-lg-3 control-label')); ?>
			<div class="col-lg-9">
				<?php echo form_input(array('name'=>'cost', 'class'=>'form-control', 'value'=>$this->input->post('cost'))); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo form_label('Assigned To', 'assigned', array('class'=>'col-lg-3 control-label')); ?>
			<div class="col-lg-9">
				<?php echo form_dropdown('assigned', $group_users, ($this->input->post('assigned')) ? $this->input->post('assigned') : $assigned->user_id, 'class="form-control"'); ?>
			</div>
		</div>
		<?php echo form_fieldset_close(); ?>
	</div>

</div>

<div class="row">
	<hr />
	<div style="text-align:right;">
		<?php echo form_submit(array('value'=>'Add Ticket', 'class'=>'btn btn-primary')); ?>
	</div>
</div>

<?php echo form_close(); ?>
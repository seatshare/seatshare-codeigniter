<?php include '_event.php'; ?>

<?php if ($can_edit): ?>

<?php echo form_open('', array('role'=>'form', 'class' => 'form-horizontal')); ?>

<?php echo (validation_errors()) ? '<div class="alert alert-danger">' . validation_errors() . '</div>' : ''; ?>

	<div class="form-group">
		<?php echo form_label('Ticket Purchaser', 'owner', array('class'=>'col-md-3 control-label')); ?>
		<div class="col-md-9">
			<?php echo form_input(array('name'=>'owner', 'class'=>'form-control', 'readonly'=>true, 'value'=>$ticket->owner->name)); ?>
		</div>
	</div>
	<div class="form-group">
		<?php echo form_label('Assigned To', 'assigned', array('class'=>'col-md-3 control-label')); ?>
		<div class="col-md-9">
			<?php echo form_dropdown('assigned', $group_users, ($ticket->assigned) ? $ticket->assigned->user_id : 0, 'class="form-control"'); ?>
		</div>
	</div>
	<div class="form-group">
		<?php echo form_label('Cost', 'assigned', array('class'=>'col-md-3 control-label')); ?>
		<div class="col-md-9">
			<?php echo form_input(array('name'=>'cost', 'class'=>'form-control', 'placeholder'=>'25.00', 'value'=>number_format($ticket->cost,2))); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<p class="text-right">
				<?php echo form_submit(array('value'=>'Update Ticket', 'class'=>'btn btn-primary')); ?>
			</p>
		</div>
	</div>
<?php echo form_close(); ?>
<?php else: ?>

<?php echo form_open('tickets/request/' . $ticket->ticket_id, array('role'=>'form', 'class' => 'form-horizontal')); ?>
	<div class="form-group">
		<?php echo form_label('Ticket Holder', 'owner', array('class'=>'col-md-3 control-label')); ?>
		<div class="col-md-9">
			<?php echo form_input(array('name'=>'owner', 'class'=>'form-control', 'readonly'=>true, 'value'=>$ticket->owner->name)); ?>
		</div>
	</div>
	<div class="form-group">
		<?php echo form_label('Assigned To', 'assigned', array('class'=>'col-md-3 control-label')); ?>
		<div class="col-md-9">
			<?php echo form_input(array('name'=>'assigned', 'class'=>'form-control', 'readonly'=>true, 'value'=>($ticket->assigned) ? $ticket->assigned->name : 'Unassigned')); ?>
		</div>
	</div>
	<div class="form-group">
		<?php echo form_label('Cost', 'assigned', array('class'=>'col-md-3 control-label')); ?>
		<div class="col-md-9">
			<?php echo form_input(array('name'=>'cost', 'class'=>'form-control', 'readonly'=>true, 'value'=>number_format($ticket->cost,2))); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo form_label('Message', 'message', array('class'=>'col-md-3 control-label')); ?>
		<div class="col-md-9">
			<?php echo form_textarea(array('name'=>'message', 'class'=>'form-control', 'placeholder'=>'You can include additional notes here for this request. We will already include the ticket details.', 'value'=>'')); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<p class="text-right">
				<?php echo form_submit(array('value'=>'Request Ticket', 'class'=>'btn btn-primary')); ?>
			</p>
		</div>
	</div>
<?php echo form_close(); ?>

<?php endif; ?>
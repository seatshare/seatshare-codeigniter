<?php include '_event.php'; ?>

<?php if ($can_edit): ?>

<?php echo form_open_multipart('', array('role'=>'form', 'class' => 'form-horizontal')); ?>

<?php echo (validation_errors()) ? '<div class="alert alert-danger">' . validation_errors() . '</div>' : ''; ?>

	<div class="form-group">
		<?php echo form_label('Ticket Purchaser', 'owner', array('class'=>'col-md-3 control-label')); ?>
		<div class="col-md-9">
			<p class="form-control-static"><?php echo $ticket->owner->name; ?></p>
		</div>
	</div>
	<div class="form-group">
		<?php echo form_label('Assigned To', 'assigned', array('class'=>'col-md-3 control-label')); ?>
		<div class="col-md-9">
			<?php echo form_dropdown('assigned', $group_users, ($ticket->assigned) ? $ticket->assigned->user_id : 0, 'class="form-control" data-current="' . $current_user_id . '"'); ?>
		</div>
	</div>
	<div id="alias_control" style="<?php echo ($ticket->assigned && $ticket->assigned->user_id == $this->current_user->user_id) ? '' : 'display:none;' ?>">
		<div class="form-group">
			<?php echo form_label('Ticket alias', 'alias', array('class'=>'col-md-3 control-label')); ?>
			<div class="col-md-9">
				<?php echo form_dropdown('alias', $user_aliases, ($ticket->alias) ? $ticket->alias->alias_id : 0, 'class="form-control"'); ?>
				<span class="help-block"><a href="<?php echo site_url('profile'); ?>">Manage my user aliases</a></span>
			</div>
		</div>
	</div>
	<div class="form-group">
		<?php echo form_label('Cost', 'cost', array('class'=>'col-md-3 control-label')); ?>
		<div class="col-md-9">
			<?php echo form_input(array('name'=>'cost', 'class'=>'form-control', 'placeholder'=>'25.00', 'value'=>number_format($ticket->cost,2))); ?>
		</div>
	</div>
	<div class="form-group">
		<?php echo form_label('Note', 'note', array('class'=>'col-md-3 control-label')); ?>
		<div class="col-md-9">
			<?php echo form_textarea(array('name'=>'note', 'class'=>'form-control', 'placeholder'=>'Add a public note for the ticket.', 'value'=>$ticket->note)); ?>
		</div>
	</div>

	<?php if (is_array($ticket->files) && count($ticket->files)): ?>
	<div class="row">
		<div class="col-md-offset-3 col-md-9">
			<table class="table">
				<tr>
					<th>Attachments</th>
					<th class="action"></th>
				</tr>
				<?php foreach ($ticket->files as $file): ?>
				<tr>
					<td>
						<a href="<?php echo $this->config->item('aws_s3_public'); ?>/<?php echo $file->path; ?>"><span class="glyphicon glyphicon-save"></span> <?php echo ($file->file_name) ? htmlentities($file->file_name) : 'Download'; ?></a>
						<br /><small>Uploaded <?php echo date('F j, Y g:ia', gmt_to_local(strtotime($file->inserted_ts), 'UM6', true)); ?></small>
					</td>
					<td><a href="<?php echo site_url('tickets/deletefile/' . $file->ticket_file_id); ?>" class="btn btn-sm btn-danger confirm"><span class="glyphicon glyphicon-trash"></span></a></td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>

	<?php endif; ?>

	<div class="form-group">
		<div class="col-md-offset-3 col-md-9">
			<label for="ticket_file" class="sr-only">File input</label>
			<input type="file" id="ticket_file" name="ticket_file" />
			<p class="help-block">(Optional) Maximum upload size 2 MB.</p>
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
			<p class="form-control-static"><?php echo $ticket->owner->name; ?></p>
		</div>
	</div>
	<div class="form-group">
		<?php echo form_label('Assigned To', 'assigned', array('class'=>'col-md-3 control-label')); ?>
		<div class="col-md-9">
			<p class="form-control-static"><?php echo ($ticket->assigned) ? $ticket->assigned->name : 'Unassigned'; ?></p>
		</div>
	</div>
	<div class="form-group">
		<?php echo form_label('Cost', 'cost', array('class'=>'col-md-3 control-label')); ?>
		<div class="col-md-9">
			<p class="form-control-static">$<?php echo number_format($ticket->cost,2); ?></p>
		</div>
	</div>
	<?php if ($ticket->note): ?>
	<div class="form-group">
		<?php echo form_label('Note', 'note', array('class'=>'col-md-3 control-label')); ?>
		<div class="col-md-9">
			<p class="form-control-static"><?php echo $ticket->note; ?></p>
		</div>
	</div>
	<?php endif; ?>
	<div class="form-group">
		<?php echo form_label('Message', 'message', array('class'=>'col-md-3 control-label')); ?>
		<div class="col-md-9">
			<?php echo form_textarea(array('name'=>'message', 'class'=>'form-control', 'placeholder'=>'You can include additional notes here for this request. We will already include the ticket details.', 'value'=>'')); ?>
		</div>
	</div>
	<?php if (is_array($ticket->files) && count($ticket->files)): ?>
	<div class="form-group">
		<?php echo form_label('Attachments', 'attachments', array('class'=>'col-md-3 control-label')); ?>
		<div class="col-md-9">
			<p class="form-control-static">This ticket has <strong><?php echo (count($ticket->files) == 1) ? '1 file' : count($ticket->files) . ' files'; ?></strong> attached. Only the owner or ticket assignee can download attachments.</p>
		</div>
	<?php endif; ?>
	<div class="row">
		<div class="col-md-12">
			<p class="text-right">
				<?php echo form_submit(array('value'=>'Request Ticket', 'class'=>'btn btn-primary')); ?>
			</p>
		</div>
	</div>
<?php echo form_close(); ?>

<?php endif; ?>
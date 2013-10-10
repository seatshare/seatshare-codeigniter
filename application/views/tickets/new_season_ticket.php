<?php echo form_open('', array('role'=>'form', 'class' => 'form-horizontal')); ?>

<?php echo (validation_errors()) ? '<div class="alert alert-danger">' . validation_errors() . '</div>' : ''; ?>

<div class="row">
	<div class="col-md-12">
		<?php echo form_fieldset('Ticket details'); ?>
		<div class="form-group">
			<?php echo form_label('Section', 'section', array('class'=>'col-md-3 control-label')); ?>
			<div class="col-md-9">
				<?php echo form_input(array('name'=>'section', 'class'=>'form-control', 'placeholder'=>'326', 'value'=>$this->input->post('section'))); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo form_label('Row', 'row', array('class'=>'col-md-3 control-label')); ?>
			<div class="col-md-9">
				<?php echo form_input(array('name'=>'row', 'class'=>'form-control', 'placeholder'=>'K', 'value'=>$this->input->post('row'))); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo form_label('Seat', 'seat', array('class'=>'col-md-3 control-label')); ?>
			<div class="col-md-9">
				<?php echo form_input(array('name'=>'seat', 'class'=>'form-control', 'placeholder'=>'11', 'value'=>$this->input->post('seat'))); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo form_label('Cost', 'cost', array('class'=>'col-md-3 control-label')); ?>
			<div class="col-md-9">
				<?php echo form_input(array('name'=>'cost', 'class'=>'form-control', 'placeholder'=>'25.00', 'value'=>$this->input->post('cost'))); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo form_label('Assigned To', 'assigned', array('class'=>'col-md-3 control-label')); ?>
			<div class="col-md-9">
				<?php echo form_dropdown('assigned', $group_users, ($this->input->post('assigned')) ? $this->input->post('assigned') : $assigned->user_id, 'class="form-control"'); ?>
			</div>
		</div>
		<?php echo form_fieldset_close(); ?>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
	<?php echo form_fieldset('Events'); ?>
		<div class="form-group">
		<?php echo form_label('Select Events', 'events', array('class'=>'col-md-3 control-label')); ?>
		<div class="col-md-9">
				<?php foreach ($events as $event): ?>
				<div class="checkbox">
					<label>
						<?php echo form_checkbox(array(
							'name' => sprintf('events[%d]', $event->event_id),
							'value' => $event->event_id,
							'id' => sprintf('events_%d', $event->event_id),
							'checked' => true
						)); ?>
						<?php echo $event->event; ?>
						<div class="help-block"><span class="glyphicon glyphicon-calendar"></span> <?php if (!$event->date_tba): ?><?php echo date('l', strtotime($event->start_time)); ?>, <?php echo date('F j, Y', strtotime($event->start_time)); ?> - <?php echo ($event->time_tba) ? 'TBA' : date('g:i a', strtotime($event->start_time)); ?><?php endif; ?></div>
					</label>
				</div>
				<?php endforeach; ?>
		</div>
	<?php echo form_fieldset_close(); ?>
	</div>
</div>


<div class="row">
	<div class="col-md-12">
		<p class="text-right">
			<?php echo form_submit(array('value'=>'Add Ticket', 'class'=>'btn btn-primary')); ?>
		</p>
	</div>
</div>

<?php echo form_close(); ?>
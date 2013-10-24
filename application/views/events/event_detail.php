<div class="row">
	<div class="col-md-2">
		<img src="<?php echo $entity->logo; ?>" class="img-responsive img-thumbnail" />
	</div>
	<div class="col-md-6">
		<p><span class="glyphicon glyphicon-calendar"></span> <?php if (!$event->date_tba): ?><?php echo date('l', strtotime($event->start_time)); ?>, <?php echo date('F j, Y', strtotime($event->start_time)); ?> - <?php echo ($event->time_tba) ? 'TBA' : date('g:i a', strtotime($event->start_time)); ?><?php endif; ?></p>
		<h3><?php echo $event->event; ?></h3>
		<p><?php echo $event->description; ?></p>
	</div>
	<div class="col-md-4">
		<?php include APPPATH . '/views/shared/_tickets.php'; ?>
	</div>
</div>

<hr />

<?php if ($event->ticketStatus['tickets_available'] > 0): ?>
<div class="alert alert-info">
	<p><strong>There are tickets available for this event!</strong> Click on a ticket below to send a request.</p>
</div>
<?php else: ?>
<div class="alert alert-warning">
	<p><strong>No tickets are available right now.</strong> You can still <a href="<?php echo site_url('groups/new_message'); ?>" class="alert-link">send a group message</a> to see if everyone is going.</p>
</div>
<?php endif; ?>

<div class="pull-right">
	<ul class="list-inline">
		<li><a href="<?php echo site_url('tickets/create/' . $event->event_id); ?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> Add Ticket for this Event</a></li>
		<li><a href="<?php echo site_url('tickets/create_season'); ?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-calendar"></span> Add Season Tickets</a></li>
	</ul>
</div>

<p class="lead">These are the tickets that have been added for this event.</p> 

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Location</th>
			<th>Purchased By</th>
			<th>Assigned</th>
			<th>Cost</th>
			<th class="action"></th>
		</tr>
	</thead>
	<tbody>
	<?php if (is_array($tickets) && count($tickets)): ?>
	<?php foreach($tickets as $ticket): ?>
		<tr>
			<td>
				<a href="<?php echo site_url('tickets/ticket/' . $ticket->ticket_id); ?>">
				<span>
					<span><?php echo $ticket->section; ?></span>
					<span><?php echo $ticket->row; ?></span>
					<span><?php echo $ticket->seat; ?></span>
				</span>
				</a>
			</td>
			<td>
				<a href="<?php echo site_url('user/' . $ticket->owner->username); ?>"><?php echo $ticket->owner->name; ?></a>
			</td>
			<td>
				<?php if ($ticket->assigned): ?>
				<a href="<?php echo site_url('user/' . $ticket->assigned->username); ?>"><?php echo $ticket->assigned->name; ?></a>
				<?php else: ?>
				<a href="<?php echo site_url('tickets/ticket/' . $ticket->ticket_id); ?>"><span class="badge badge-lg">Available!</span></a>
				<?php endif; ?>
			</td>
			<td class="text-right">
				$<?php echo number_format($ticket->cost,2); ?>
			</td>
			<td>
				<div class="dropdown">
					<a data-toggle="dropdown" href="#" class="btn btn-default" id="ticket"><span class="glyphicon glyphicon-wrench"></span></a>
					<ul class="dropdown-menu pull-right" role="menu">
						<?php if ($ticket->owner_id != $this->user_model->getCurrentUser()->user_id): ?>
						<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('tickets/ticket/' . $ticket->ticket_id); ?>">Request</a></li>
						<?php endif; ?>
						<?php if ($ticket->owner_id == $this->user_model->getCurrentUser()->user_id && $ticket->assigned): ?>
						<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('tickets/unassign/' . $ticket->ticket_id); ?>">Unassign</a></li>
						<?php endif; ?>
						<?php if ($ticket->owner_id == $this->user_model->getCurrentUser()->user_id && !$ticket->assigned): ?>
						<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('tickets/ticket/' . $ticket->ticket_id); ?>">Assign</a></li>
						<?php endif; ?>
						<?php if ($ticket->owner_id == $this->user_model->getCurrentUser()->user_id): ?>
						<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('tickets/delete/' . $ticket->ticket_id); ?>" class="confirm">Delete</a></li>
						<?php endif; ?>
					</ul>
				</div>
			</td>
		</tr>
	<?php endforeach; ?>
	<?php else: ?>
		<tr>
			<td colspan="5">
				<div class="alert alert-info">
					<p>
						There are no tickets listed for this event in this group.
					</p>
				</div>
			</td>
		</tr>
	<?php endif; ?>
	</tbody>
</table>
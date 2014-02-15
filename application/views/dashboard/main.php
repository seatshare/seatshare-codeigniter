<div class="row visible-xs" style="margin-top:-20px;">
	<div class="well well-sm text-center">
		<ul class="list-inline" style="margin:0;">
			<li><a href="<?php echo site_url('tickets/create_season'); ?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-calendar"></span> Add Season Tickets</a></li>
			<li><a href="<?php echo site_url('groups/new_message'); ?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-bullhorn"></span> Group Message</a></li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="col-md-2">
		<img src="<?php echo $entity->logo; ?>" alt="<?php echo $entity->entity; ?>" class="img-responsive img-thumbnail hidden-xs" />
	</div>
	<div class="col-md-10">
		<p>Your <strong><?php echo $entity->entity; ?></strong> group is administered by <a href="<?php echo site_url('user/' . $group->administrator->username); ?>"><?php echo $group->administrator->first_name; ?> <?php echo $group->administrator->last_name; ?></a></p>
		<h2 style="margin-top:0">Upcoming Events</h2>
	</div>
</div>

<br />

<?php if (is_array($events) && count($events)): ?>

<?php foreach ($events as $k => $event): ?>
<?php if ($k === 0): ?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<span class="glyphicon glyphicon-calendar"></span> <?php if (!$event->date_tba): ?><?php echo date('l', strtotime($event->start_time)); ?>, <?php echo date('F j, Y', strtotime($event->start_time)); ?> - <?php echo ($event->time_tba) ? 'TBA' : date('g:i a', strtotime($event->start_time)); ?><?php endif; ?>
	</div>
	<div class="panel-body">
		<h2><a href="<?php echo site_url('events/event/'.$event->event_id); ?>"><?php echo $event->event; ?></a></h2>
		<p><?php echo ($event->description) ? $event->description : ''; ?></p>
		<?php if (!$event->ticketStatus['tickets_available']): ?>
		<p class="lead"><strong>No tickets are available right now.</strong><br />You can still <a href="<?php echo site_url('groups/new_message'); ?>" class="alert-link">send a group message</a> to see if everyone is going.</p>
		<?php else: ?>
		<p class="lead"><strong>There are tickets available for this event!</strong><br />Click on a ticket below to send a request.</p>
		<?php endif; ?>

		<div class="progress">
		  <div class="progress-bar progress-bar-success" role="progressbar" style="width: <?php echo ($event->ticketStatus['tickets_group']) ? number_format(($event->ticketStatus['tickets_group']-$event->ticketStatus['tickets_available'])/$event->ticketStatus['tickets_group']*100,3) : 0; ?>%">
		  </div>
		</div>

		<?php if ($event->ticketStatus['tickets_available']): ?>
		<table class="table">
			<tbody>
				<?php foreach ($event->tickets as $ticket): ?>
				<?php if ($ticket->assigned) { continue; } ?>
				<tr>
					<td>
						<a href="<?php echo site_url('/tickets/ticket/' . $ticket->ticket_id); ?>"><?php echo $ticket->section; ?> <?php echo $ticket->row; ?> <?php echo $ticket->seat; ?></a>
						<?php if ($ticket->note): ?>
						<span data-toggle="tooltip" title="<?php echo htmlentities($ticket->note); ?>" class="glyphicon glyphicon-comment"></span>
						<?php endif; ?>
					</td>
					<td>via <?php echo $ticket->owner->name; ?></td>
					<td class="text-right">
						<a data-toggle="tooltip" title="Request Ticket" href="<?php echo site_url('/tickets/ticket/' . $ticket->ticket_id); ?>" class="btn btn-primary">$<?php echo number_format($ticket->cost, 2); ?></a>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<?php endif; ?>
	</div>
</div>
<?php else: ?>
<div class="panel panel-default">
	<div class="panel-heading">
			<?php if ($event->ticketStatus['tickets_available']): ?>
			<div class="pull-right">
				<a href="javascript:void(0)" onclick="$('#tickets-<?php echo $event->event_id; ?>').collapse('toggle')" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-list"></span></a>
			</div>
			<?php endif; ?>
			<span class="glyphicon glyphicon-calendar"></span> <?php if (!$event->date_tba): ?><?php echo date('l', strtotime($event->start_time)); ?>, <?php echo date('F j, Y', strtotime($event->start_time)); ?> - <?php echo ($event->time_tba) ? 'TBA' : date('g:i a', strtotime($event->start_time)); ?><?php endif; ?>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-7">
				<h3><a href="<?php echo site_url('events/event/'.$event->event_id); ?>"><?php echo $event->event; ?></a></h3>
				<p><?php echo ($event->description) ? $event->description : ''; ?></p>
			</div>
			<div class="col-md-5">
				<?php include APPPATH . '/views/shared/_tickets.php'; ?>
			</div>
		</div>
		
		<?php if ($event->ticketStatus['tickets_available']): ?>
		<div id="tickets-<?php echo $event->event_id; ?>" class="collapse">
			<table class="table">
				<tbody>
					<?php foreach ($event->tickets as $ticket): ?>
					<?php if ($ticket->assigned) { continue; } ?>
					<tr>
						<td>
							<a href="<?php echo site_url('/tickets/ticket/' . $ticket->ticket_id); ?>"><?php echo $ticket->section; ?> <?php echo $ticket->row; ?> <?php echo $ticket->seat; ?></a>
							<?php if ($ticket->note): ?>
							<span data-toggle="tooltip" title="<?php echo htmlentities($ticket->note); ?>" class="glyphicon glyphicon-comment"></span>
							<?php endif; ?>
						</td>
						<td>via <?php echo $ticket->owner->name; ?></td>
						<td class="text-right">
							<a data-toggle="tooltip" title="Request Ticket" href="<?php echo site_url('/tickets/ticket/' . $ticket->ticket_id); ?>" class="btn btn-primary">$<?php echo number_format($ticket->cost, 2); ?></a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<?php endif; ?>
	</div>
</div>
<?php endif; ?>
<?php endforeach; ?>

<?php else: ?>

<div class="alert alert-info">
	<p>
		There are no events available right now. Please check back later.
	</p>
</div>

<?php endif; ?>
<div class="row">
	<div class="col-md-2">
		<img src="<?php echo $entity->logo; ?>" class="img-responsive" />
	</div>
	<div class="col-md-6">
		<p><?php if (!$event->date_tba): ?><?php echo date('l', strtotime($event->start_time)); ?>, <?php echo date('F j, Y', strtotime($event->start_time)); ?> - <?php echo ($event->time_tba) ? 'TBA' : date('g:i a', strtotime($event->start_time)); ?><?php endif; ?></p>
		<h3><?php echo $event->event; ?></h3>
	</div>
	<div class="col-md-4">
		<?php include APPPATH . '/views/shared/_tickets.php'; ?>
	</div>
</div>

<ul class="list-inline">
	<li><a href="<?php echo site_url('tickets/create/' . $event->event_id); ?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> Add Ticket for this Event</a></li>
	<li><a href="<?php echo site_url('tickets/create_season'); ?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-calendar"></span> Add Season Tickets</a></li>
</ul>
<div class="panel panel-default">
	<div class="panel-heading">
		<span class="glyphicon glyphicon-calendar"></span> <?php if (!$event->date_tba): ?><?php echo date('l', strtotime($event->start_time)); ?>, <?php echo date('F j, Y', strtotime($event->start_time)); ?> - <?php echo ($event->time_tba) ? 'TBA' : date('g:i a', strtotime($event->start_time)); ?><?php endif; ?>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-7">
				<h3><a href="<?php echo site_url('events/event/'.$event->event_id); ?>"><?php echo $event->event; ?></a></h3>
				<p><?php echo $event->description; ?></p>
				<?php if (isset($ticket)): ?>
				<ul class="list-inline">
					<li>Section: <?php echo $ticket->section; ?></li>
					<li>Row: <?php echo $ticket->row; ?></li>
					<li>Seat: <?php echo $ticket->seat; ?></li>
					<li>Cost: $<?php echo number_format($ticket->cost, 2); ?></li>
				</ul>
				<?php endif; ?>
			</div>
			<div class="col-md-5">
				<?php include APPPATH . '/views/shared/_tickets.php'; ?>
			</div>
		</div>
	</div>
</div>
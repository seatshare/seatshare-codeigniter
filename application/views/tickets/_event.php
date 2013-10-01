<div class="row well">
	<div class="col-md-7">
		<p><?php echo date('l', strtotime($event->start_time)); ?> <?php echo date('F j, Y', strtotime($event->start_time)); ?> - <?php echo date('g:i a', strtotime($event->start_time)); ?></p>
		<h2><a href="<?php echo site_url('events/event/'.$event->event_id); ?>"><?php echo $event->event; ?></a></h2>
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
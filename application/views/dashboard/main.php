<div class="row">
	<div class="col-md-2">
		<img src="<?php echo $entity->logo; ?>" class="img-responsive" />
	</div>
	<div class="col-md-10">
		<p>Your group is administered by <?php echo $group->administrator->name; ?></p>
		<h2>Upcoming Events</h2>
	</div>
</div>

<br />

<?php if (is_array($events) && count($events)): ?>

<?php foreach ($events as $event): ?>
<div class="row well">
	<div class="col-md-7">
		<p><?php echo date('l', strtotime($event->start_time)); ?>, <?php echo date('F j, Y', strtotime($event->start_time)); ?> - <?php echo date('g:i a', strtotime($event->start_time)); ?></p>
		<h3><a href="<?php echo site_url('events/event/'.$event->event_id); ?>"><?php echo $event->event; ?></a></h3>
	</div>
	<div class="col-md-5">
		<?php include APPPATH . '/views/shared/_tickets.php'; ?>
	</div>
</div>
<?php endforeach; ?>

<?php else: ?>

<div class="alert alert-info">
	<p>
		There are no events available right now. Please check back later.
	</p>
</div>

<?php endif; ?>
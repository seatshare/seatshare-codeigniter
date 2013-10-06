<div class="row">
	<div class="col-md-2">
		<img src="<?php echo $entity->logo; ?>" class="img-responsive" />
	</div>
	<div class="col-md-10">
		<p>Your <strong><?php echo $entity->entity; ?></strong> group is administered by <a href="<?php echo site_url('user/' . $group->administrator->username); ?>"><?php echo $group->administrator->first_name; ?> <?php echo $group->administrator->last_name; ?></a></p>
		<h2>Upcoming Events</h2>
	</div>
</div>

<br />

<?php if (is_array($events) && count($events)): ?>

<?php foreach ($events as $event): ?>
<div class="row well">
	<div class="col-md-7">
		<p><?php if (!$event->date_tba): ?><?php echo date('l', strtotime($event->start_time)); ?>, <?php echo date('F j, Y', strtotime($event->start_time)); ?> - <?php echo ($event->time_tba) ? 'TBA' : date('g:i a', strtotime($event->start_time)); ?><?php endif; ?></p>
		<h3><a href="<?php echo site_url('events/event/'.$event->event_id); ?>"><?php echo $event->event; ?></a></h3>
		<p><?php echo ($event->description) ? $event->description : ''; ?></p>
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
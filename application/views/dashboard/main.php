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

<?php foreach ($events as $event): ?>
<div class="well">
	<div class="row">
		<div class="col-md-7">
			<p><span class="glyphicon glyphicon-calendar"></span> <?php if (!$event->date_tba): ?><?php echo date('l', strtotime($event->start_time)); ?>, <?php echo date('F j, Y', strtotime($event->start_time)); ?> - <?php echo ($event->time_tba) ? 'TBA' : date('g:i a', strtotime($event->start_time)); ?><?php endif; ?></p>
			<h3><a href="<?php echo site_url('events/event/'.$event->event_id); ?>"><?php echo $event->event; ?></a></h3>
			<p><?php echo ($event->description) ? $event->description : ''; ?></p>
		</div>
		<div class="col-md-5">
			<?php include APPPATH . '/views/shared/_tickets.php'; ?>
		</div>
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
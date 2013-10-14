<p><?php echo $recipient->first_name; ?>,</p>

<p>This is your week ahead for <a href="<?php echo site_url('groups/group/' . $group->group_id); ?>"><?php echo $group->group; ?></a>. </p>

<?php foreach ($days_of_week as $dow): ?>
<?php if ($dow == 'Monday'): ?>
<h2>Today</h2>
<?php else: ?>
<h2><?php echo $dow; ?></h2>
<?php endif; ?>
<?php if (isset($events[$dow]) && is_array($events[$dow]) && count($events[$dow])): ?>
<?php foreach ($events[$dow] as $event): ?>
<dl>
	<dt>Event</dt>
	<dd><?php echo $event->event; ?></dd>
	<dt>Starts</dt>
	<dd><?php echo date('F j, Y g:i a', strtotime($event->start_time)); ?></dd>
	<?php if ($event->description): ?>
	<dt>Description</dt>
	<dd><?php echo $event->description; ?></dd>
	<dt>Tickets</dt>
	<dd>
		<ul>
			<li><span class="badge"><?php echo $event->ticketStatus['tickets_available']; ?></span> available in the group</li>
			<li><span class="badge"><?php echo $event->ticketStatus['tickets_group']; ?></span> total in the group</li>
			<li><span class="badge"><?php echo $event->ticketStatus['tickets_user']; ?></span> held by you</li>
		</ul>
	</dd>
	<?php endif; ?>
</dl>
<?php endforeach; ?>
<?php else: ?>
<p>No events.</p>
<?php endif; ?>
<hr />
<?php endforeach; ?>

<p>
	---<br />
	<a href="<?php echo site_url('/'); ?>"><?php echo $this->config->item('application_name'); ?></a>
</p>
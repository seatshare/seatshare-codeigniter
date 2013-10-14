<p><?php echo $recipient->first_name; ?>,</p>

<p>This is your daily summary for <a href="<?php echo site_url('groups/group/' . $group->group_id); ?>"><?php echo $group->group; ?></a>. We send these every morning if there are events that week. You can update your settings on <a href="<?php echo site_url('groups/group/' . $group->group_id); ?>">the group page</a>.</p>

<?php foreach ($events as $event): ?>
<hr />
<dl>
	<dt>Event</dt>
	<dd><a href="<?php echo site_url('events/event/' . $event->event_id); ?>"><?php echo $event->event; ?></a></dd>
	<dt>Starts</dt>
	<dd><?php echo date('F j, Y g:i a', strtotime($event->start_time)); ?></dd>
	<?php if ($event->description): ?>
	<dt>Description</dt>
	<dd><?php echo $event->description; ?></dd>
	<?php endif; ?>
	<dt>Tickets</dt>
	<dd>
		<ul>
			<li><span style="font-weight:bold;"><?php echo $event->ticketStatus['tickets_available']; ?></span> available in the group</li>
			<li><span style="font-weight:bold;"><?php echo $event->ticketStatus['tickets_group']; ?></span> total in the group</li>
			<li><span style="font-weight:bold;"><?php echo $event->ticketStatus['tickets_user']; ?></span> held by you</li>
		</ul>
	</dd>
</dl>
<?php endforeach; ?>
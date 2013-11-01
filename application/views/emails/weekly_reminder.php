<p><?php echo $recipient->first_name; ?>,</p>

<p>This is your week ahead for <a href="<?php echo site_url('groups/group/' . $group->group_id); ?>"><?php echo $group->group; ?></a>. We send these every Monday morning if there are events that week. You can update your reminder settings on <a href="<?php echo site_url('groups/group/' . $group->group_id); ?>">the group page</a>.</p>

<?php foreach ($days_of_week as $dow): ?>
<hr />
<?php if ($dow == 'Monday'): ?>
<h2>Today</h2>
<?php else: ?>
<h2><?php echo $dow; ?></h2>
<?php endif; ?>
<?php if (isset($events[$dow]) && is_array($events[$dow]) && count($events[$dow])): ?>
<?php foreach ($events[$dow] as $event): ?>

<table>
	<tr>
		<th style="witdh:100px">Event</th>
		<td><a href="<?php echo site_url('events/event/' . $event->event_id); ?>"><?php echo $event->event; ?></a></td>
	</tr>
	<tr>
		<th>Starts</th>
		<td><?php echo date('F j, Y g:i a', strtotime($event->start_time)); ?></td>
	</tr>
	<?php if ($event->description): ?>
	<tr>
		<th>Description</th>
		<td><?php echo $event->description; ?></td>
	</tr>
	<?php endif; ?>
	<tr>
		<th>Tickets</th>
		<td>
			<ul>
				<li><span style="font-weight:bold;"><?php echo $event->ticketStatus['tickets_available']; ?></span> available in the group</li>
				<li><span style="font-weight:bold;"><?php echo $event->ticketStatus['tickets_group']; ?></span> total in the group</li>
				<li><span style="font-weight:bold;"><?php echo $event->ticketStatus['tickets_user']; ?></span> held by you</li>
			</ul>
		</td>
	</tr>
</table>

<?php endforeach; ?>
<?php else: ?>
<p>No events.</p>
<?php endif; ?>
<?php endforeach; ?>
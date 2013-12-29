<p><?php echo $recipient->first_name; ?>,</p>

<p>This is your daily summary for <a href="<?php echo site_url('groups/group/' . $group->group_id); ?>"><?php echo $group->group; ?></a>. We send these every morning if there are events that day. You can update your reminder settings on <a href="<?php echo site_url('groups/group/' . $group->group_id); ?>">the group page</a>.</p>

<?php foreach ($events as $event): ?>
<hr />
<table cellpadding="10px">
	<tr>
		<th style="width:100px">Event</th>
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
			<?php if (is_array($event->tickets) && count($event->tickets)): ?>
			<table width="100%" cellpadding="10px">
				<tbody>
					<?php foreach ($event->tickets as $ticket): ?>
					<?php if ($ticket->assigned) { continue; } ?>
					<tr>
						<td><a href="<?php echo site_url('/tickets/ticket/' . $ticket->ticket_id); ?>"><?php echo $ticket->section; ?> <?php echo $ticket->row; ?> <?php echo $ticket->seat; ?></a></td>
						<td>via <?php echo $ticket->owner->name; ?></td>
						<td>
							<a href="<?php echo site_url('/tickets/ticket/' . $ticket->ticket_id); ?>">$<?php echo number_format($ticket->cost, 2); ?></a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php endif; ?>
		</td>
	</tr>
</table>
<?php endforeach; ?>
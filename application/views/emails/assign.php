<p><?php echo $recipient->first_name; ?>,</p>

<p><?php echo $user->first_name; ?> (<?php echo $user->email; ?>) has assigned a ticket to you for the following event in your group <?php echo $group->group; ?> </p>

<table>
	<tr>
		<th style="width:100px">Group</th>
		<td><?php echo $group->group; ?></td>
	</tr>
	<tr>
		<th>Event</th>
		<td><?php echo $event->event; ?> : <?php if (!$event->date_tba): ?><?php echo date('l', strtotime($event->start_time)); ?>, <?php echo date('F j, Y', strtotime($event->start_time)); ?> - <?php echo ($event->time_tba) ? 'TBA' : date('g:i a', strtotime($event->start_time)); ?><?php endif; ?></td>
	</tr>
	<tr>
		<th>Section</th>
		<td><?php echo $ticket->section; ?></td>
	</tr>
	<tr>
		<th>Row</th>
		<td><?php echo $ticket->row; ?></td>
	</tr>
	<tr>
		<th>Seat</th>
		<td><?php echo $ticket->seat; ?></td>
	</tr>
</table>

<p>You can view the details here: <a href="<?php echo site_url('tickets/ticket/' . $ticket->ticket_id); ?>"><?php echo site_url('tickets/ticket/' . $ticket->ticket_id); ?></a></p>
 
<p>Thank you!</p>
 
<p>
	---<br />
	<a href="<?php echo site_url('/'); ?>">SeatShare</a>, on behalf of
	<?php echo $user->first_name; ?> <?php echo $user->last_name; ?><br />
	<a href="mailto:<?php echo $user->email; ?>"><?php echo $user->email; ?></a>
</p>
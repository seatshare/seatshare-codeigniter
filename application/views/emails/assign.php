<p><?php echo $recipient->first_name; ?>,</p>

<p><?php echo $user->first_name; ?> (<?php echo $user->email; ?>) has assigned a ticket to you for the following event in your group <?php echo $group->group; ?> </p>

<table cellpadding="10px">
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

<?php if (is_array($ticket->files) && count($ticket->files)): ?>
<table cellpadding="10px">
	<tr>
		<th style="width:100px">Attachments</th>
		<td>
			<table>
				<?php foreach ($ticket->files as $file): ?>
				<tr>
					<td><a href="<?php echo $this->config->item('aws_s3_public'); ?>/<?php echo $file->path; ?>"><?php echo $file->file_name; ?></a></td>
				</tr>
				<?php endforeach; ?>
			</table>
		</td>
	</tr>
</table>
<?php endif; ?>

<p>You can view the details here: <a href="<?php echo site_url('tickets/ticket/' . $ticket->ticket_id); ?>"><?php echo site_url('tickets/ticket/' . $ticket->ticket_id); ?></a></p>
 
<p>Thank you!</p>
 
<p>
	---<br />
	<a href="<?php echo site_url('/'); ?>">SeatShare</a>, on behalf of
	<?php echo $user->first_name; ?> <?php echo $user->last_name; ?><br />
	<a href="mailto:<?php echo $user->email; ?>"><?php echo $user->email; ?></a>
</p>
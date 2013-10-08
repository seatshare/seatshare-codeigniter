 <p><?php echo $recipient->first_name; ?>,</p>

<p><?php echo $user->first_name; ?> (<?php echo $user->email; ?>) has assigned a ticket to you for the following event in your group <?php echo $group->group; ?> </p>

<dl> 
	<dt>Group</dt>
	<dd><?php echo $group->group; ?></dd>
	<dt>Event</dt>
	<dd><?php echo $event->event; ?> : <?php if (!$event->date_tba): ?><?php echo date('l', strtotime($event->start_time)); ?>, <?php echo date('F j, Y', strtotime($event->start_time)); ?> - <?php echo ($event->time_tba) ? 'TBA' : date('g:i a', strtotime($event->start_time)); ?><?php endif; ?></dd>
	<dt>Section</dt>
	<dd><?php echo $ticket->section; ?></dd>
	<dt>Row</dt>
	<dd><?php echo $ticket->row; ?></dd>
	<dt>Seat</dt>
	<dd><?php echo $ticket->seat; ?></dd>
</dl>

<p>You can view the details here: <a href="<?php echo site_url('tickets/ticket/' . $ticket->ticket_id); ?>"><?php echo site_url('tickets/ticket/' . $ticket->ticket_id); ?></a></p>
 
<p>Thank you!</p>
 
<p>
	---<br />
	<a href="<?php echo site_url('/'); ?>"><?php echo $this->config->item('application_name'); ?></a>, on behalf of
	<?php echo $user->first_name; ?> <?php echo $user->last_name; ?><br />
	<a href="mailto:<?php echo $user->email; ?>"><?php echo $user->email; ?></a>
</p>
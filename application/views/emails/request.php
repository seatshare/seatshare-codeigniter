
<p><?php echo nl2br($personalized); ?></p>

<hr />
 
<p><?php echo $recipient->first_name; ?>,</p>

<p><?php echo $user->first_name; ?> (<?php echo $user->email; ?>) has requested ticket(s) for the following event in your group <?php echo $group->group; ?> </p>

<dl> 
	<dt>Group</dt>
	<dd><?php echo $group->group; ?></dd>
	<dt>Section</dt>
	<dd><?php echo $ticket->section; ?></dd>
	<dt>Row</dt>
	<dd><?php echo $ticket->row; ?></dd>
	<dt>Seat</dt>
	<dd><?php echo $ticket->seat; ?></dd>
</dl>

<p>You can accept the request here: <a href="<?php echo site_url('events/event/' . $ticket->event_id); ?>"><?php echo site_url('events/event/' . $ticket->event_id); ?></a></p>
 
<p>Thank you!</p>
 
<p>
	---<br />
	<a href="<?php echo site_url('/'); ?>"><?php echo $this->config->item('application_name'); ?></a>, on behalf of
	<?php echo $user->first_name; ?> <?php echo $user->last_name; ?><br />
	<a href="mailto:<?php echo $user->email; ?>"><?php echo $user->email; ?></a>
</p>
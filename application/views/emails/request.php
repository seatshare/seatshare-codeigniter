
<?php echo $personalized; ?>
 
---
 
<?php echo $recipient->first_name; ?>,

<?php echo $user->first_name; ?> (<?php echo $user->email; ?>) has requested ticket(s) for the following event in your group <?php echo $group->group; ?> 
 
	Group: <?php echo $group->group; ?> 
	Section: <?php echo $ticket->section; ?> 
	Row: <?php echo $ticket->row; ?> 
	Seat: <?php echo $ticket->seat; ?> 
 
You can accept the request here: <?php echo site_url('events/event/' . $ticket->event_id); ?>
 
Thank you!
 
---
<?php $this->config->item('application_name'); ?>
<?php echo site_url('/'); ?>
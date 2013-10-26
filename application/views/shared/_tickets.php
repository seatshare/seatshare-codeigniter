<div class="progress">
  <div class="progress-bar progress-bar-success" role="progressbar" style="width: <?php echo ($event->ticketStatus['tickets_group']) ? number_format(($event->ticketStatus['tickets_group']-$event->ticketStatus['tickets_available'])/$event->ticketStatus['tickets_group']*100,3) : 0; ?>%">
  </div>
</div>
<ul class="list-unstyled">
	<li><span class="badge"><?php echo $event->ticketStatus['tickets_available']; ?></span> available in the group</li>
	<li><span class="badge"><?php echo $event->ticketStatus['tickets_group']; ?></span> total in the group</li>
	<li><span class="badge"><?php echo $event->ticketStatus['tickets_user']; ?></span> held by you</li>
</ul>
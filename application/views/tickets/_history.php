<h4>Ticket History</h4>
<?php if (is_array($history) && count($history)): ?>
<ul class="list-unstyled">
<?php foreach ($history as $item): ?>
	<?php $entry = json_decode($item->entry); ?>
	<li><?php echo $entry->user->first_name; ?> <?php echo substr($entry->user->last_name,0,1); ?>. <strong><?php echo $entry->text; ?></strong> <?php echo date('F j, Y g:ia', strtotime($item->inserted_ts)); ?></li>
<?php endforeach; ?>
</ul>
<?php else: ?>
<div class="alert alert-info">
	<p>
		There is no history associated with this ticket.
	</p>
</div>
<?php endif; ?>
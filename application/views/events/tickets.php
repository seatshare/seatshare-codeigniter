
<hr />

<h4>Tickets</h4>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Location</th>
			<th>Purchased By</th>
			<th>Assigned</th>
			<th>Cost</th>
			<th class="col-md-1"></th>
		</tr>
	</thead>
	<tbody>
	<?php if (is_array($tickets) && count($tickets)): ?>
	<?php foreach($tickets as $ticket): ?>
		<tr>
			<td>
				<a href="<?php echo site_url('tickets/ticket/' . $ticket->ticket_id); ?>">
				<span>
					<span><?php echo $ticket->section; ?></span>
					<span><?php echo $ticket->row; ?></span>
					<span><?php echo $ticket->seat; ?></span>
				</span>
				</a>
			</td>
			<td><?php echo $ticket->owner->name; ?></td>
			<td><?php echo ($ticket->assigned) ? $ticket->assigned->name : '<span class="badge badge-lg">Available</span>'; ?></td>
			<td class="text-right">
				$<?php echo number_format($ticket->cost,2); ?>
			</td>
			<td>
				<div class="dropdown">
					<a data-toggle="dropdown" href="#" class="btn btn-default" id="ticket">Actions</a>
					<ul class="dropdown-menu pull-right" role="menu">
						<?php if ($ticket->owner_id != $this->user_model->getCurrentUser()->user_id): ?>
						<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('tickets/ticket/' . $ticket->ticket_id); ?>">Request</a></li>
						<?php endif; ?>
						<?php if ($ticket->owner_id == $this->user_model->getCurrentUser()->user_id && $ticket->assigned): ?>
						<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('tickets/unassign/' . $ticket->ticket_id); ?>">Unassign</a></li>
						<?php endif; ?>
						<?php if ($ticket->owner_id == $this->user_model->getCurrentUser()->user_id && !$ticket->assigned): ?>
						<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('tickets/ticket/' . $ticket->ticket_id); ?>">Assign</a></li>
						<?php endif; ?>
						<?php if ($ticket->owner_id == $this->user_model->getCurrentUser()->user_id): ?>
						<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('tickets/delete/' . $ticket->ticket_id); ?>">Delete</a></li>
						<?php endif; ?>
					</ul>
				</div>
			</td>
		</tr>
	<?php endforeach; ?>
	<?php else: ?>
		<tr>
			<td colspan="5">
				<div class="alert alert-info">
					<p>
						There are no tickets listed for this event in this group.
					</p>
				</div>
			</td>
		</tr>
	<?php endif; ?>
	</tbody>
</table>
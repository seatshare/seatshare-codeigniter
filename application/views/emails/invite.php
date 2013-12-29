<?php if ($personalized): ?>
<p><?php echo nl2br($personalized); ?></p>

<hr />
<?php endif; ?>

<p>Hi!</p>
 
<p><?php echo $user->first_name; ?> has invited you to join our <strong><?php echo $entity->entity; ?></strong> group on <a href="<?php echo site_url('/'); ?>">SeatShare</a>, a service that helps manage our season tickets.</p>

<table cellpadding="10px">
	<tr>
		<th style="width:150px;">Create an Account</th>
		<td><a href="<?php echo site_url('register/?invitation_code=' . $invitation_code); ?>"><?php echo site_url('register/?invitation_code=' . $invitation_code); ?></a></td>
	</tr>
</table>
 
<p>Once you have signed up, your access code to join our group is below.</p>

<table cellpadding="10px">
	<tr>
		<th style="width:150px;">Group Name</th>
		<td><?php echo $group->group; ?></td>
	</tr>
	<tr>
		<th>Invitation Code</th>
		<td><?php echo $invitation_code; ?></td>
	</tr>
</table>

<p>If you have already registered, you will be able to join the group at: </p>
 
<table cellpadding="10px">
	<tr>
		<th style="width:150px;">Group Management</th>
		<td><a href="<?php echo site_url('groups'); ?>"><?php echo site_url('groups'); ?></a></td>
	</tr>
</table>

<p>Thank you!</p>
 
<p>
	---<br />
	<a href="<?php echo site_url('/'); ?>">SeatShare</a>, on behalf of
	<?php echo $user->first_name; ?> <?php echo $user->last_name; ?><br />
	<a href="mailto:<?php echo $user->email; ?>"><?php echo $user->email; ?></a>
</p>
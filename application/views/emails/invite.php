<p>Hi!</p>
 
<p><?php echo $user->first_name; ?> has invited you to join our group on <a href="<?php echo site_url('/'); ?>"><?php echo $this->config->item('application_name'); ?></a>, a service that helps manage our season tickets.</p>

<dl>
	<dt>You can register here</dt>
	<dd><a href="<?php echo site_url('register/?invitation_code=' . $invitation_code); ?>"><?php echo site_url('register/?invitation_code=' . $invitation_code); ?></a></dd>
</dl>
 
<p>Once you have signed up, your access code to join our group is below.</p>

<dl>
	<dt>Group Name</dt>
	<dd><?php echo $group->group; ?></dd>
	<dt>Invitation Code</dt>
	<dd><?php echo $invitation_code; ?></dd>
</dl>

If you have already registered, you will be able to join the group at: 
 
<dl>
	<dt>Group Management</dt>
	<dd><a href="<?php echo site_url('groups'); ?>"><?php echo site_url('groups'); ?></a></dd>
</dl>

<p>Thank you!</p>
 
<p>
	---<br />
	<a href="<?php echo site_url('/'); ?>"><?php echo $this->config->item('application_name'); ?></a>, on behalf of
	<?php echo $user->first_name; ?> <?php echo $user->last_name; ?><br />
	<a href="mailto:<?php echo $user->email; ?>"><?php echo $user->email; ?></a>
</p>
<h1>Welcome to <?php echo $this->config->item('application_name'); ?> </h1>

<p><?php echo $this->config->item('application_name'); ?> is a web-based utility helps manage a shared ticket pool for events, such as a sports team or performing arts venue.</p>

<ul>
	<li>Join an existing group or create your own</li>
	<li>List your seat location and price for a single game or an entire season</li>
	<li>Request another group member's available seats</li>
	<li>Invite users to join your group</li>
	<li>Easily switch between groups</li>
	<li>Contact other group members</li>
</ul>

<p>To get started, <a href="<?php echo site_url('register'); ?>">register for an account</a> or <a href="<?php echo site_url('login'); ?>">login</a>.</p>
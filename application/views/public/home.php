<h1>Welcome to <?php echo $this->config->item('application_name'); ?> </h1>
<p class="lead"><?php echo $this->config->item('application_name'); ?> is a web-based utility helps manage a shared ticket pool for events, such as a sports team or performing arts venue.</p>

<div class="visible-xs">
	<div class="well text-center">
		<ul class="list-inline" style="margin-bottom:0;">
			<li><a href="<?php echo site_url('register'); ?>" class="btn btn-primary">Register</a></li>
			<li><a href="<?php echo site_url('login'); ?>" class="btn btn-primary">Login</a></li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<h2>Groups</h2>
		<p>Join or create a new group to share your season tickets.</p>
	</div>
	<div class="col-md-4">
		<h2>Events</h2>
		<p>Your favorite teams and venues available with up-to-date schedules.</p>
	</div>
	<div class="col-md-4">
		<h2>Tickets</h2>
		<p>List a single game or an entire season of tickets to share with your group.</p>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<h2>Messaging</h2>
		<p>Send a message to the entire group, or just a few members.</p>
	</div>
	<div class="col-md-4">
		<h2>Notifications</h2>
		<p>Recieve an email when someone requests a ticket or assigns one to you.</p>
	</div>
	<div class="col-md-4">
		<h2>and more!</h2>
		<p><?php echo $this->config->item('application_name'); ?> is web-based software, so you get the latest features as soon as they are released.</p>
	</div>
</div>

<br />

<div class="row">
	<div class="col-md-12">
		<p class="lead">To get started, <a href="<?php echo site_url('register'); ?>">register for an account</a> or <a href="<?php echo site_url('login'); ?>">login</a>.</p>
	</div>
</div>
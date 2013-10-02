<h1>Welcome to <?php echo $this->config->item('application_name'); ?> </h1>

<p><?php echo $this->config->item('application_name'); ?> is a web based that utility helps manage a shared ticket pool for recurring events.</p>

<ul>
	<li>Join an existing group or create your own</li>
	<li>List your seat location and price</li>
	<li>Request another person's seats</li>
</ul>

<p>To get started, <a href="<?php echo site_url('register'); ?>">register for an account</a> or <a href="<?php echo site_url('login'); ?>">login</a>.</p>
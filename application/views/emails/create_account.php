<h2>Welcome to SeatShare!</h2>

<p><?php echo $recipient->first_name; ?>,</p>

<p>You have successfully created your <a href="<?php echo site_url('/'); ?>">SeatShare</a> account. We are glad to have you on board!</p>

<p>Your next steps:</p>

<ul>
	<li>If you have not already, you will want to <a href="<?php echo site_url('groups/join'); ?>">join</a> or <a href="<?php echo site_url('groups/create'); ?>">create a group</a>.</li>
	<li>Be sure to <a href="<?php echo site_url('tickets/create_season'); ?>">add your season tickets</a> and make sure you assign one to yourself.</li>
	<li>Check out the <a href="<?php echo site_url('groups/new_message'); ?>">group messaging feature</a> to get in touch with other members.</li>
</ul>

<p>Now you can manage your tickets! If you have any questions, be sure to <a href="mailto:contact@seatsha.re">let us know</a>!

<p>
	---<br />
	<a href="<?php echo site_url('/'); ?>">SeatShare</a>
</p>

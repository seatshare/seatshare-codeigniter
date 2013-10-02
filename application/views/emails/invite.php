
Hi!
 
You have been invited to join our group on <?php echo $this->config->item('application_name'); ?>, a service that helps manage our season tickets.
 
	You can register here: <?php echo site_url('register/?invitation_code=' . $group->invitation_code); ?> 
 
Once you have signed up, your access code to join our group is below.

	Group Name: <?php echo $group->group; ?> 
	Invitation Code: <?php echo $group->invitation_code; ?> 

If you have already registered, you will be able to join the group at: 
 
	Group Management: <?php echo site_url('groups'); ?> 

Thank you!
 
---
<?php echo $user->first_name; ?> <?php echo $user->last_name; ?> 
<?php echo $user->email; ?>
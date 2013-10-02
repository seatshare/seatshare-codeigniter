<?php if ($invitation_code): ?>
<div class="alert alert-success">
	<h4>You've been invited join a group!</h4>
	<p>You are registering with an invitation code, so you will be ready to go here in just a bit!</p>
	<br />
	<p class="text-lg">Invitation code: <strong><?php echo $invitation_code; ?></strong></p>
</div>
<?php else: ?>
<div class="alert alert-info">
	<h4>Joining a group?</h4>
	<p>You will be asked to either create a group or join an existing group after your account is created.</p>
</div>
<?php endif; ?>
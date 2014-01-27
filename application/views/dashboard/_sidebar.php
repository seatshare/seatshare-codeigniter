<?php if (count($events)): ?>

<div class="well text-center">
	<ul class="list-inline" style="margin-bottom:0;">
		<li><a href="<?php echo site_url('tickets/create_season'); ?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-calendar"></span> Add Season Tickets</a></li>
		<li><a href="<?php echo site_url('groups/new_message'); ?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-bullhorn"></span> Group Message</a></li>
	</ul>
</div>

<?php echo form_fieldset('Calendar'); ?>
<div id="sidebar_calendar"></div>
<?php echo form_fieldset_close(); ?>

<?php endif; ?>

<?php echo form_fieldset('Group members'); ?>

<ul class="list-unstyled group-members">
	<?php foreach ($group_users as $row): ?>
	<li><?php echo gravatar($row->email, 32); ?> <a href="<?php echo site_url('user/' . $row->username); ?>"><?php echo $row->first_name; ?> <?php echo $row->last_name; ?></a></li>
	<?php endforeach; ?>
</ul>

<?php echo form_fieldset_close(); ?>
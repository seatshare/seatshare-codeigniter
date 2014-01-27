
<p class="lead">Groups of users exchange tickets among its membership. You can assign tickets to other users, or request their available tickets.</p> 

<hr />

<div class="row">

	<?php foreach ($groups as $group): ?>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="pull-right">
					<?php echo ($group->role == 'admin') ? '<span class="label label-default">Administrator</span>' : ''; ?>
				</div>
				<strong><a href="<?php echo site_url('groups/group/' . $group->group_id); ?>"><?php echo $group->group; ?></a></strong>
			</div>
			<div class="panel-body">
				<ul class="list-unstyled text-center">
					<li>A <strong><?php echo $group->entity; ?></strong> group.</li>
					<li>
						<?php echo count($group->members); ?> members.
					</li>
				</ul>
				<hr />
				<ul class="list-inline text-center">
					<li><a href="<?php echo site_url('groups/group/' . $group->group_id); ?>" class="btn btn-default">View Group</a></li>
					<li><a href="<?php echo site_url('groups/switch_groups/' . $group->group_id); ?>" class="btn btn-default">Switch to Group</a></li>
				</ul>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<strong>Join or Create a Group</strong>
			</div>
			<div class="panel-body">
				<p class="text-center">
					You can create a new group<br />
					to share your season tickets.
				</p>
				<hr />
				<ul class="list-inline text-center">
					<li><a href="<?php echo site_url('groups/join'); ?>" class="btn btn-primary">Join a Group</a></li>
					<li><a href="<?php echo site_url('groups/create'); ?>" class="btn btn-primary">Create a Group</a></li>
				</ul>
			</div>
		</div>
	</div>

</div>
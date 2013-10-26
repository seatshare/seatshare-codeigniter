<h2>Your groups</h2>

<p class="lead">Groups of users exchange tickets among its membership. You can assign tickets to other users, or request their available tickets.</p> 

<hr />

<?php foreach ($groups as $group): ?>
<div class="row">
	<div class="col-md-2">
		<img src="<?php echo $group->logo; ?>" alt="Logo" class="img-responsive img-thumbnail" /> 
	</div>
	<div class="col-md-8">
		<h3><a href="<?php echo site_url('groups/group/' . $group->group_id); ?>"><?php echo $group->group; ?></a></h3>
		<p>A <strong><?php echo $group->entity; ?></strong> group.</p>
		<ul class="list-inline group-members">
			<?php foreach ($this->group_model->getGroupUsersByGroupId($group->group_id) as $row): ?>
			<li>
				<?php echo gravatar($row->email, 25); ?>
				<?php if ($row->role=='admin'): ?>
				<span class="glyphicon glyphicon-star"></span>
				<?php endif; ?>
				<a href="<?php echo site_url('user/' . $row->username); ?>"><?php echo $row->first_name; ?> <?php echo $row->last_name; ?></a>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<div class="col-md-2">
		<a href="<?php echo site_url('groups/switch_groups/' . $group->group_id); ?>" class="btn btn-default"><span class="glyphicon glyphicon-link"></span> Switch to Group</a>
	</div>
</div>
<hr />
<?php endforeach; ?>
<div class="row">
	<div class="col-md-12">
		<p class="text-right">
			<a href="<?php echo site_url('groups/join'); ?>" class="btn btn-primary">Join a Group</a> or <a href="<?php echo site_url('groups/create'); ?>" class="btn btn-primary">Create a Group</a>
		</p>
	</div>
</div>
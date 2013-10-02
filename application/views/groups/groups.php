<h2>Your groups</h2>

<?php foreach ($groups as $group): ?>
<div class="row">
	<div class="col-md-2">
		<img src="<?php echo $group->logo; ?>" class="img-responsive" /> 
	</div>
	<div class="col-md-10">
		<h3><a href="<?php echo site_url('groups/switch_groups/' . $group->group_id); ?>"><?php echo $group->group; ?></a></h3>
		<ul class="list-inline">
			<?php foreach ($this->group_model->getGroupUsersByGroupId($group->group_id) as $row): ?>
			<li><img src="http://gravatar.com/avatar/<?php echo md5($row->email); ?>?s=32"> <?php echo $row->first_name; ?> <?php echo $row->last_name; ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<?php endforeach; ?>
<div class="row">
	<div class="col-md-2">
		&nbsp;
	</div>
	<div class="col-md-10">
		<br />
		<a href="<?php echo site_url('groups/join'); ?>" class="btn btn-primary">Join a Group</a> or <a href="<?php echo site_url('groups/create'); ?>" class="btn btn-primary">Create a Group</a>
	</div>
</div>
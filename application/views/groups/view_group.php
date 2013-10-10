<div class="row">
	<div class="col-md-3">
		<p>
			<img src="<?php echo $entity->logo; ?>" class="img-responsive" />
		</p>
		<p>
			<small>Created <?php echo date('n/j/Y', strtotime($group->inserted_ts)); ?></small>
		</p>
	</div>
	<div class="col-md-9">
		<p class="text-right">
			<?php if ($this->user_model->getCurrentUser()->user_id != $group_admin->user_id):?>
			<a href="<?php echo site_url('groups/leave/' . $group->group_id); ?>" class="btn btn-danger"><span class="glyphicon glyphicon-log-out"></span> Leave Group</a>
			<?php else: ?>
			<a href="<?php echo site_url('groups/edit/' . $group->group_id); ?>" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span> Edit Group</a>
			<?php endif; ?>
		</p>
		<h2><?php echo $group->group; ?></h2>
		<p>A <strong><?php echo $entity->entity; ?></strong> group administered by <a href="<?php echo site_url('user/' . $group_admin->username); ?>"><?php echo $group_admin->name; ?></a></p>

		<ul class="list-unstyled group-members">
			<?php foreach ($group_users as $row): ?>
			<li>
				<?php echo gravatar($row->email, 25); ?>
				<?php if ($row->role=='admin'): ?>
				<span class="glyphicon glyphicon-star"></span>
				<?php endif; ?>
				<a href="<?php echo site_url('user/' . $row->username); ?>"><?php echo $row->first_name; ?> <?php echo $row->last_name; ?></a>
			</li>
			<?php endforeach; ?>
		</ul>
		<div class="well">
			<h4>Group Invitation Code <small><?php echo $group->invitation_code; ?></small></h4>
			<p>
				<?php echo form_label('Invitation Link'); ?>
				<?php echo form_input(array('class'=>'form-control', 'value'=>site_url('register/?invitation_code=' . $group->invitation_code), 'readonly'=>true)); ?>
			</p>
		</div>
	</div>
</div>


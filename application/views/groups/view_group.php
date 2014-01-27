<div class="row">
	<div class="col-md-3">
		<p>
			<img src="<?php echo $entity->logo; ?>" alt="<?php echo $entity->entity; ?>" class="img-responsive img-thumbnail" />
		</p>
		<p>
			<small>Created <?php echo date('n/j/Y', strtotime($group->inserted_ts)); ?></small>
		</p>
	</div>
	<div class="col-md-9">

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="pull-right">
					<?php if ($this->user_model->getCurrentUser()->user_id != $group_admin->user_id):?>
					<a href="<?php echo site_url('groups/leave/' . $group->group_id); ?>" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-log-out"></span> Leave Group</a>
					<?php else: ?>
					<a href="<?php echo site_url('groups/edit/' . $group->group_id); ?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-pencil"></span> Edit Group</a>
					<?php endif; ?>
				</div>
				<h4><?php echo $group->group; ?></h4>
			</div>
			<div class="panel-body">
				<p>
					<?php echo form_label('Invitation Link'); ?>
					<?php echo form_input(array('class'=>'form-control', 'value'=>site_url('register/?invitation_code=' . $group->invitation_code), 'readonly'=>true)); ?>
				</p>
			</div>
		</div>

		<table class="table">
			<tr>
				<th class="action"></th>
				<th>Name</th>
				<th>Email</th>
			</tr>
			<?php foreach ($group_users as $row): ?>
			<tr>
				<td><?php echo gravatar($row->email, 25); ?></td>
				<td>
					<?php if ($row->role=='admin'): ?>
					<span class="glyphicon glyphicon-star" data-toggle="tooltip" data-placement="top" title="Tooltip on top"></span>
					<?php endif; ?>
					<a href="<?php echo site_url('user/' . $row->username); ?>"><?php echo $row->first_name; ?> <?php echo $row->last_name; ?></a>
				</td>
				<td><a href="mailto:<?php echo $row->email; ?>"><?php echo $row->email; ?></a></td>
			</tr>
			<?php endforeach; ?>
		</table>

	</div>
</div>


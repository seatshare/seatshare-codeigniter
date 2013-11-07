<fieldset>
	<legend>Aliases</legend>
	<p class="text-muted">"Aliases" allow you to flag tickets that are assigned to you, but under a different name, such as your spouse or sibling. You can create as many aliases as you need.</p>

	<table class="table">
		<thead>
			<tr>
				<th>Name</th>
				<th class="action">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($aliases as $alias): ?>
			<tr>
				<td><a href="<?php echo site_url('profile/alias/' . $alias->alias_id); ?>"><?php echo $alias->name; ?></a></td>
				<td><a href="<?php echo site_url('profile/alias/' . $alias->alias_id); ?>?delete=1" class="btn btn-sm btn-danger confirm"><span class="glyphicon glyphicon-trash"></span></a></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<p class="text-right">
		<a href="<?php echo site_url('profile/newalias'); ?>" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Add Alias</a>
	</p>

</fieldset>
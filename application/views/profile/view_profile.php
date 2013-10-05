<div class="row">
	<div class="col-md-3">
		<p>
			<?php echo gravatar($profile->email, 250, 'img-responsive'); ?>
		</p>
		<p>
			<small>Joined <?php echo date('n/j/Y', strtotime($profile->inserted_ts)); ?></small>
		</p>
	</div>
	<div class="col-md-9">
		<h2><?php echo $profile->first_name; ?> <?php echo $profile->last_name; ?></h2>
		<ul class="list-unstyled">
			<li><span class="glyphicon glyphicon-envelope"></span> <a href="mailto:<?php echo $profile->email; ?>"><?php echo $profile->email; ?></a></li>
			<li><span class="glyphicon glyphicon-user"></span> <?php echo $profile->username; ?></li>
		</ul>
	</div>
</div>
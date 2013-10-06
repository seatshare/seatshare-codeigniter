<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo (isset($title)) ? $title : $this->config->item('application_name'); ?></title>

<link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/libraries/bootstrap/css/bootstrap.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/libraries/bootstrap/css/bootstrap-theme.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/libraries/jquery.growl/stylesheets/jquery.growl.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/css/seatshare.css'); ?>">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php echo (isset($head)) ? $head : ''; ?>

</head>
<body>

<?php include_once '_navbar.php'; ?>

<div class="container">

{yield}

<footer class="row">
	<div class="col-md-12">
		<hr />
		<p>
			<em>Provided by <?php echo $this->config->item('application_name'); ?></em>
		</p>
	</div>
</footer>

</div>

<script src="http://code.jquery.com/jquery-1.10.1.min.js"> </script>
<script src="<?php echo site_url('/assets/libraries/bootstrap/js/bootstrap.js'); ?>"> </script>
<script src="<?php echo site_url('/assets/libraries/jquery.growl/javascripts/jquery.growl.js'); ?>"> </script>
<script src="<?php echo site_url('/assets/js/seatshare.js'); ?>"> </script>

<?php include_once('_growl.php'); ?>

<?php echo (isset($foot)) ? $foot : ''; ?>

</body>
</html>
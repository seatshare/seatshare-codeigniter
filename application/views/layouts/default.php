<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo (isset($title)) ? $title : $this->config->item('application_name'); ?></title>

<link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/libraries/bootstrap/css/bootstrap.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/libraries/clndr/clndr.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/libraries/jquery.growl/stylesheets/jquery.growl.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/css/seatshare.css'); ?>">

<link rel="apple-touch-icon" href="<?php echo site_url('assets/images/touch-icon-iphone.png'); ?>">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo site_url('assets/images/touch-icon-ipad.png'); ?>">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo site_url('assets/images/touch-icon-iphone-retina.png'); ?>">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo site_url('assets/images/touch-icon-ipad-retina.png'); ?>">
<link rel="icon" type="image/png" href="<?php echo site_url('assets/images/favicon.png'); ?>">

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="apple-mobile-web-app-title" content="<?php echo $this->config->item('application_name'); ?>">

<?php include_once('_mixpanel.php'); ?>

<?php echo (isset($head)) ? $head : ''; ?>

</head>
<body>

<?php include_once '_navbar.php'; ?>

<div class="container">

{yield}

<?php include_once '_footer.php'; ?>

</div>

<script src="http://code.jquery.com/jquery-1.10.1.min.js"> </script>
<script src="<?php echo site_url('/assets/libraries/bootstrap/js/bootstrap.js'); ?>"> </script>
<script src="<?php echo site_url('/assets/libraries/momentjs/moment.js'); ?>"> </script>
<script src="<?php echo site_url('/assets/libraries/underscorejs/underscore.js'); ?>"> </script>
<script src="<?php echo site_url('/assets/libraries/clndr/clndr.js'); ?>"> </script>
<script src="<?php echo site_url('/assets/libraries/purl/purl.js'); ?>"> </script>
<script src="<?php echo site_url('/assets/libraries/jquery.growl/javascripts/jquery.growl.js'); ?>"> </script>
<script src="<?php echo site_url('/assets/js/seatshare.js'); ?>"> </script>

<?php include_once '_analytics.php'; ?>

<?php include_once '_growl.php'; ?>

<?php echo (isset($foot)) ? $foot : ''; ?>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">

<title><?php echo ($this->template->getPageTitle()) ? $this->template->getPageTitle() : 'SeatShare'; ?></title>

<link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/libraries/bootstrap/css/bootstrap.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/libraries/clndr/clndr.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/libraries/jquery.growl/stylesheets/jquery.growl.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/css/seatshare.css'); ?>">
<link rel="icon" type="image/png" href="<?php echo site_url('assets/images/favicon.png'); ?>">

<meta charset="utf-8">

<?php include_once('_ios.php'); ?>

<?php include_once('_mixpanel.php'); ?>

<?php echo $this->template->getHead(); ?>

</head>
<body class="default">

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

<?php echo $this->template->getFoot(); ?>

</body>
</html>

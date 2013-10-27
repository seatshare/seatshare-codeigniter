<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?php echo (isset($title)) ? $title : $this->config->item('application_name'); ?></title>

<link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/libraries/bootstrap/css/bootstrap.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/libraries/jquery.growl/stylesheets/jquery.growl.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/css/login.css'); ?>">

<link rel="apple-touch-icon" href="<?php echo site_url('assets/images/touch-icon-iphone.png'); ?>">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo site_url('assets/images/touch-icon-ipad.png'); ?>">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo site_url('assets/images/touch-icon-iphone-retina.png'); ?>">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo site_url('assets/images/touch-icon-ipad-retina.png'); ?>">
<link rel="icon" type="image/png" href="<?php echo site_url('assets/images/favicon.png'); ?>">

<meta name="apple-mobile-web-app-title" content="<?php echo $this->config->item('application_name'); ?>">

<?php echo (isset($head)) ? $head : ''; ?>

</head>

<body>

<div class="container">

  <?php if ( $this->session->flashdata('error') ): ?>
    <div class="alert alert-danger">
      <?php echo $this->session->flashdata('error'); ?>
    </div>
  <?php endif; ?>

  <div class="logo">
    <h1><a href="<?php echo site_url('/'); ?>"><?php echo $this->config->item('application_name'); ?></a></h1>
  </div>

  {yield}

  <br />

  <div class="alert alert-info">
    <p>
      Need to <a href="<?php echo site_url('register'); ?>" class="alert-link">register for an account</a>?
    </p>
  </div>

</div>

<script src="http://code.jquery.com/jquery-1.10.1.min.js"> </script>
<script src="<?php echo site_url('/assets/libraries/bootstrap/js/bootstrap.js'); ?>"> </script>
<script src="<?php echo site_url('/assets/libraries/jquery.growl/javascripts/jquery.growl.js'); ?>"> </script>

<?php include_once '_analytics.php'; ?>

<?php include_once '_growl.php'; ?>

<?php echo (isset($foot)) ? $foot : ''; ?>

</body>
</html>

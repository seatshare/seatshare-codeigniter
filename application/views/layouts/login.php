<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">

<title><?php echo ($this->template->getPageTitle()) ? $this->template->getPageTitle() : $this->config->item('application_name'); ?></title>

<link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/libraries/bootstrap/css/bootstrap.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/libraries/jquery.growl/stylesheets/jquery.growl.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/css/login.css'); ?>">
<link rel="icon" type="image/png" href="<?php echo site_url('assets/images/favicon.png'); ?>">

<?php include_once('_ios.php'); ?>

<?php include_once('_mixpanel.php'); ?>

<?php echo $this->template->getHead(); ?>

</head>

<body class="login">

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
<script src="<?php echo site_url('/assets/libraries/purl/purl.js'); ?>"> </script>

<?php include_once '_analytics.php'; ?>

<?php include_once '_growl.php'; ?>

<?php echo $this->template->getFoot(); ?>

</body>
</html>

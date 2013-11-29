<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">

<title><?php echo ($this->template->getPageTitle()) ? $this->template->getPageTitle() : 'SeatShare'; ?></title>

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
    <h1><a href="<?php echo site_url('/'); ?>">SeatShare</a></h1>
  </div>

  {yield}

  <br />

  <div class="alert alert-info">
    <p>
      Need to <a href="<?php echo site_url('register'); ?>" class="alert-link">register for an account</a>?
    </p>
  </div>

</div>

<div class="sr-only">
  <p>Existing users can use this page to access their account. If you need an access, you can <a href="<?php echo site_url('register'); ?>">create an account</a>. You can also <a href="<?php echo site_url('login/forgot_password'); ?>">retrieve your username and password</a> if needed.</p>
</div>

<script src="https://code.jquery.com/jquery-1.10.1.min.js"> </script>
<script src="<?php echo site_url('/assets/libraries/bootstrap/js/bootstrap.js'); ?>"> </script>
<script src="<?php echo site_url('/assets/libraries/jquery.growl/javascripts/jquery.growl.js'); ?>"> </script>
<script src="<?php echo site_url('/assets/libraries/purl/purl.js'); ?>"> </script>
<script src="<?php echo site_url('/assets/js/seatshare.js'); ?>"> </script>

<?php include_once '_analytics.php'; ?>

<?php include_once '_growl.php'; ?>

<?php echo $this->template->getFoot(); ?>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $this->config->item('application_name'); ?></title>

	<link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/libraries/bootstrap/css/bootstrap.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/libraries/bootstrap/css/bootstrap-theme.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/css/login.css'); ?>">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
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
    <script src="<?php echo site_url('/assets/js/seatshare.js'); ?>"> </script>

  </body>
</html>

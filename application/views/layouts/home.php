<!DOCTYPE html>
<html lang="en">
<head>

<title><?php echo $this->template->getPageTitle(); ?></title>

<meta charset="utf-8">

<link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/libraries/bootstrap/css/bootstrap.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/libraries/clndr/clndr.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/libraries/jquery.growl/stylesheets/jquery.growl.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/css/seatshare.css'); ?>">
<link rel="icon" type="image/png" href="<?php echo site_url('assets/images/favicon.png'); ?>">

<?php include_once('_ios.php'); ?>

<?php include_once('_mixpanel.php'); ?>

<?php echo $this->template->getHead(); ?>

</head>
<body class="home">

<div class="navbar navbar-inverse home-navbar hidden-xs">
  <div class="container">
      <ul class="nav navbar-nav pull-right">
        <li class="<?php echo ($this->uri->segment(1) == 'logout') ? 'active' : ''; ?>"><a href="<?php echo site_url('register'); ?>">Create Account</a></li>
        <li><a href="<?php echo site_url('login'); ?>">Login</a></li>
      </ul>
    </div>
</div>

<div class="home-header">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <a href="<?php echo site_url('register'); ?>"><img src="<?php echo site_url('assets/images/seatshare-inverted.svg'); ?>" class="home-logo img-responsive" alt="SeatShare" title="SeatShare Logo" /></a>
            </div>
            <div class="col-md-5">
                <a href="<?php echo site_url('register'); ?>"><img src="<?php echo site_url('assets/images/screenshot-laptop.png'); ?>" class="home-screenshot img-responsive visible-md visible-lg" alt="Screenshots" title="Simulated Desktop Screenshot" /></a>
            </div>
        </div>
    </div>
</div>

<div class="container">

<h1>What is SeatShare?</h1>
<p class="lead">SeatShare is the easiest way to manage your shared pool of tickets for a sports team or performing arts venue.</p>

<div class="visible-xs">
    <div class="well text-center">
        <ul class="list-inline" style="margin-bottom:0;">
            <li><a href="<?php echo site_url('register'); ?>" class="btn btn-primary">Register</a></li>
            <li><a href="<?php echo site_url('login'); ?>" class="btn btn-primary">Login</a></li>
        </ul>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <a href="<?php echo site_url('register'); ?>"><img src="<?php echo site_url('assets/images/screenshot-iphone.png'); ?>" class="img-responsive visible-md visible-lg" alt="Screenshots" title="Simulated Mobile Screenshot" /></a>
    </div>
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-4">
                <h2>Groups</h2>
                <p>Join or create a new group to share your season tickets with friend and coworkers.</p>
            </div>
            <div class="col-md-4">
                <h2>Events</h2>
                <p>Your favorite teams and venues are available with up-to-date schedules. Plan the entire season.</p>
            </div>
            <div class="col-md-4">
                <h2>Tickets</h2>
                <p>List a single game or an entire season of tickets to share with your group. Sit with people you know.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h2>Messaging</h2>
                <p>Send a message to the entire group, or just a few members. Our site is mobile friendly, too.</p>
            </div>
            <div class="col-md-4">
                <h2>Notifications</h2>
                <p>Recieve an email when someone requests a ticket or assigns one to you. Respond quickly from your phone.</p>
            </div>
            <div class="col-md-4">
                <h2>&amp; more!</h2>
                <p>SeatShare is web-based software, so you get the latest features as soon as they are released.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="home-cta">
                    <p class="lead text-center"><a href="<?php echo site_url('register'); ?>" class="btn btn-primary btn-lg">Create Your SeatShare Account</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <br />
        <hr />
        <br />
    </div>
</div>

<div class="row">
    <div class="col-md-offset-1 col-md-7">
        <h3>Getting Started</h3>
        <p class="lead">Everything in SeatShare is organized around the idea of a group. A group is a collection of users (like you!) that often purchased season tickets or receive them from a friend. Generally, a group consists of folks that you know and trust already.</p>
    </div>
    <div class="col-md-3">
        <a href="<?php echo site_url('register'); ?>"><img src="<?php echo site_url('assets/images/screenshot-groups.png'); ?>" alt="Groups" class="img-thumbnail hidden-xs" /></a>
    </div>
</div>
<hr />
<div class="row">
    <div class="col-md-7 col-md-push-4">
        <h3>Calendar of Events</h3>
        <p class="lead">When you join or create a group, you will see a list of ‘Events’ for that team or venue. In most cases, these are individual games in the season ticket package. These are pre-loaded in the system for each team and venue available.</p>
    </div>
    <div class="col-md-3 col-md-pull-6">
        <a href="<?php echo site_url('register'); ?>"><img src="<?php echo site_url('assets/images/screenshot-events.png'); ?>" alt="Events" class="img-thumbnail  hidden-xs" /></a>
    </div>
</div>
<hr />
<div class="row">
    <div class="col-md-offset-1 col-md-7">
        <h3>Need Tickets?</h3>
        <p class="lead">If you want to attend an event, find an available ticket and use the dropdown menu to “Request” the ticket. This will send a message to the ticket holder saying that you want to attend that event. Ticketholders can then update the ticket’s assignee.</p>
        <p class="lead text-center"><a href="<?php echo site_url('register'); ?>" class="btn btn-primary btn-lg">Create Your SeatShare Account</a></p>
    </div>
    <div class="col-md-3">
        <a href="<?php echo site_url('register'); ?>"><img src="<?php echo site_url('assets/images/screenshot-tickets.png'); ?>" alt="Tickets" class="img-thumbnail hidden-xs" /></a>
    </div>
</div>


<?php include_once '_footer.php'; ?>

</div>

<script src="http://code.jquery.com/jquery-1.10.1.min.js"> </script>
<script src="<?php echo site_url('/assets/libraries/bootstrap/js/bootstrap.js'); ?>"> </script>
<script src="<?php echo site_url('/assets/libraries/momentjs/moment.js'); ?>"> </script>
<script src="<?php echo site_url('/assets/libraries/underscorejs/underscore.js'); ?>"> </script>
<script src="<?php echo site_url('/assets/libraries/clndr/clndr.js'); ?>"> </script>
<script src="<?php echo site_url('/assets/libraries/purl/purl.js'); ?>"> </script>
<script src="<?php echo site_url('/assets/libraries/jquery.growl/javascripts/jquery.growl.js'); ?>"> </script>
<script src="<?php echo site_url('/assets/js/seatshare.js?v=1'); ?>"> </script>

<?php include_once '_analytics.php'; ?>

<?php include_once '_growl.php'; ?>

<?php echo $this->template->getFoot(); ?>

</body>
</html>

<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo site_url('/'); ?>"><?php echo $this->config->item('application_name'); ?></a>
    </div>
    <div class="navbar-collapse collapse">
      <?php if ($this->user_model->isLoggedIn()): ?>
      <?php if ($this->group_model->getUserGroups()): ?>
      <form class="navbar-form navbar-left" role="form">
        <div class="form-group">
          <?php echo form_dropdown('group', $this->group_model->getUserGroups(), $this->group_model->getCurrentGroupId(), 'id="group_switcher" class="form-control"'); ?>
        </div>
      </form>
      <?php endif; ?>
      <ul class="nav navbar-nav">
        <li><a href="<?php echo site_url('dashboard'); ?>">Dashboard</a></li>
        <li><a href="<?php echo site_url('groups'); ?>">Groups</a></li>
      </ul>
      <ul class="nav navbar-nav pull-right">
        <li><a><?php echo $this->user_model->getCurrentUser()->first_name; ?> <?php echo $this->user_model->getCurrentUser()->last_name; ?></a></li>
        <li><a href="<?php echo site_url('logout'); ?>">Logout</a></li>
      </ul>
      <?php else: ?>
      <ul class="nav navbar-nav pull-right">
        <li><a href="<?php echo site_url('register'); ?>">Register</a></li>
        <li><a href="<?php echo site_url('login'); ?>">Login</a></li>
      </ul>
      <?php endif; ?>
    </div>
  </div>
</div>
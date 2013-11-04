<h2>Have questions or comments?</h1>

<p class="text-muted">We value your feedback on how we can improve SeatShare to better serve your needs. The form below will send an email to our team. We try to answer every message promptly, but may not be able to give an individual response.</p>

<?php echo form_open('', array('role'=>'form', 'class' => 'form-horizontal')); ?>

<?php echo (validation_errors()) ? '<div class="alert alert-danger">' . validation_errors() . '</div>' : ''; ?>

<?php echo (isset($sent)) ? '<div class="alert alert-success">Your message has been sent!</div>' : ''; ?>

<?php echo form_fieldset('Contact Us'); ?>
<div class="form-group">
    <?php echo form_label('Your Name', 'name', array('class'=>'col-md-3 control-label')); ?>
    <div class="col-md-9">
        <?php echo form_input(array('name'=>'name', 'class'=>'form-control', 'placeholder'=>'John Doe', 'value'=>$this->input->post('name'))); ?>
    </div>
</div>
<div class="form-group">
    <?php echo form_label('Email', 'email', array('class'=>'col-md-3 control-label')); ?>
    <div class="col-md-9">
        <?php echo form_input(array('name'=>'email', 'class'=>'form-control', 'placeholder'=>'someone@example.org', 'value'=>$this->input->post('email'))); ?>
    </div>
</div>
<div class="form-group">
    <?php echo form_label('Message', 'message', array('class'=>'col-md-3 control-label')); ?>
    <div class="col-md-9">
        <?php echo form_textarea(array('name'=>'message', 'class'=>'form-control', 'placeholder'=>'', 'value'=>$this->input->post('message'))); ?>
    </div>
</div>

<div style="display:none;">
    This field is left blank on purpose. :)
    <input type="text" name="url" value="" />
</div>

<?php echo form_fieldset_close(); ?>

<div class="row">
    <div class="col-md-12">
        <p class="text-right">
            <?php echo form_submit(array('value'=>'Send Message', 'class'=>'btn btn-primary')); ?>
        </p>
    </div>
</div>
<?php echo form_close(); ?>

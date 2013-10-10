 <p><?php echo $recipient->first_name; ?>,</p>

<p>We received a request to reset your password on <a href="<?php echo site_url('/'); ?>"><?php echo $this->config->item('application_name'); ?></a>. To continue, please click the link below.</p>

<dl> 
	<dt>Reset My Password</dt>
	<dd><a href="<?php echo site_url('login/forgot_password/' . $recipient->activation_key); ?>"><?php echo site_url('login/forgot_password/' . $recipient->activation_key); ?></a></dd>
</dl>

<p>If you did make this request, you can delete this message.</p>

<p>Thank you!</p>
 
<p>
	---<br />
	<a href="<?php echo site_url('/'); ?>"><?php echo $this->config->item('application_name'); ?></a>
</p>
<p><?php echo $recipient->first_name; ?>,</p>

<p>We received a request to reset your password on <a href="<?php echo site_url('/'); ?>"><?php echo $this->config->item('application_name'); ?></a>. To continue, please click the link below.</p>

<table>
	<tr>
		<th style="width:150px">Reset My Password</th>
		<td><a href="<?php echo site_url('login/forgot_password/' . $recipient->activation_key); ?>"><?php echo site_url('login/forgot_password/' . $recipient->activation_key); ?></a></td>
	</tr>
</table>

<p>If you did not make this request, you can delete this message.</p>

<p>Thank you!</p>

<p>
	---<br />
	<a href="<?php echo site_url('/'); ?>"><?php echo $this->config->item('application_name'); ?></a>
</p>
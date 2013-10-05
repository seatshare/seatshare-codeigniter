<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_Model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('group_model');
	}

	public function sendInvite($email='') {
		$group = $this->group_model->getCurrentGroup();
		$user = $this->user_model->getCurrentUser();
		if (!$email || !is_object($group) || !$group->group_id) {
			return false;
		}

		$data['group'] = $group;
		$data['user'] = $user;
		$message = $this->load->view('emails/invite', $data, true);
		$subject = 'You have been invited to join ' . $group->group;

		$this->sendEmail($email, $subject, $message, $user);
	}

	public function sendRequest($recipient, $ticket, $personalized) {
		$group = $this->group_model->getCurrentGroup();
		$user = $this->user_model->getCurrentUser();
		if (!$recipient->email || !is_object($group) || !$group->group_id) {
			return false;
		}

		$data['recipient'] = $recipient;
		$data['group'] = $group;
		$data['ticket'] = $ticket;
		$data['user'] = $user;
		$data['personalized'] = $personalized;
		$message = $this->load->view('emails/request', $data, true);
		$subject = $user->first_name . ' has requested your tikets via ' . $group->group;

		$this->sendEmail($recipient->email, $subject, $message, $user);
	}

	public function sendEmail($to, $subject, $message, $from) {
		$this->load->library('email');

		// Outbound email settings
		if (file_exists(APPPATH . 'config/email.php')) {
			require (APPPATH . 'config/email.php');
			$this->email->initialize($config);
		}

		if (!$to || !is_object($from) || !$from->email || !$subject || !$message) {
			return false;
		}

		$this->email->from('no-reply@' . $_SERVER['HTTP_HOST'], $this->config->item('application_name'));
		$this->email->reply_to($from->email, $from->first_name . ' ' . $from->last_name);
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);

		return $this->email->send();
	}

}
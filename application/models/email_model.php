<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_Model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('group_model');
	}

	public function sendInvite($email='', $invitation_code='') {
		$group = $this->group_model->getCurrentGroup();
		$user = $this->user_model->getCurrentUser();
		if (!$email || !is_object($group) || !$invitation_code || !$group->group_id) {
			return false;
		}

		$data['group'] = $group;
		$data['invitation_code'] = $invitation_code;
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
		$data['event'] = $this->event_model->getEventById($ticket->event_id);
		$data['ticket'] = $ticket;
		$data['user'] = $user;
		$data['personalized'] = $personalized;
		$message = $this->load->view('emails/request', $data, true);
		$subject = $user->first_name . ' has requested your tickets via ' . $group->group;

		$this->sendEmail($recipient->email, $subject, $message, $user);
	}

	public function sendAssign($recipient, $ticket) {
		$group = $this->group_model->getCurrentGroup();
		$user = $this->user_model->getCurrentUser();
		if (!$recipient->email || !is_object($group) || !$group->group_id) {
			return false;
		}

		$data['recipient'] = $recipient;
		$data['group'] = $group;
		$data['event'] = $this->event_model->getEventById($ticket->event_id);
		$data['ticket'] = $ticket;
		$data['user'] = $user;
		$message = $this->load->view('emails/assign', $data, true);
		$subject = $user->first_name . ' has assigned you tickets via ' . $group->group;

		$this->sendEmail($recipient->email, $subject, $message, $user);
	}

	public function sendEmail($to, $subject, $message, $from) {
		$this->load->library('email');

		// Outbound email settings
		if (file_exists(APPPATH . 'config/email.php')) {
			$config['mailtype'] = 'html';
			require (APPPATH . 'config/email.php');
			$this->email->initialize($config);
		}

		if (!$to || !is_object($from) || !$from->email || !$subject || !$message) {
			return false;
		}

		$data['subject'] = $subject;
		$data['content'] = $message;
		$html_template = $this->load->view('emails/html_email_template', $data, true);

		$this->email->from('no-reply@' . $_SERVER['HTTP_HOST'], $this->config->item('application_name'));
		$this->email->reply_to($from->email, $from->first_name . ' ' . $from->last_name);
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($html_template);

		return $this->email->send();
	}

}
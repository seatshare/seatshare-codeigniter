<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_Model extends CI_Model {
	
	/**
	 * Constructor
	 **/
	public function __construct() {
		parent::__construct();
		$this->load->model('group_model');
		$this->load->model('entity_model');
		$this->load->library('email');
	}

	/**
	 * Send Invite
	 *
	 * @param string $email
	 * @param string $invitation_code
	 **/
	public function sendInvite($email='', $invitation_code='') {
		$group = $this->group_model->getCurrentGroup();
		$entity = $this->entity_model->getEntityByGroupId($group->group_id);
		$user = $this->user_model->getCurrentUser();
		if (!$email || !is_object($group) || !$invitation_code || !$group->group_id) {
			return false;
		}

		$data['group'] = $group;
		$data['entity'] = $entity;
		$data['invitation_code'] = $invitation_code;
		$data['user'] = $user;
		$message = $this->load->view('emails/invite', $data, true);
		$subject = 'You have been invited to join ' . $group->group;

		$this->sendEmail('InviteUser', $email, $subject, $message, $user);
	}

	/**
	 * Send Request
	 *
	 * @param object $recipient
	 * @param object $ticket
	 * @param string $personalized
	 **/
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

		$this->sendEmail('RequestTicket', $recipient->email, $subject, $message, $user);
	}

	/**
	 * Send Assign
	 *
	 * @param object $recipient
	 * @param object $ticket
	 **/
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

		$this->sendEmail('AssignTicket', $recipient->email, $subject, $message, $user);
	}

	/**
	 * Send Password Reset
	 *
	 * @param object $recipient
	 **/
	public function sendPasswordReset($recipient) {
		if (!is_object($recipient) || !$recipient->email) {
			return false;
		}

		$data['recipient'] = $recipient;
		$message = $this->load->view('emails/password_reset', $data, true);
		$subject = 'Your password has been reset for  SeatShare';

		$this->sendEmail('PasswordReset', $recipient->email, $subject, $message, false);
	}

	/**
	 * Send Group Message
	 *
	 * @param array $recipients
	 * @param string $subject
	 * @param string $message
	 **/
	public function sendGroupMessage($recipients, $subject, $personalized) {
		$group = $this->group_model->getCurrentGroup();
		$user = $this->user_model->getCurrentUser();
		if (!is_array($recipients) || !count($recipients) || !$recipients[0]->email) {
			return false;
		}

		$subject = sprintf('[%s] %s', $group->group, $subject);
		foreach($recipients as $recipient) {
			$recipient_list[] = $recipient->first_name . ' ' . $recipient->last_name;
		}

		// Special email header for group messages
		$data['group_header'] = sprintf(
			'<h2>%s <span style="font-weight:normal;">from <a href="mailto:%s">%s %s</a></span></h2>',
			$group->group,
			$user->email,
			$user->first_name,
			$user->last_name
		);
		$data['group_header'] .= sprintf(
			'<p>Sent to %s</p>',
			implode(', ', $recipient_list)
		);
		
		$data['personalized'] = nl2br($personalized);
		$data['user'] = $user;
		$data['group'] = $group;

		foreach ($recipients as $recipient) {
			$data['recipient'] = $recipient;
			$message = $this->load->view('emails/group_message', $data, true);

			$this->sendEmail('GroupMessage', $recipient->email, $subject, $message, $user);
		}
	}

	/**
	 * Send Welcome
	 *
	 * @param object $recipient
	 */
	public function sendWelcome($recipient) {
		if (!is_object($recipient) || !$recipient->email) {
			return false;
		}

		$data['recipient'] = $recipient;
		$message = $this->load->view('emails/create_account', $data, true);
		$subject = 'Welcome to  SeatShare' . '!';

		$this->sendEmail('NewUser', $recipient->email, $subject, $message, false);
	}

	/**
	 * Send Weekly Reminder
	 *
	 * @param object $recipient
	 * @param object $group
	 * @param array $events
	 *
	 */
	public function sendWeeklyReminder($recipient, $group, $events) {
		if (!is_object($recipient) || !$recipient->email) {
			return false;
		}

		if (!count($events)) {
			return false;
		}

		// Break out each event by day of week
		foreach($events as $row) {
			$events_by_day[date('l', strtotime($row->start_time))][] = $row;
		}

		$subject = 'The week ahead for ' . $group->group;
		$data['days_of_week'] = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
		$data['group'] = $group;
		$data['events'] = $events_by_day;
		$data['recipient'] = $recipient;
		$data['footer'] = sprintf('Sent through <a href="%s">SeatShare</a> | <a href="%s">Email Preferences</a>', site_url('/'), site_url('groups/group/' . $group->group_id));
		$message = $this->load->view('emails/weekly_reminder', $data, true);
		$this->sendEmail('WeeklyReminder', $recipient->email, $subject, $message, false);
	}

	/**
	 * Send Daily Reminder
	 *
	 * @param object $recipient
	 * @param object $group
	 * @param array $events
	 *
	 */
	public function sendDailyReminder($recipient, $group, $events) {
		if (!is_object($recipient) || !$recipient->email) {
			return false;
		}

		if (!count($events)) {
			return false;
		}

		$subject = 'Today\'s events for ' . $group->group;
		$data['group'] = $group;
		$data['events'] = $events;
		$data['recipient'] = $recipient;
		$data['footer'] = sprintf('Sent through <a href="%s">SeatShare</a> | <a href="%s">Email Preferences</a>', site_url('/'), site_url('groups/group/' . $group->group_id));
		$message = $this->load->view('emails/daily_reminder', $data, true);
		$this->sendEmail('DailyReminder', $recipient->email, $subject, $message, false, $data);
	}

	/**
	 * Send Email
	 *
	 * @param string $type
	 * @param object $to
	 * @param string $subject
	 * @param string $message
	 * @param object $from
	 * @param array $data
	 **/
	public function sendEmail($type='', $to=null, $subject='', $message='', $from=null, $data=array()) {

		// Clear previous message attributes
		$this->email->clear();

		// Outbound email settings
		if (file_exists(APPPATH . 'config/email.php')) {
			$config['mailtype'] = 'html';
			require (APPPATH . 'config/email.php');
			$this->email->initialize($config);
		}

		if (!$to || !$subject || !$message) {
			return false;
		}

		$data['subject'] = $subject;
		$data['content'] = $message;
		$html_template = $this->load->view('emails/html_email_template', $data, true);

		$this->email->from('no-reply@' . $this->config->item('application_domain'), 'SeatShare');
		if (is_object($from) && $from->email) {
			$this->email->reply_to($from->email, $from->first_name . ' ' . $from->last_name);
		}
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($html_template);

		// Headers for Mandrill
		$this->email->set_header('X-MC-Tags', $type ? $type : 'General');
		$this->email->set_header('X-MC-Subaccount', 'SeatShare');
		$this->email->set_header('X-MC-SigningDomain', $this->config->item('application_domain'));

		return $this->email->send();
	}

	/**
	 * Send Contact Email
	 *
	 * @param string $subject
	 * @param string $message
	 * @param string $name
	 * @param string $email
	 * @param array $data
	 */
	public function sendContactEmail($subject='', $message='', $name='', $email='', $data=array()) {

		// Clear previous message attributes
		$this->email->clear();

		// Outbound email settings
		if (file_exists(APPPATH . 'config/email.php')) {
			$config['mailtype'] = 'html';
			require (APPPATH . 'config/email.php');
			$this->email->initialize($config);
		}

		if (!$subject || !$message || !$name || !$email) {
			return false;
		}

		// For easier filtering
		$subject = sprintf('[SeatShare] %s', $subject);

		$data['header'] = sprintf('<div style="padding:1.5em;"><strong>From:</strong> %s &lt;%s&gt;<br /><strong>Subject:</strong> %s</div>', $name, $email, $subject);
		$data['subject'] = $subject;
		$data['content'] = $message;
		$html_template = $this->load->view('emails/html_email_template', $data, true);

		$this->email->to($this->config->item('application_email'));
		$this->email->from($email, $name);
		$this->email->subject($subject);
		$this->email->message($html_template);

		// Headers for Mandrill
		$this->email->set_header('X-MC-Tags', 'ContactForm');
		$this->email->set_header('X-MC-Subaccount', 'SeatShare');
		$this->email->set_header('X-MC-SigningDomain', $this->config->item('application_domain'));

		return $this->email->send();

	}

}
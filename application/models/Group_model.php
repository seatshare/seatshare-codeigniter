<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group_Model extends CI_Model {
	
	/**
	 * Constructor
	 **/
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Get Groups
	 */
	public function getGroups() {
		$this->db->select('g.group_id, g.group, n.entity, n.logo');
		$this->db->join('entities n', 'n.entity_id = g.entity_id', 'INNER');
		$this->db->where('g.status', 1);
		$this->db->group_by('group_id');
		$this->db->group_by('n.entity_id');
		$this->db->group_by('n.logo');
		$this->db->order_by('g.group', 'ASC');
		$query = $this->db->get('groups g');
		$groups = $query->result();
		return $groups;
	}

	/**
	 * Get By Group Id
	 *
	 * @param int $group_id
	 * @return object $group
	 **/
	public function getGroupById($group_id=0) {
		if (!$group_id) {
			return false;
		}
		$this->db->select('*');
		$this->db->where('group_id', $group_id);
		$this->db->where('status', 1);
		$query = $this->db->get('groups');
		$group = $query->row();
		return $group;
	}

	/**
	 * Get User Groups
	 *
	 * @return array $groups
	 **/
	public function getUserGroups($user_id=0) {

		if (!$user_id) {
			return false;
		}

		$this->db->select('g.group_id, g.group, n.entity, n.logo, gu.role');
		$this->db->join('groups g', 'gu.group_id = g.group_id', 'INNER');
		$this->db->join('entities n', 'n.entity_id = g.entity_id', 'INNER');
		$this->db->where('g.status', 1);
		$this->db->where('gu.user_id', $user_id);
		$this->db->group_by('g.group_id');
		$this->db->group_by('n.entity');
		$this->db->group_by('n.logo');
		$this->db->group_by('gu.role');
		$this->db->order_by('g.group', 'ASC');
		$query = $this->db->get('group_users gu');
		$groups = $query->result();
		return $groups;
	}

	/**
	 * Get User Groups As Array
	 *
	 * @return array $groups
	 **/
	public function getUserGroupsAsArray($user_id=0) {
		$result = $this->getUserGroups($user_id);
		$groups = array();
		foreach ($result as $row) {
			$groups[$row->group_id] = $row->group;
		}
		return $groups;
	}

	/**
	 * Get Group Users By Group Id
	 *
	 * @param int $group_id
	 * @return array $groups
	 **/
	public function getGroupUsersByGroupId($group_id=0) {
		$this->db->select('u.user_id, u.first_name, u.last_name, u.username, u.email, gu.role');
		$this->db->from('group_users gu');
		$this->db->join('users u', 'u.user_id = gu.user_id');
		$this->db->where('gu.group_id', $group_id);
		$this->db->order_by('u.last_name', 'ASC');
		$this->db->order_by('u.first_name', 'ASC');
		$query = $this->db->get();
		$result = $query->result();
		$group_users = array();
		foreach ($result as $row) {
			$group_users[$row->user_id] = $row;
			$group_users[$row->user_id]->name = $row->first_name . ' ' . substr($row->last_name,0,1) . '.';
		}
		return $group_users;
	}

	/**
	 * Get Current Group Users
	 *
	 * @return array $groups
	 **/
	public function getCurrentGroupUsers() {
		$group_id = $this->getCurrentGroupId();
		return $this->getGroupUsersByGroupId($group_id);
	}

	/**
	 * Get Group Administrator By Group Id
	 *
	 * @param int $group_id
	 * @return object $admin
	 **/
	public function getGroupAdministratorByGroupId($group_id=0) {
		$this->db->select('u.user_id, u.first_name, u.last_name, u.username, u.email');
		$this->db->join('users u', 'u.user_id = gu.user_id');
		$this->db->where('gu.group_id', $group_id);
		$this->db->where('gu.role', 'admin');
		$query = $this->db->get('group_users gu');
		$admin = $query->row();
		$admin->name = $admin->first_name . ' ' . substr($admin->last_name,0,1) . '.';
		return $admin;
	}

	/**
	 * Get Current Group
	 *
	 * @return object $group
	 **/
	public function getCurrentGroup() {
		return $this->getGroupById($this->getCurrentGroupId());
	}

	/**
	 * Get Current Group Id
	 *
	 * @return int $group_id
	 **/
	public function getCurrentGroupId() {
		$user_id = $this->user_model->getCurrentUser()->user_id;
		$current_group = $this->session->userdata('current_group') ? $this->session->userdata('current_group') : false;
		if (!$current_group) {
			$groups = $this->getUserGroupsAsArray($user_id);
			reset($groups);
			$group_id = $this->setCurrentGroup(key($groups));
			return $group_id;
		} else {
			return $current_group;
		}
	}

	/**
	 * Set Current Group
	 *
	 * @param int $group_id
	 * @return int $group_id
	 **/
	public function setCurrentGroup($group_id=0) {
		// Verify user can see this group
		$group = $this->getGroupById($group_id);
		if (!$this->checkAllowedGroupById($group_id)) {
			return false;
		}

		$this->session->set_userdata('current_group', $group_id);
		return $group_id;
	}

	/**
	 * Get Current Group Users As Array
	 *
	 * @return array $group_users
	 **/
	public function getGroupUsersAsArray($group_id=0) {
		$group_users_objects = $this->getGroupUsersByGroupId($group_id);
		$group_users['0'] = 'Unassigned';
		foreach ($group_users_objects as $row) {
			$group_users[$row->user_id] = $row->name;
		}
		return $group_users;
	}

	/**
	 * Get Group By Invitation Code
	 *
	 * @param string $invitation_code
	 * @return object $group
	 **/
	public function getGroupByInvitationCode($invitation_code='') {
		// Lookup the group's primary invitation code
		$this->db->select('*');
		$this->db->where('invitation_code', trim($invitation_code));
		$this->db->where('status', 1);
		$query = $this->db->get('groups');
		$group = $query->row();
		if (is_object($group)) {
			return $group;
		}

		// Lookup the sent invitation codes
		$this->db->select('*');
		$this->db->where('invitation_code', trim($invitation_code));
		$this->db->where('status', 1);
		$query = $this->db->get('group_invitations');
		$invitation = $query->row();
		if (is_object($invitation)) {
			$this->db->select('*');
			$this->db->where('group_id', $invitation->group_id);
			$this->db->where('status', 1);
			$query = $this->db->get('groups');
			$group = $query->row();
			return $group;
		}
		return false;
	}

	/**
	 * Create Group
	 *
	 * @param array $group
	 **/
	public function createGroup($group=array(), $user_id=0) {

		if (!$user_id) {
			$user_id = $this->user_model->getCurrentUser()->user_id;
		}

		$record = new StdClass();
		$record->entity_id = $group['entity_id'];
		$record->group = $group['group'];
		$record->creator_id = $user_id;
		$record->invitation_code = $this->generateInvitationCode();
		$record->status = 1;
		$record->updated_ts = date('Y-m-d H:i:s',now());
		$record->inserted_ts = date('Y-m-d H:i:s',now());

		$this->db->insert('groups', $record);
		$group_id = $this->db->insert_id();

		// Join group just created, switch to it
		$this->db->insert('group_users', array(
			'user_id' => $user_id,
			'group_id' => $group_id,
			'role' => 'admin'
		));
		
		// Subscribe new user to reminders
		$this->db->insert('user_reminders', array(
			'user_id' => $user_id,
			'group_id' => $group_id,
			'reminder_type_id' => 1
		));
		$this->db->insert('user_reminders', array(
			'user_id' => $user_id,
			'group_id' => $group_id,
			'reminder_type_id' => 2
		));

		$this->setCurrentGroup($group_id);
	}

	/**
	 * Join Group
	 *
	 * @param int $group_id
	 **/
	public function joinGroup($group_id=0) {
		if (!$group_id) {
			return false;
		}

		$user = $this->user_model->getCurrentUser();

		// See if user is already a member
		$group_users = $this->getGroupUsersAsArray($group_id);
		if (in_array($user->user_id, array_keys($group_users))) {
			return false;
		}

		$this->db->insert('group_users', array(
			'user_id' => $user->user_id,
			'group_id' => $group_id,
			'role' => 'member'
		));

		// Subscribe new user to reminders
		$this->db->insert('user_reminders', array(
			'user_id' => $user->user_id,
			'group_id' => $group_id,
			'reminder_type_id' => 1
		));
		$this->db->insert('user_reminders', array(
			'user_id' => $user->user_id,
			'group_id' => $group_id,
			'reminder_type_id' => 2
		));

		// Switch to new group
		$this->setCurrentGroup($group_id);

		return true;
	}

	/**
	 * Expire Invitation Code
	 *
	 * @param string $invitation_code
	 * @return boolean 
	 **/
	public function exipireInvitationCode($invitation_code='') {
		$this->db->where('invitation_code', $invitation_code);
		$this->db->update('group_invitations', array('status'=>0));
		return true;
	}

	/**
	 * Leave Group
	 *
	 * @param int $group_id
	 **/
	public function leaveGroup($group_id=0) {
		$this->load->model('ticket_model');
		if (!$group_id) {
			return false;
		}
		
		$user = $this->user_model->getCurrentUser();

		// Only 'member' roles can leave.
		$this->db->where('role', 'member');
		$this->db->where('user_id', $user->user_id);
		$this->db->where('group_id', $group_id);
		$this->db->delete('group_users');
		if ($this->db->affected_rows() == 0) {
			return false;
		} else {
			// Remove owned tickets
			$this->db->select('*');
			$this->db->where('owner_id', $user->user_id);
			$this->db->where('group_id', $group_id);
			$query = $this->db->get('tickets');
			$tickets = $query->result();
			foreach ($tickets as $ticket) {
				$this->ticket_model->deleteTicket($ticket->ticket_id);
			}

			// Un-assign tickets
			$this->db->select('*');
			$this->db->where('user_id', $user->user_id);
			$this->db->where('group_id', $group_id);
			$query = $this->db->get('tickets');
			$tickets = $query->result();
			foreach ($tickets as $ticket) {
				$this->ticket_model->unassignTicket($ticket->ticket_id);
			}

			// Remove reminder subscriptions
			$this->updateReminders($user->user_id, $group_id, array());

			// If current group equals this one, unset it
			$this->session->unset_userdata('current_group');
			
			return true;
		}
	}

	/**
	 * Update Group
	 *
	 * @param array $group
	 * @return boolean
	 **/
	public function updateGroup($group=array()) {
		if (!is_array($group) || !$group['group_id']) {
			return false;
		}
		$record = new StdClass();
		$record->group = $group['group'];
		$this->db->where('group_id', $group['group_id']);
		$this->db->update('groups', $record);
		return true;
	}

	/**
	 * Reset Invitation Code
	 *
	 * @param int $group_id
	 * @return boolean
	 **/
	public function resetInvitationCode($group_id=0) {
		if (!$group_id) {
			return false;
		}
		$record = new StdClass();
		$record->invitation_code = $this->generateInvitationCode();
		$this->db->where('group_id', $group_id);
		$this->db->update('groups', $record);
		return true;
	}

	/**
	 * Create and Send Invite
	 *
	 * @param string $email
	 * @return boollean
	 */
	public function createAndSendInvite($email='', $message='') {
		$invitation_code = $this->generateInvitationCode();

		$record = new StdClass();
		$record->user_id = $this->user_model->getCurrentUser()->user_id;
		$record->group_id = $this->group_model->getCurrentGroupId();
		$record->email = strtolower($email);
		$record->invitation_code = $invitation_code;
		$record->status = 1;
		$record->inserted_ts = date('Y-m-d H:i:s',now());
		$record->updated_ts = date('Y-m-d H:i:s',now());

		$this->db->insert('group_invitations', $record);
		$this->email_model->sendInvite($email, $invitation_code, $message);
		return true;
	}

	/**
	 * Check Recent Invites
	 *
	 * @param string $email
	 * @return boollean
	 */
	public function checkRecentInvite($email='', $group_id=0) {
		
		if (!$group_id) {
			$group_id = $this->group_model->getCurrentGroupId();
		}

		$this->db->where('email', $email);
		$this->db->where('group_id', $group_id);
		if ($this->db->dbdriver === 'mysql') {
			$this->db->where('inserted_ts >= DATE_SUB( NOW(),INTERVAL 3 DAY )');
		} else {
			$this->db->where('inserted_ts >= NOW() - INTERVAL \'3 days\' ');
		}
		$query = $this->db->get('group_invitations');
		return $query->row();
	}

	/**
	 * Get Weekly Events by Group Id
	 *
	 * @param int $group_id
	 */
	public function getWeeklyEventsByGroupId($group_id=0) {
		$this->db->select('*');
		$this->db->join('events e', 'e.entity_id = g.entity_id');
		$this->db->where('g.group_id', $group_id);
		if ($this->db->dbdriver === 'mysql') {
			$this->db->where('WEEK(e.start_time,1) = WEEK(NOW(),1)');
		} else {
			$this->db->where('date_trunc(\'week\', e.start_time) = date_trunc(\'week\', now())');
		}
		$this->db->order_by('start_time', 'ASC');
		$query = $this->db->get('groups g');
		$events = $query->result();
		return $events;
	}

	/**
	 * Get Daily Events by Group Id
	 *
	 * @param int $group_id
	 */
	public function getDailyEventsByGroupId($group_id=0) {
		$this->db->select('*');
		$this->db->join('events e', 'e.entity_id = g.entity_id');
		$this->db->where('g.group_id', $group_id);
		if ($this->db->dbdriver === 'mysql') {
			$this->db->where('DATE(e.start_time) = DATE(NOW())');
		} else {
			$this->db->where('date_trunc(\'day\', e.start_time) = date_trunc(\'day\', now())');
		}
		$this->db->order_by('start_time', 'ASC');
		$query = $this->db->get('groups g');
		$events = $query->result();
		return $events;
	}

	/**
	 * Send Weekly Reminders By Group Id
	 *
	 * @param int $group_id
	 */
	public function sendWeeklyRemindersByGroupId($group_id=0) {
		$count = 0;
		$group = $this->getGroupById($group_id);
		$events = $this->getWeeklyEventsByGroupId($group_id);
		if (!count($events)) {
			return;
		}
		$users = $this->getReminderSubscribersByGroupId('weekly', $group_id);
		foreach ($users as $row) {
			$user = $this->user_model->getUserById($row->user_id);
			foreach ($events as &$event) {
				$event->ticketStatus = $this->ticket_model->getTicketStatusByEventId($event->event_id, $group_id, $row->user_id);
				$event->tickets = $this->ticket_model->getTicketsByEventId($event->event_id);
			}
			$this->email_model->sendWeeklyReminder($user, $group, $events);
			$this->logReminder(1, $user, $group, $events);
			sleep(3);
			$count++;
		}
		return $count;
	}

	/**
	 * Send Daily Reminders By Group Id
	 *
	 * @param int $group_id
	 */
	public function sendDailyRemindersByGroupId($group_id=0) {
		$count = 0;
		$group = $this->getGroupById($group_id);
		$events = $this->getDailyEventsByGroupId($group_id);
		if (!count($events)) {
			return;
		}
		$users = $this->getReminderSubscribersByGroupId('daily', $group_id);
		foreach ($users as $row) {
			$user = $this->user_model->getUserById($row->user_id);
			foreach ($events as &$event) {
				$event->ticketStatus = $this->ticket_model->getTicketStatusByEventId($event->event_id, $group_id, $row->user_id);
				$event->tickets = $this->ticket_model->getTicketsByEventId($event->event_id);
			}
			$status = $this->email_model->sendDailyReminder($user, $group, $events);
			$this->logReminder(2, $user, $group, $events);
			sleep(3);
			$count++;
		}
		return $count;
	}

	/**
	 * Get Reminder Types
	 */
	public function getReminderTypes() {
		$this->db->select('*');
		$query = $this->db->get('reminder_types');
		return $query->result();
	}

	/**
	 * Get Reminders By User Id
	 *
	 * @param int $user_id
	 * @param int $group_id
	 */
	public function getRemindersByUserId($user_id=0, $group_id=0) {
		$this->db->select('*');
		$this->db->where('user_id', $user_id);
		$this->db->where('group_id', $group_id);
		$query = $this->db->get('user_reminders');
		return $query->result();
	}

	/**
	 * Update Reminders
	 *
	 * @param int $user_id
	 * @param int $group_id
	 * @param array $reminders
	 * @return boolean
	 */
	public function updateReminders($user_id=0, $group_id=0, $reminders=array()) {

		// Delete existing settings
		$this->db->where('user_id', $user_id);
		$this->db->where('group_id', $group_id);
		$this->db->delete('user_reminders');

		// Add new settings
		foreach ($reminders as $reminder) {
			$record = new StdClass();
			$record->user_id = $user_id;
			$record->group_id = $group_id;
			$record->reminder_type_id = $reminder;
			$this->db->insert('user_reminders', $record);
		}

		return true;
	}

	/**
	 * Log Sent Reminder
	 */
	public function logReminder($reminder_type_id=0, $user, $group, $events=array()) {
  		$record = new StdClass();
  		$record->reminder_type_id = $reminder_type_id;
  		$record->user_id = $user->user_id;
  		$record->entry = json_encode(array(
  			'user' => $user,
  			'group' => $group,
  			'events' => $events
  		));
  		$record->inserted_ts =  date('Y-m-d H:i:s',now());
  		$this->db->insert('reminders', $record);
	}

	/* Private Metods */

	/**
	 * Check Allowed Group By Id
	 *
	 * @param int $group_id
	 * @return boolean
	 **/
	public function checkAllowedGroupById($group_id=0) {
		$group_users = $this->getGroupUsersByGroupId($group_id);
		foreach ($group_users as $user) {
			if ($this->user_model->getCurrentUser()->user_id == $user->user_id) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Generate Invitation Code
	 **/
	private function generateInvitationCode() {
		    $characters = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';
			$randomString = '';
			for ($i = 0; $i < 16; $i++) {
				$randomString .= $characters[rand(0, strlen($characters) - 1)];
			}
			return $randomString;
	}

	/**
	 * Get Reminder Subscribers by Group Id
	 */
	private function getReminderSubscribersByGroupId($type='', $group_id=0) {
		$this->db->select('*');
		$this->db->where('ur.group_id', $group_id);
		$this->db->join('reminder_types rt', 'rt.reminder_type_id = ur.reminder_type_id');
		$this->db->where('reminder_type', $type);
		$query = $this->db->get('user_reminders ur');
		return $query->result();
	}
}
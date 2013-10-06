<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group_Model extends CI_Model {
	
	/**
	 * Constructor
	 **/
	public function __construct() {
		parent::__construct();
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
		if (!$this->checkAllowedGroupById($group_id)) {
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
	public function getUserGroups() {
		$this->db->select('g.group_id, g.group, n.entity, n.logo, gu.role');
		$this->db->join('groups g', 'gu.group_id = g.group_id', 'INNER');
		$this->db->join('entities n', 'n.entity_id = g.entity_id', 'INNER');
		$this->db->where('g.status', 1);
		$this->db->where('gu.user_id', $this->user_model->getCurrentUser()->user_id);
		$this->db->group_by('group_id');
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
	public function getUserGroupsAsArray() {
		$result = $this->getUserGroups();
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
		$group_users = $query->result();
		return $group_users;
	}

	/**
	 * Get Current Group Users
	 *
	 * @return array $groups
	 **/
	public function getCurrentGroupUsers() {
		$group_id = $this->getCurrentGroupId();
		$result = $this->getGroupUsersByGroupId($group_id);
		$group_users = array();
		foreach ($result as $row) {
			$group_users[$row->user_id] = $row;
			$group_users[$row->user_id]->name = $row->first_name . ' ' . substr($row->last_name,0,1) . '.';
		}
		return $group_users;
	}

	/**
	 * Get Current Group Administrator
	 *
	 * @return object $admin
	 **/
	public function getCurrentGroupAdministrator() {
		$this->db->select('u.user_id, u.first_name, u.last_name, u.username, u.email');
		$this->db->join('users u', 'u.user_id = gu.user_id');
		$this->db->where('gu.group_id', $this->getCurrentGroupId());
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
		$group_id = $this->getCurrentGroupId();
		$this->db->select('*');
		$this->db->where('group_id', $group_id);
		$this->db->where('status', 1);
		$query = $this->db->get('groups');
		$group = $query->row();
		return $group;
	}

	/**
	 * Get Current Group Id
	 *
	 * @return int $group_id
	 **/
	public function getCurrentGroupId() {
		$current_group = $this->session->userdata('current_group') ? $this->session->userdata('current_group') : false;
		if (!$current_group) {
			$groups = $this->getUserGroupsAsArray();
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
	public function getCurrentGroupUsersAsArray() {
		$group_users_objects = $this->getCurrentGroupUsers();
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
		$this->db->select('*');
		$this->db->where('invitation_code', trim($invitation_code));
		$query = $this->db->get('groups');
		$group = $query->row();
		return $group;
	}

	/**
	 * Create Group
	 *
	 * @param array $group
	 **/
	public function createGroup($group=array()) {
		$record = new StdClass();
		$record->entity_id = $group['entity_id'];
		$record->group = $group['group'];
		$record->creator_id = $this->user_model->getCurrentUser()->user_id;
		$record->invitation_code = $this->generateInvitationCode();
		$record->status = 1;
		$record->inserted_ts = date('Y-m-d h:i:s');

		$this->db->insert('groups', $record);
		$group_id = $this->db->insert_id();

		// Join group just created, switch to it
		$this->db->insert('group_users', array(
			'user_id' => $this->user_model->getCurrentUser()->user_id,
			'group_id' => $group_id,
			'role' => 'admin'
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
		$this->db->insert('group_users', array(
			'user_id' => $this->user_model->getCurrentUser()->user_id,
			'group_id' => $group_id,
			'role' => 'member'
		));
		$this->setCurrentGroup($group_id);
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
		// Only 'member' roles can leave.
		$this->db->where('role', 'member');
		$this->db->where('user_id', $this->user_model->getCurrentUser()->user_id);
		$this->db->where('group_id', $group_id);
		$this->db->delete('group_users');
		if ($this->db->affected_rows() == 0) {
			return false;
		} else {
			// Remove owned tickets
			$this->db->select('*');
			$this->db->where('owner_id', $this->user_model->getCurrentUser()->user_id);
			$this->db->where('group_id', $group_id);
			$query = $this->db->get('tickets');
			$tickets = $query->result();
			foreach ($tickets as $ticket) {
				$this->ticket_model->deleteTicket($ticket->ticket_id);
			}

			// Un-assign tickets
			$this->db->select('*');
			$this->db->where('user_id', $this->user_model->getCurrentUser()->user_id);
			$this->db->where('group_id', $group_id);
			$query = $this->db->get('tickets');
			$tickets = $query->result();
			foreach ($tickets as $ticket) {
				$this->ticket_model->unassignTicket($ticket->ticket_id);
			}

			// If current group equals this one, unset it
			$this->session->unset_userdata('current_group');
			
			return true;
		}
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

}
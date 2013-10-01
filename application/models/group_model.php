<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group_Model extends CI_Model {
	
	/**
	 * Constructor
	 **/
	public function __construct() {
		parent::__construct();
	}

	public function getUserGroups() {
		$this->db->select('g.group_id, g.group');
		$this->db->join('groups g', 'gu.group_id = g.group_id', 'INNER');
		$this->db->where('g.status', 1);
		$this->db->where('gu.user_id', $this->user_model->getCurrentUser()->user_id);
		$this->db->group_by('group_id');
		$query = $this->db->get('group_users gu');
		$result = $query->result();
		$groups = array();
		foreach ($result as $row) {
			$groups[$row->group_id] = $row->group;
		}
		return $groups;
	}

	public function getCurrentGroupUsers() {
		$this->db->select('u.user_id, u.first_name, u.last_name, u.username, u.email');
		$this->db->from('group_users gu');
		$this->db->join('users u', 'u.user_id = gu.user_id');
		$this->db->where('gu.group_id', $this->getCurrentGroupId());
		$query = $this->db->get();
		$result = $query->result();
		$users = array();
		foreach ($result as $row) {
			$users[$row->user_id] = $row;
			$users[$row->user_id]->name = $row->first_name . ' ' . substr($row->last_name,0,1) . '.';
		}
		return $users;
	}

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

	public function getCurrentGroup() {
		$group_id = $this->getCurrentGroupId();
		$this->db->select('*');
		$this->db->where('group_id', $group_id);
		$this->db->where('status', 1);
		$query = $this->db->get('groups');
		$group = $query->row();
		return $group;
	}

	public function getCurrentGroupId() {
		$current_group = $this->session->userdata('current_group') ? $this->session->userdata('current_group') : false;
		if (!$current_group) {
			$groups = $this->getUserGroups();
			reset($groups);
			$group_id = $this->setCurrentGroup(key($groups));
			return $group_id;
		} else {
			return $current_group;
		}
	}

	public function setCurrentGroup($group_id=0) {
		$this->session->set_userdata('current_group', $group_id);
		return $group_id;
	}

	public function getCurrentGroupUsersAsArray() {
		$group_users_objects = $this->getCurrentGroupUsers();
		$group_users['0'] = 'Unassigned';
		foreach ($group_users_objects as $row) {
			$group_users[$row->user_id] = $row->name;
		}
		return $group_users;
	}

	public function getGroupByInvitationCode($invitation_code='') {
		$this->db->select('*');
		$this->db->where('invitation_code', trim($invitation_code));
		$query = $this->db->get('groups');
		$group = $query->row();
		return $group;
	}

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
		$this->setCurrentGroup($group_id);
		$this->db->insert('group_users', array(
			'user_id' => $this->user_model->getCurrentUser()->user_id,
			'group_id' => $group_id,
			'role' => 'admin'
		));
	}

	public function joinGroup($group_id=0) {
		if (!$group_id) {
			return false;
		}
		$this->setCurrentGroup($group_id);
		$this->db->insert('group_users', array(
			'user_id' => $this->user_model->getCurrentUser()->user_id,
			'group_id' => $group_id,
			'role' => 'member'
		));
	}

	/* Private Metods */

	private function generateInvitationCode() {
		    $characters = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';
			$randomString = '';
			for ($i = 0; $i < 16; $i++) {
				$randomString .= $characters[rand(0, strlen($characters) - 1)];
			}
			return $randomString;
	}

}
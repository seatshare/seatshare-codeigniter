<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups_Controller extends MY_Controller {

	/**
	 * Constructor
	 **/
	public function __construct() {
		parent::__construct();
		if (!$this->user_model->isLoggedIn()) {
			$this->growl('You must be logged in.', 'error');
			redirect('login');
		}
		$this->load->library('form_validation');
		$this->load->model('entity_model');
		$this->load->model('email_model');
		$this->load->model('ticket_model');
	}

	/**
	 * Group List
	 **/
	public function index() {
		$groups = $this->group_model->getUserGroups();
		if (is_array($groups) && count($groups)) {
			$data['groups'] = $groups;
			$data['title'] = 'Groups';
			$this->load->view('groups/groups', $data);
		} else {
			$data['title'] = 'Welcome!';
			$this->load->view('groups/welcome', $data);
		}
	}

	/**
	 * Switch Groups
	 *
	 * @param int $group_id
	 **/
	public function switch_groups($group_id=0) {
		if (!$group_id) {
			$this->growl('Could not switch to specified group.', 'error');
			redirect('dashboard');
		}

		$this->group_model->setCurrentGroup($group_id);
		redirect('dashboard');
	}

	/**
	 * Group Detail
	 *
	 * @param int $group_id
	 **/
	public function group($group_id=0) {
		$group = $this->group_model->getGroupById($group_id);
		if (!is_object($group) || !$group->group_id) {
			$this->growl('Could not load specified group.', 'error');
			redirect('groups');
		}
		$data['title'] = $group->group;
		$this->load->view('groups/group_detail', $data);
	}

	/**
	 * Create Group
	 **/
	public function create() {
		$this->layout = 'two_column';
		if ($this->input->post()) {
			$this->form_validation->set_rules('group', 'Group Name', 'required|max_length[50]|min_length[4]');
			if ($this->form_validation->run() == true) {

				// Current group is automatically switched to new group
				$this->group_model->createGroup(array(
					'group' => $this->input->post('group'),
					'entity_id' => $this->input->post('entity_id')
				));
				$this->growl('Group created!');
				redirect('dashboard');
			}
		}

		$data['entities'] = $this->entity_model->getEntitiesAsArray();
		$data['title'] = 'Create a Group';
		$this->load->view('groups/create_group', $data);
	}

	/**
	 * Join Group
	 **/
	public function join() {
		$this->layout = 'two_column';

		if ($this->input->post()) {
			$this->form_validation->set_rules('invitation_code', 'Invitation Code', 'required|callback_inviteCodeLookup');

			if ($this->form_validation->run() == true) {
				$group = $this->group_model->getGroupByInvitationCode($this->input->post('invitation_code'));
				$this->group_model->joinGroup($group->group_id);
				$this->growl('You have joined the group!');
				redirect('dashboard');
			}
		}
		$data['title'] = 'Join Group';
		$this->load->view('groups/join_group', $data);
	}

	/**
	 * Leave Group
	 *
	 * @param int $group_id
	 **/
	public function leave($group_id=0) {
		$this->layout = 'two_column';
		$group = $this->group_model->getGroupById($group_id);
		if (!is_object($group) || !$group->group_id) {
			redirect('groups');
		}

		if ($this->input->post()) {
			$this->group_model->leaveGroup($group->group_id);
			$this->growl(sprintf('You have left "%s"', $group->group));
			redirect('groups');
		}
		$data['group'] = $group;
		$data['title'] = 'Leave Group';
		$this->load->view('groups/leave_group', $data);
	}

	/**
	 * Invite Code Lookup
	 *
	 * @param string $invite_code
	 **/
	public function inviteCodeLookup($invite_code='') {
		$this->form_validation->set_message('inviteCodeLookup', 'Your %s does not match an existing group.');
		$group = $this->group_model->getGroupByInvitationCode($invite_code);
		if (is_object($group) && $group->group_id) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Invite User
	 **/
	public function invite() {
		if ($this->input->post()) {
			$this->email_model->sendInvite($this->input->post('email'));
			$this->growl('Invitation sent!');
			redirect('dashboard');
		}
	
		$data['title'] = 'Invite';
		$this->load->view('groups/invite', $data);

	}

}
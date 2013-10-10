<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups_Controller extends MY_Controller {

	/**
	 * Constructor
	 **/
	public function __construct() {
		parent::__construct();
		$this->requireLogin();
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
		$entity = $this->entity_model->getEntityByGroupId($group->group_id);
		$group_users = $this->group_model->getGroupUsersByGroupId($group->group_id);
		$group_admin = $this->group_model->getGroupAdministratorByGroupId($group->group_id);

		$data['group'] = $group;
		$data['entity'] = $entity;
		$data['group_users'] = $group_users;
		$data['group_admin'] = $group_admin;
		$data['title'] = $group->group;
		$this->load->view('groups/view_group', $data);
	}

	/**
	 * Edit Group
	 *
	 * @param int $group_id
	 **/
	public function edit($group_id=0) {
		$group = $this->group_model->getGroupById($group_id);
		if (!is_object($group) || !$group->group_id) {
			$this->growl('Could not load specified group.', 'error');
			redirect('groups');
		}
		$group_admin = $this->group_model->getGroupAdministratorByGroupId($group->group_id);
		if ($this->user_model->getCurrentUser()->user_id != $group_admin->user_id) {
			$this->growl('Access denied', 'error');
			redirect('dashboard');
		}

		if ($this->input->post()) {
			$this->form_validation->set_rules('group', 'Group Name', 'required');
			if ($this->form_validation->run() != false) {
				$this->group_model->updateGroup(array(
					'group_id'=>$group->group_id,
					'group'=>$this->input->post('group'),
				));
				if ($this->input->post('reset_invitation_code')) {
					$this->group_model->resetInvitationCode($group->group_id);
				}
				$this->growl('Group updated!');
				redirect('groups/group/' . $group->group_id);
			}
		}

		$data['group'] = $group;
		$data['title'] = $group->group;
		$this->load->view('groups/edit_group', $data);
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
				$this->group_model->exipireInvitationCode($this->input->post('invitation_code'));
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
	 * Invite User
	 **/
	public function invite() {
		if ($this->input->post()) {
			$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
			if ($this->form_validation->run() != false) {
				$this->group_model->createAndSendInvite($this->input->post('email'));
				$this->growl('Invitation sent!');
			} else {
				$this->growl(form_error('email'), 'error');
			}
			redirect('dashboard');
		}
		$data['title'] = 'Invite';
		$this->load->view('groups/invite', $data);

	}

	/**
	 * Group Message
	 **/
	public function new_message() {
		$group = $this->group_model->getCurrentGroup();
		$group_users = $this->group_model->getGroupUsersByGroupId($group->group_id);

		if ($this->input->post()) {
			$this->form_validation->set_rules('subject', 'Subject', 'required');
			$this->form_validation->set_rules('message', 'Message', 'required');
			$this->form_validation->set_rules('recipients', 'Recipients', 'required');

			if ($this->form_validation->run() == true) {
				foreach ($this->input->post('recipients') as $user_id) {
					$recipients[] = $this->user_model->getUserById($user_id);
				}
				$subject = $this->input->post('subject');
				$message = $this->input->post('message');

				$this->email_model->sendGroupMessage($recipients, $subject, $message);
				$this->growl('Message sent!');
				redirect('dashboard');
			}
		}

		$data['group'] = $group;
		$data['group_users'] = $group_users;
		$data['title'] = 'New Group Message';
		$this->load->view('groups/new_message', $data);
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

}
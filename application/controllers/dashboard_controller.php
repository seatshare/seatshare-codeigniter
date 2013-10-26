<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_Controller extends MY_Controller {

	public $layout = 'two_column';

	/**
	 * Constructor
	 **/
	public function __construct() {
		parent::__construct();
		$this->requireLogin();
		$this->load->model('group_model');
		$this->load->model('event_model');
		$this->load->model('entity_model');
	}

	/**
	 * Welcome
	 **/
	public function index() {

		$group = $this->current_group;

		// No group associated, take to group page
		if (!is_object($group) || !$group->group_id) {
			redirect('groups');
		}

		// Sanity check to ensure a departed group is not still displayed
		if (!$this->group_model->getGroupById($group->group_id)) {
			redirect('groups');
		}

		$group->administrator = $this->group_model->getGroupAdministratorByGroupId($group->group_id);

		$data['group'] = $group;
		$data['entity'] = $this->entity_model->getEntityByCurrentGroup();
		$data['events'] = $this->event_model->getEvents(array(
			'after' => date('c', strtotime('+1 hour'))
		));
		$data['summary'] = array();
		$data['group_users'] = $this->group_model->getGroupUsersByGroupId($group->group_id);

		$data['title'] = 'Dashboard';
		$data['sidebar'] = $this->load->view('dashboard/_sidebar', $data, true);
		$this->load->view('dashboard/main', $data);
	}
}
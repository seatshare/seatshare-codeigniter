<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_Controller extends MY_Controller {

	public $layout = 'two_column';

	public function __construct() {
		parent::__construct();
		if (!$this->user_model->isLoggedIn()) {
			redirect('welcome');
		}
		$this->load->model('group_model');
		$this->load->model('event_model');
		$this->load->model('entity_model');
	}

	/**
	 * Welcome
	 **/
	public function index() {

		$group = $this->group_model->getCurrentGroup();
		error_log(print_r($group,true));
		// No group associated, take to group page
		if (!$group->group_id) {
			redirect('groups');
		}
		$group->administrator = $this->group_model->getCurrentGroupAdministrator();

		$data['group'] = $group;
		$data['entity'] = $this->entity_model->getEntityByCurrentGroup();
		$data['events'] = $this->event_model->getEvents(array(
			'after' => date('c', strtotime('+1 hour'))
		));
		$data['summary'] = array();
		$data['group_users'] = $this->group_model->getCurrentGroupUsers();

		$data['title'] = 'Dashboard';
		$data['sidebar'] = $this->load->view('dashboard/_sidebar', $data, true);
		$this->load->view('dashboard/main', $data);
	}
}
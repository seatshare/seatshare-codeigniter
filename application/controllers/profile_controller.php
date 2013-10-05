<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_Controller extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->layout = 'two_column';
		if (!$this->user_model->isLoggedIn()) {
			$this->growl('You must be logged in.', 'error');
		}
	}

	public function index() {
		$profile = $this->user_model->getCurrentUser();

		$data['profile'] = $profile;
		$data['title'] = 'View Profile';
		$this->load->view('profile/view_profile', $data);
	}

	public function edit() {
		$profile = $this->user_model->getCurrentUser();

		$data['profile'] = $profile;
		$data['title'] = 'View Profile';
		$this->load->view('profile/edit_profile', $data);
	}

	public function view($username='') {
		$profile = $this->user_model->getUserByUsername($username);
		if (!is_object($profile) || !$profile->user_id) {
			$this->growl('User not found.', 'error');
			redirect('dashboard');
		}

		$data['profile'] = $profile;
		$data['title'] = 'View Profile';
		$this->load->view('profile/view_profile', $data);
	}


}
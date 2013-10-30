<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_Controller extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->layout = 'two_column';
		$this->requireLogin();
		$this->load->library('form_validation');
	}

	public function index() {
		$profile = $this->current_user;

		$data['profile'] = $profile;
		$data['title'] = 'View Profile';
		$data['head'] = '<script>mixpanel.track("View own profile");</script>';
		$this->load->view('profile/view_profile', $data);
	}

	public function edit() {
		$profile = $this->user_model->getCurrentUser();

		if ($this->input->post()) {

			// Validate rules
			$this->form_validation->set_rules('first_name', 'First Name', 'required');
			$this->form_validation->set_rules('last_name', 'Last Name', 'required');
			if ($profile->username != $this->input->post('username')) {
				$this->form_validation->set_rules('username', 'Username', 'required|alpha_dash|is_unique[users.username]');
			}
			if ($profile->email != $this->input->post('email')) {
				$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
			}
			if ($this->input->post('password')) {
				$this->form_validation->set_rules('password', 'Password', 'required|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');
			}

			if ($this->form_validation->run() != false) {
				
				$record = new StdClass();
				$record->user_id = $profile->user_id;
				$record->first_name = $this->input->post('first_name');
				$record->last_name = $this->input->post('last_name');
				$record->email = strtolower($this->input->post('email'));
				$record->username = $this->input->post('username');
				$record->activation_key = '';

				$this->user_model->updateUser($record);
				if ($this->input->post('password')) {
					$this->user_model->updatePassword($profile->user_id, $this->input->post('password'));
				}
				// Grab it again
				$profile = $this->user_model->getCurrentUser();
			}

			$this->growl('Profile updated!');
		}

		$data['profile'] = $profile;
		$data['title'] = 'View Profile';
		$data['head'] = '<script>mixpanel.track("View profile edit");</script>';
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
		$data['head'] = '<script>mixpanel.track("View profile");</script>';
		$this->load->view('profile/view_profile', $data);
	}


}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_Controller extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->layout = 'two_column';
		if (!$this->user_model->isLoggedIn()) {
			$this->growl('You must be logged in.', 'error');
		}
		$this->load->library('form_validation');
	}

	public function index() {
		$profile = $this->user_model->getCurrentUser();

		$data['profile'] = $profile;
		$data['title'] = 'View Profile';
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

			$valid = $this->form_validation->run();
			if ($valid != false) {
				$this->user_model->updateUserFromPost();
				if ($this->input->post('password')) {
					$this->user_model->updatePasswordFromPost();
				}
				// Grab it again
				$profile = $this->user_model->getCurrentUser();
			}

			$this->growl('Profile updated!');
		}

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
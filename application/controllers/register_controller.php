<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register_Controller extends MY_Controller {

	/**
	 * Constructor
	 **/
	public function __construct() {
		parent::__construct();
		$this->layout = 'two_column';
		if ($this->user_model->isLoggedIn()) {
			$this->growl('You are already registered.', 'error');
			redirect('dashboard');
		}
		$this->load->library('form_validation');
	}

	/**
	 * Register User
	 **/
	public function index() {

		if ($this->input->post()) {

			// Validate rules
			$this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
			$this->form_validation->set_rules('password', 'Password', 'required|matches[password_confirm]');
			$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');

			if ($this->form_validation->run() != false) {
				$this->user_model->createNewUserFromPost();
				$this->user_model->login($this->input->post('username'), $this->input->post('password'));
				$this->growl('Your account has been created!');

				// If from an invitation email, redirect to accept it.
				if ($this->input->post('invitation_code') != '') {
					redirect('groups/join/?invitation_code=' . $this->input->post('invitation_code'));
				} else {
					redirect('groups');
				}
			}
		}

		$data['invitation_code'] = $this->input->get_post('invitation_code');
		$data['title'] = 'Register';
		$data['sidebar'] = $this->load->view('register/_group', $data, true);
		$this->load->view('register/new_user', $data);
	}

}
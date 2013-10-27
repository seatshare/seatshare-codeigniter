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
		$this->load->model('email_model');
		$this->load->library('form_validation');

		// MailChimp
		if ($this->config->item('mailchimp_api') && $this->config->item('mailchimp_list')) {
			require_once APPPATH . 'third_party/mailchimp.php';
			$this->mailchimp = new MailChimp($this->config->item('mailchimp_api'));
		} else {
			$this->mailchimp = null;
		}
	}

	/**
	 * Register User
	 **/
	public function index() {

		if ($this->input->post()) {

			// Spam honeypot field
			if ($this->input->post('url') != '') {
				return;
			}

			// Validate rules
			$this->form_validation->set_rules('first_name', 'First Name', 'required');
			$this->form_validation->set_rules('last_name', 'Last Name', 'required');
			$this->form_validation->set_rules('username', 'Username', 'required|alpha_dash|is_unique[users.username]');
			$this->form_validation->set_rules('password', 'Password', 'required|matches[password_confirm]');
			$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
			$this->form_validation->set_rules('tos', 'Terms of Service', 'callback_tos_agree');
			$this->form_validation->set_message('tos_agree', 'You must agree to the terms of service.');

			if ($this->form_validation->run() != false) {
				$insert_user_data = array(
					'username' => $this->input->post('username'),
					'password' => md5($this->input->post('password') . $this->config->item('encryption_key')),
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'email' => strtolower($this->input->post('email')),
					'status' => 1,
					'inserted_ts' => date('Y-m-d h:i:s')
				);
				$this->user_model->createNewUser($insert_user_data);
				$this->user_model->login($this->input->post('username'), $this->input->post('password'));
				$this->growl('Your account has been created!');

				// This should be available now post-login
				$profile = $this->user_model->getCurrentUser();

				// Newsletter Signup
				if (is_object($this->mailchimp) && $this->input->post('newsletter') == 'features') {
					$signup = $this->mailchimp->call('lists/subscribe', array(
						'id'                => $this->config->item('mailchimp_list'),
						'email'             => array('email'=>$profile->email),
						'merge_vars'        => array('FNAME'=>$profile->first_name, 'LNAME'=>$profile->last_name),
						'double_optin'      => false,
						'update_existing'   => true,
						'replace_interests' => false,
						'send_welcome'      => false,
					));
				}

				// Send a welcome email
				$this->email_model->sendWelcome($profile);

				// If from an invitation email, redirect to accept it.
				if ($this->input->post('invitation_code') != '') {
					redirect('groups/join/?invitation_code=' . $this->input->post('invitation_code'));
				} else {
					redirect('groups');
				}
			}
		}

		$data['invitation_code'] = $this->input->get_post('invitation_code');
		$data['head'] = sprintf('<meta name="description" content="Register for an account with %s to start managing your season tickets." />', $this->config->item('application_name'));
		$data['title'] = 'Register - ' . $this->config->item('application_name');
		$data['sidebar'] = $this->load->view('register/_group', $data, true);
		$this->load->view('register/new_user', $data);
	}


	/**
	 * TOS Agree
	 */
	public function tos_agree($input) {
		if ($input == true) {
			return true;
		} else {
			return false;
		}
	}

}
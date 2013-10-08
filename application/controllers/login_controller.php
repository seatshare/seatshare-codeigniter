<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_Controller extends MY_Controller {

	/**
	 * Login
	 **/
	public function index() {

		if ($this->user_model->isLoggedIn()) {
			redirect('dashboard');
		}

		if ($this->input->post('username') && $this->input->post('password')) {
			$status = $this->user_model->login(
				$this->input->post('username'),
				$this->input->post('password')
			);
			if ($status) {
				redirect('dashboard');
			} else {
				$this->growl('Login failed. Please try again.', 'error');
				redirect('login');
			}
		}

		$this->layout = 'login';
		$data['head'] = sprintf('<meta name="description" content="Sign in to %s to manage your tickets and groups." />', $this->config->item('application_name'));
		$data['title'] = 'User Login';
		$this->load->view('login/form', $data);
	}

	/**
	 * Logout
	 **/
	public function logout() {

		$this->session->sess_destroy();
		$this->user_model->logout();
		redirect('login');

	}

}
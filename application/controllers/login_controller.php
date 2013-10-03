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
		$this->load->view('login/form');
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
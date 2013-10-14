<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	/**
	 * Constructor
	 **/
	public function __construct()
	{
		parent::__construct();
		// Clean up CLI-based routes to use proper base_url
		if ($this->input->is_cli_request()) {
			$this->config->set_item('base_url', 'http://' . $this->config->item('application_domain') . '/');
			$this->layout = false;
		}
	}

	/**
	 * JSON Output
	 */
	public function echoJSON($object) {
		header('Content-type: application/json');
		print json_encode($object);
		exit;
	}

	/**
	 * Require Login
	 **/
	public function requireLogin() {
		if ($this->input->is_cli_request()) {
			return;
		}
		if (!$this->user_model->isLoggedIn()) {
			redirect('login/?return=' . urlencode($_SERVER['REQUEST_URI']));
		}
	}

	/**
	 * Growl
	 *
	 * @return string $message
	 * @param string $type 
	 **/
	public function growl($message, $type='') {
		if (!$type) {
			$type = 'info';
		}
		$this->session->set_flashdata($type, $message);
	}

}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public $current_user;
	public $current_group;

	/**
	 * Constructor
	 **/
	public function __construct()
	{
		parent::__construct();
		// Clean up CLI-based routes to use proper base_url
		if ($this->input->is_cli_request()) {
			$this->config->set_item('base_url', 'https://' . $this->config->item('application_domain') . '/');
			$this->layout = false;
		} elseif ($this->user_model->isLoggedIn()) {
			$this->current_user = $this->user_model->getCurrentUser();
			$this->current_group = $this->group_model->getCurrentGroup();
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
	 * Require SSL
	 */
	public function requireSSL() {
		if (ENVIRONMENT != 'production') {
			return;
		}
		$CI =& get_instance();
		if (!$CI->config->config['base_url']) {
			$fwd_protocol = $_SERVER['HTTP_X_FORWARDED_PROTO'] ? $_SERVER['HTTP_X_FORWARDED_PROTO'] : 'http';
			$CI->config->config['base_url'] = sprintf('%s://%s', $fwd_protocol, $_SERVER['HTTP_HOST']);
		}
        $CI->config->config['base_url'] = str_replace('http://', 'https://', $CI->config->config['base_url']);
        if ($_SERVER['SERVER_PORT'] != 443) {
            redirect($CI->uri->uri_string());
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
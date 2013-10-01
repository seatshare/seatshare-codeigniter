<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	/**
	 * Constructor
	 **/
	public function __construct()
	{
		parent::__construct();
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
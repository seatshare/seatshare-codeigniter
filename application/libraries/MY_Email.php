<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Email extends CI_Email {

	/**
	 * Constructor
	 **/
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Set Header
	 *
	 * @param string $header
	 * @param string $value
	 **/
	public function set_header($header, $value){
		$this->_headers[$header] = $value;
	}

}
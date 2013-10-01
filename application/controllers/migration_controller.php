<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Controller extends MY_Controller {

	public function __construct() {
		parent::__construct();
		if (!$this->input->is_cli_request()) {
			die('Must run from command line.' . PHP_EOL);
		}
		$this->layout = false;
		$this->load->library('migration');
	}

	public function index() {
		if ( ! $this->migration->current()) {
			show_error($this->migration->error_string());
		}
	}

}
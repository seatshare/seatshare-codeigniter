<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_Controller extends MY_Controller {

	public $layout = false;

	/**
	 * Constructor
	 **/
	public function __construct() {
		parent::__construct();
		$this->load->model('api_model');
	}

	/**
	 * Index
	 **/
	public function index() {
		$this->echoJSON('ok');
	}

	/**
	 * Dashing API Endpoint
	 **/
	public function dashing($method='') {
		$this->requireValidAPIKey();
		switch ($method) {

			case 'user_count':
				$result = $this->api_model->userCount();
				$this->echoJSON($result);
				break;

			case 'group_count':
				$result = $this->api_model->groupCount();
				$this->echoJSON($result);

			case 'total_invites':
				$result = $this->api_model->totalInvites();
				$this->echoJSON($result);

			case 'accepted_invites':
				$result = $this->api_model->acceptedInvites();
				$this->echoJSON($result);

			case 'total_tickets':
				$result = $this->api_model->totalTickets();
				$this->echoJSON($result);

			case 'largest_groups':
				$result = $this->api_model->largestGroups();
				$this->echoJSON($result);

			default:
				$this->echoJSON('error');
		}
	}

	/* Private Methods */

	/**
	 * Require Valid API Key
	 */
	private function requireValidAPIKey() {
		$api_key = $this->input->get('key');
		if (!$this->api_model->validateAPIKey($api_key)) {
			header("HTTP/1.0 401 Unauthorized");
			$this->echoJSON('Invalid API key');
		}

	}

}
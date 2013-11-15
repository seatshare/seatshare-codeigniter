<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_Controller extends MY_Controller {

	public $layout = false;

	/**
	 * Constructor
	 **/
	public function __construct() {
		parent::__construct();
		$this->requireSSL();
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
		if ($this->input->get('days')) {
			$days = $this->input->get('days');
		} else {
			$days = 30;
		}
		switch ($method) {

			case 'user_count':
				$result = $this->api_model->userCount();
				$this->echoJSON($result);
				break;

			case 'group_count':
				$result = $this->api_model->groupCount();
				$this->echoJSON($result);
				break;

			case 'total_invites':
				$result = $this->api_model->totalInvites($days);
				$this->echoJSON($result);
				break;

			case 'accepted_invites':
				$result = $this->api_model->acceptedInvites($days);
				$this->echoJSON($result);
				break;

			case 'total_tickets':
				$result = $this->api_model->totalTickets();
				$this->echoJSON($result);
				break;

			case 'largest_groups':
				$result = $this->api_model->largestGroups();
				$this->echoJSON($result);
				break;

			case 'tickets_transferred':
				$result = $this->api_model->ticketsTransferred($days);
				$this->echoJSON($result);
				break;

			case 'tickets_unused':
				$result = $this->api_model->ticketsUnused($days);
				$this->echoJSON($result);
				break;

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
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events_Controller extends MY_Controller {

	/**
	 * Constructor
	 **/
	public function __construct() {
		parent::__construct();
		if (!$this->user_model->isLoggedIn()) {
			$this->growl('You must be logged in.', 'error');
			redirect('login');
		}
		$this->load->model('event_model');
		$this->load->model('entity_model');
	}

	/**
	 * Return to Dashboard
	 **/
	public function index() {
		redirect('dashboard');
	}

	/**
	 * Event Detail
	 *
	 * @param int $event_id
	 **/
	public function event($event_id=0) {
		$entity = $this->entity_model->getEntityByCurrentGroup();
		$event = $this->event_model->getEventById($event_id);
		$tickets = $this->ticket_model->getTicketsByEventId($event_id);

		if (!is_object($event) || !$event->event_id) {
			$this->growl('Could not find specified event in group.', 'error');
			redirect('dashboard');
		}

		$data['entity'] = $entity;
		$data['event'] = $event;
		$data['tickets'] = $tickets;
		$data['title'] = $event->event;
		$this->load->view('events/event_detail', $data);
		$this->load->view('events/tickets', $data);
	}

}
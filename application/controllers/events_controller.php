<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events_Controller extends MY_Controller {

	/**
	 * Constructor
	 **/
	public function __construct() {
		parent::__construct();
		$this->requireLogin();
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
		$group_id = $this->group_model->getCurrentGroup()->group_id;

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
	}

	/**
	 * AJAX Calendar Data Source
	 **/
	public function ajax_calendar_data_source() {
		$event_objects = $this->event_model->getEvents();
		if (!is_array($event_objects)) {
			$this->echoJSON(array());
			return false;
		}
		foreach ($event_objects as $i => $event) {
			$events[$i] = $event;
			$events[$i]->date = date('Y-m-d', strtotime($event->start_time));
			$events[$i]->title = $event->event;
			$events[$i]->url = site_url('events/event/' . $event->event_id);
		}
		$this->echoJSON($events);
	}

}
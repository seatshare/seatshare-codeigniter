<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event_Model extends CI_Model {
	
	/**
	 * Constructor
	 **/
	public function __construct() {
		parent::__construct();
		$this->load->model('ticket_model');
	}

	/**
	 * Index
	 **/
	public function getEventById($event_id=0) {
		$group_id = $this->group_model->getCurrentGroupId();
		$this->db->select('e.*');
		$this->db->join('entities n', 'e.entity_id = n.entity_id');
		$this->db->join('groups g', 'n.entity_id = g.entity_id');
		$this->db->where('e.event_id', $event_id);
		$this->db->where('g.group_id', $group_id);
		$this->db->order_by('e.start_time', 'ASC');
		$query = $this->db->get('events e');
		$row = $query->row();
		$row->ticketStatus = $this->ticket_model->getTicketStatusByEventId($row->event_id);
		return $row;
	}

	/**
	 * Get Events
	 */
	public function getEvents($options=array()) {

		$group_id = $this->group_model->getCurrentGroupId();
		$this->db->select('e.*');
		$this->db->join('entities n', 'e.entity_id = n.entity_id');
		$this->db->join('groups g', 'n.entity_id = g.entity_id');
		$this->db->where('g.group_id', $group_id);
		$this->db->order_by('e.start_time', 'ASC');
		$query = $this->db->get('events e');
		$results = $query->result();
		foreach ($results as $i => $row) {
			$row->ticketStatus = $this->ticket_model->getTicketStatusByEventId($row->event_id);
			$events[$i] = $row;
		}
		return $events;
	}

	public function getEventsAsArray($options=array()) {
		$event_objects = $this->getEvents($options);
		$events = array();
		foreach ($event_objects as $row) {
			$events[] = (array) $row;
		}
		return $events;
	}

}
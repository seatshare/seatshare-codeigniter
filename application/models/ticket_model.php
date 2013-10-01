<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ticket_Model extends CI_Model {
	
	/**
	 * Constructor
	 **/
	public function __construct() {
		parent::__construct();
		$this->load->model('group_model');
	}
	
	/**
	 * Get Ticket Status By Event Id
	 *
	 * @param int $event_id
	 **/
	public function getTicketStatusByEventId($event_id=0) {

		$this->db->select('*');
		$this->db->where('event_id', $event_id);
		$this->db->where('user_id', $this->user_model->getCurrentUser()->user_id);
		$this->db->where('group_id', $this->group_model->getCurrentGroupId());
		$tickets_user = $this->db->get('tickets');

		$this->db->select('*');
		$this->db->where('event_id', $event_id);
		$this->db->where('group_id', $this->group_model->getCurrentGroupId());
		$tickets_group = $this->db->get('tickets');

		$this->db->select('*');
		$this->db->where('event_id', $event_id);
		$this->db->where('user_id', '');
		$this->db->where('group_id', $this->group_model->getCurrentGroupId());
		$tickets_available = $this->db->get('tickets');

		$return = array(
			'tickets_user' => (int) $tickets_user->num_rows(),
			'tickets_group' => (int) $tickets_group->num_rows(),
			'tickets_available' => (int) $tickets_available->num_rows()
		);
		$tickets_user->free_result();
		$tickets_group->free_result();
		$tickets_available->free_result();
		return $return;
	}

	/**
	 * Get Tickets By Event Id
	 *
	 * @param int $event_id
	 */
	public function getTicketsByEventId($event_id=0) {

		$group_users = $this->group_model->getCurrentGroupUsers();

		$this->db->select('*');
		$this->db->where('event_id', $event_id);
		$this->db->where('group_id', $this->group_model->getCurrentGroupId());
		$this->db->order_by('section', 'ASC');
		$this->db->order_by('row', 'ASC');
		$this->db->order_by('seat', 'ASC');
		$query = $this->db->get('tickets');
		$result = $query->result();
		$tickets = array();
		foreach ($result as $i => $row) {
			$tickets[$i] = $row;
			$tickets[$i]->owner = $group_users[$row->owner_id];
			$tickets[$i]->assigned = ($row->user_id) ? $group_users[$row->user_id] : 0;
		}
		return $tickets;
	}

	/**
	 * Get Ticket By Id
	 *
	 * @param int $ticket_id
	 **/
	public function getTicketById($ticket_id=0) {

		$group_users = $this->group_model->getCurrentGroupUsers();

		$this->db->select('*');
		$this->db->where('ticket_id', $ticket_id);
		$this->db->where('group_id', $this->group_model->getCurrentGroupId());
		$this->db->order_by('section', 'ASC');
		$this->db->order_by('row', 'ASC');
		$this->db->order_by('seat', 'ASC');
		$query = $this->db->get('tickets');
		$ticket = $query->row();
		$ticket->owner = $group_users[$ticket->owner_id];
		$ticket->assigned = ($ticket->user_id) ? $group_users[$ticket->user_id] : 0;
		return $ticket;
	}

	public function getTicketHistoryById($ticket_id=0) {
		$ticket = $this->getTicketById($ticket_id);

		$this->db->select('*');
		$this->db->where('ticket_id', $ticket_id);
		$this->db->where('group_id', $this->group_model->getCurrentGroupId());
		$this->db->order_by('inserted_ts', 'DESC');
		$query = $this->db->get('ticket_history');

		$ticket_history = $query->result();
		return $ticket_history;
	}

	/**
	 * Create Ticket
	 *
	 * @param array $ticket
	 **/
	public function createTicket($ticket=array()){
		$record = new StdClass();
		$record->group_id = $this->group_model->getCurrentGroupId();
		$record->event_id = $ticket['event_id'];
		$record->section = $ticket['section'];
		$record->row = $ticket['row'];
		$record->seat = $ticket['seat'];
		$record->cost = $ticket['cost'];
		$record->owner_id = $this->user_model->getCurrentUser()->user_id;
		$record->user_id = $ticket['user_id'];
		$record->inserted_ts = date('c');

		$this->db->insert('tickets', $record);
		return $this->db->insert_id();
	}

	/**
	 * Update Ticket
	 *
	 * @param array $ticket
	 **/
	public function updateTicket($ticket=array()) {
		if (!$ticket['ticket_id']) {
			return false;
		}
		$record = new StdClass();
		foreach($ticket as $property => $value) {
			$record->$property = $value;
		}
		$record->updated_ts = date('c');

		$this->db->where('ticket_id', $record->ticket_id);
		$this->db->update('tickets', $record);
		return $record->ticket_id;
	}

	/**
	 * Delete Ticket
	 *
	 * @param array $ticket
	 **/
	public function deleteTicket($ticket=array()) {
		if (!$ticket['ticket_id']) {
			return false;
		}

		$this->db->where('ticket_id', $ticket['ticket_id']);
		$this->db->delete('tickets');
		return $ticket['ticket_id'];
	}

	/**
	 * Log Action
	 *
	 * @param array $ticket
	 **/
	public function log($action='', $ticket=array()) {

		if (!is_array($ticket)) {
			$ticket = (array) $ticket;
		}

		if (!$ticket['ticket_id']) {
			return false;
		}

		// Log entry
		$entry->text = $action;
		$entry->user = $this->user_model->getCurrentUser();
		$entry->ticket = $ticket;

		$record = new StdClass();
		$record->ticket_id = $ticket['ticket_id'];
		$record->group_id = $this->group_model->getCurrentGroupId();
		$record->event_id = $ticket['event_id'];
		$record->user_id = $this->user_model->getCurrentUser()->user_id;
		$record->entry = json_encode($entry);
		$record->inserted_ts = date('c');

		$this->db->insert('ticket_history', $record);
	}

}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ticket_Model extends CI_Model {
	
	public $s3;

	/**
	 * Constructor
	 **/
	public function __construct() {
		parent::__construct();
		$this->load->model('group_model');

		// Configure S3 for ticket files
		require_once APPPATH . 'third_party/s3.php';
		$this->s3 = new S3(
			$this->config->item('aws_s3_access_key'),
			$this->config->item('aws_s3_secret_key')
		);
	}
	
	/**
	 * Get Ticket Status By Event Id
	 *
	 * @param int $event_id
	 * @param int $group_id
	 * @param int $user_id
	 **/
	public function getTicketStatusByEventId($event_id=0, $group_id=0, $user_id=0) {

		if (!$event_id || !$group_id || !$user_id) {
			return array();
		}

		$this->db->select('*');
		$this->db->where('event_id', $event_id);
		$this->db->where('user_id', $user_id);
		$this->db->where('group_id', $group_id);
		$tickets_user = $this->db->get('tickets');

		$this->db->select('*');
		$this->db->where('event_id', $event_id);
		$this->db->where('group_id', $group_id);
		$tickets_group = $this->db->get('tickets');

		$this->db->select('*');
		$this->db->where('event_id', $event_id);
		$this->db->where('user_id', 0);
		$this->db->where('group_id', $group_id);
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

		$this->db->select('*');
		$this->db->where('event_id', $event_id);
		$this->db->order_by('section', 'ASC');
		$this->db->order_by('row', 'ASC');
		$this->db->order_by('seat', 'ASC');
		$query = $this->db->get('tickets');
		$result = $query->result();
		$tickets = array();
		foreach ($result as $i => $row) {
			$tickets[$i] = $row;
			$tickets[$i]->files = $this->getTicketFilesById($row->ticket_id);
			$tickets[$i]->owner = $this->user_model->getUserById($row->owner_id);
			$tickets[$i]->alias = ($row->alias_id) ?  $this->user_model->getAliasById($row->alias_id) : 0;
			$tickets[$i]->assigned = ($row->user_id) ? $this->user_model->getUserById($row->user_id) : 0;
		}
		return $tickets;
	}

	/**
	 * Get Ticket By Id
	 *
	 * @param int $ticket_id
	 **/
	public function getTicketById($ticket_id=0) {
		$this->db->select('*');
		$this->db->where('ticket_id', $ticket_id);
		$this->db->order_by('section', 'ASC');
		$this->db->order_by('row', 'ASC');
		$this->db->order_by('seat', 'ASC');
		$query = $this->db->get('tickets');
		$ticket = $query->row();
		$ticket->files = $this->getTicketFilesById($ticket_id);
		$ticket->owner = $this->user_model->getUserById($ticket->owner_id);
		$ticket->alias = ($ticket->alias_id) ? $this->user_model->getAliasById($ticket->alias_id) : 0;
		$ticket->assigned = ($ticket->user_id) ? $this->user_model->getUserById($ticket->user_id) : 0;
		return $ticket;
	}

	/**
	 * Get Ticket History By Id
	 */
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
		$record->inserted_ts = date('Y-m-d H:i:s',now());
		$record->updated_ts = date('Y-m-d H:i:s',now());

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

		$this->db->where('ticket_id', $record->ticket_id);
		$this->db->update('tickets', $record);
		return $record->ticket_id;
	}

	/**
	 * Unassign Ticket
	 *
	 * @param int $ticket_id
	 **/
	public function unassignTicket($ticket_id=0) {
		$this->updateTicket(array(
			'ticket_id' => $ticket_id,
			'user_id' => 0
		));
		return true;
	}

	/**
	 * Delete Ticket
	 *
	 * @param int $ticket_id
	 **/
	public function deleteTicket($ticket_id=0) {
		if (!$ticket_id) {
			return false;
		}

		// Delete associated history
		/* Skipping this step during beta */

		// Delete associated files
		/* Skipping this step during beta */

		// Delete ticket
		$this->db->where('ticket_id', $ticket_id);
		$this->db->delete('tickets');
		return $ticket_id;
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
		$entry = new StdClass();
		$entry->text = $action;
		$entry->user = $this->user_model->getCurrentUser();
		$entry->ticket = $ticket;

		$record = new StdClass();
		$record->ticket_id = $ticket['ticket_id'];
		$record->group_id = $this->group_model->getCurrentGroupId();
		$record->event_id = $ticket['event_id'];
		$record->user_id = $this->user_model->getCurrentUser()->user_id;
		$record->entry = json_encode($entry);
		$record->inserted_ts = date('Y-m-d H:i:s',now());

		$this->db->insert('ticket_history', $record);
	}

	/**
	 * Get Ticket Files By ID
	 *
	 * @param int $ticket_id
	 */
	public function getTicketFilesById($ticket_id=0) {

		$this->db->select('*');
		$this->db->where('ticket_id', $ticket_id);
		$this->db->order_by('inserted_ts', 'DESC');
		$query = $this->db->get('ticket_files');
		$result = $query->result();

		return $result;
	}

	/**
	 * Get Ticket File By ID
	 *
	 * @param int $file_id
	 */
	public function getTicketFileById($file_id=0) {

		$this->db->select('*');
		$this->db->where('ticket_file_id', $file_id);
		$query = $this->db->get('ticket_files');
		$file = $query->row();

		return $file;
	}

	/**
	 * Add Ticket File
	 *
	 * @param array $options
	 */
	public function addTicketFile($file=array()) {

		// Store to S3
		if (!$file || !is_array($file) || !isset($file['full_path'])) {
			throw new Exception('Unable to process uploaded file.');
		}
		try {
			// Upload to S3
			$s3_path = $file['file_name'];
			$input = file_get_contents($file['full_path']);
			$bucket = $this->config->item('aws_s3_bucket');
			$this->s3->putObject($input, $bucket, $s3_path);
		} catch (Exception $e) {
			throw new Exception('A system error ocurred! ' . $e->getMessage());
		}

		// Store to database
		$record = new StdClass();
		$record->path = $s3_path;
		$record->file_name = $file['orig_name'];
		$record->ticket_id = $file['ticket_id'];
		$record->user_id = $this->user_model->getCurrentUser()->user_id;
		$record->inserted_ts = date('Y-m-d H:i:s',now());

		$this->db->insert('ticket_files', $record);

	}

	/**
	 * Delete Ticket File
	 *
	 * @param int $ticket_file_id
	 */
	public function deleteTicketFile($ticket_file_id=0) {

		$file = $this->getTicketFileById($ticket_file_id);

		// Delete from S3
		try {
			$s3_path = $file->path;
			$bucket = $this->config->item('aws_s3_bucket');
			$this->s3->deleteObject($bucket, $s3_path);
		} catch (Exception $e) {
			throw new Exception('A system error ocurred! ' . $e->getMessage());
		}

		// Delete database record
		$this->db->where('ticket_file_id', $ticket_file_id);
		$this->db->delete('ticket_files');

		return true;
	}

}
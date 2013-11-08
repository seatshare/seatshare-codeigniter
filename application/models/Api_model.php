<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_Model extends CI_Model {

	/**
	 * Constructor
	 **/
	public function __construct() {
		parent::__construct();
		$this->load->model('group_model');
		$this->load->model('ticket_model');
	}

	/**
	 * Validate API Key
	 *
	 * @param string $api_key
	 * @return boolean
	 **/
	public function validateAPIKey($api_key='') {
		// Simple static key for dashing
		if ($api_key == 'akc7zfsFewir3H') {
			return true;
		}
		return false;
	}

	/* Dashing Methods */

	/**
	 * User Count
	 */
	public function userCount() {
		$this->db->select('COUNT(*) AS count');
		$this->db->where('status', 1);
		$query = $this->db->get('users');
		return $query->row();
	}

	/**
	 * Group Count
	 */
	public function groupCount() {
		$this->db->select('COUNT(*) AS count');
		$this->db->where('status', 1);
		$query = $this->db->get('groups');
		return $query->row();
	}

	/**
	 * Group Invitation Count
	 */
	public function totalInvites($days=30) {
		$this->db->select('COUNT(*) AS count');
		$this->db->where('inserted_ts >=', date('Y-m-d', strtotime('-'.$days.' days')));
		$query = $this->db->get('group_invitations');
		return $query->row();
	}


	/**
	 * Group Invitation Count
	 */
	public function acceptedInvites($days=30) {
		$this->db->select('COUNT(*) AS count');
		$this->db->where('updated_ts >=', date('Y-m-d', strtotime('-'.$days.' days')));
		$this->db->where('status', 0);
		$query = $this->db->get('group_invitations');
		return $query->row();
	}

	/**
	 * Total Tickets Count
	 */
	public function totalTickets() {
		$this->db->select('COUNT(*) AS count');
		$query = $this->db->get('tickets');
		return $query->row();
	}

	/**
	 * Tickets Trasferred
	 */
	public function ticketsTransferred($days=30) {
		$this->db->select('COUNT(*) AS count');
		$this->db->where('t.user_id != t.owner_id');
		$this->db->where('t.user_id != 0');
		$this->db->where('e.start_time < now()');
		$this->db->join('events e', 't.event_id = e.event_id');
		$this->db->where('e.start_time >=', date('Y-m-d', strtotime('-'.$days.' days')));
		$query = $this->db->get('tickets t');
		return $query->row();
	}

	/**
	 * Tickets Unused
	 */
	public function ticketsUnused($days=30) {
		$this->db->select('COUNT(*) AS count');
		$this->db->where('t.user_id = 0');
		$this->db->where('e.start_time < now()');
		$this->db->join('events e', 't.event_id = e.event_id');
		$this->db->where('e.start_time >=', date('Y-m-d', strtotime('-'.$days.' days')));
		$query = $this->db->get('tickets t');
		return $query->row();
	}

	/**
	 * Largest Groups
	 */
	public function largestGroups() {
		$this->db->select('g.group');
		$this->db->select('count(*) AS user_count');
		$this->db->join('group_users gu', 'gu.group_id = g.group_id', 'LEFT');
		$this->db->where('g.status', 1);
		$this->db->group_by('g.group_id');
		$this->db->order_by('user_count', 'DESC');
		$query = $this->db->get('groups g', 0, 5);
		return $query->result();
	}

}
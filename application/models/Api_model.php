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
	public function totalInvites() {
		$this->db->select('COUNT(*) AS count');
		$query = $this->db->get('group_invitations');
		return $query->row();
	}


	/**
	 * Group Invitation Count
	 */
	public function acceptedInvites() {
		$this->db->select('COUNT(*) AS count');
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
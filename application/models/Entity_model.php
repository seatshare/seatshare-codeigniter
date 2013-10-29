<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Entity_Model extends CI_Model {
	
	/**
	 * Constructor
	 **/
	public function __construct() {
		parent::__construct();
		$this->load->model('group_model');
	}

	public function getEntityByGroupId($group_id=0) {
		$this->db->select('n.*');
		$this->db->join('groups g', 'n.entity_id = g.entity_id');
		$this->db->where('g.group_id', $group_id);
		$this->db->where('g.status', 1);
		$this->db->where('n.status', 1);
		$query = $this->db->get('entities n');
		return $query->row();
	}

	public function getEntityByCurrentGroup() {
		$group_id = $this->group_model->getCurrentGroupId();
		return $this->getEntityByGroupId($group_id);
	}

	public function getEntities() {
		$this->db->select('*');
		$this->db->where('status', 1);
		$this->db->order_by('entity', 'ASC');
		$query = $this->db->get('entities');
		$entities = $query->result();
		return $entities;
	}

	public function getEntitiesAsArray() {
		$entity_objects = $this->getEntities();
		$entities = array();
		foreach ($entity_objects as $row) {
			$entities[$row->entity_id] = $row->entity;
		}
		return $entities;
	}

}
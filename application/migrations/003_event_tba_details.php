<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_event_tba_details extends CI_Migration {
	
	public function up() {

		$exists = $this->db->field_exists('description', 'events');
		if ($exists) {
			return;
		}

		// New Columns
		$fields = array(
			'description' => array(
				'type' => 'TEXT',
				'null' => false,
				'default' => ''
			),
			'date_tba' => array(
				'type' => 'INT',
				'constraint' => 1,
				'default' => 0
			),
			'time_tba' => array(
				'type' => 'INT',
				'constraint' => 1,
				'default' => 0
			)
		);
		$this->dbforge->add_column('events', $fields);

	}

	public function down() {
		$this->dbforge->drop_column('events', 'description');
		$this->dbforge->drop_column('events', 'date_tba');
		$this->dbforge->drop_column('events', 'time_tba');
	}

}
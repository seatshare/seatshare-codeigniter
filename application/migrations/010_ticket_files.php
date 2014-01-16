<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_ticket_files extends CI_Migration {
	
	public function up() {

		$exists = $this->db->table_exists('ticket_files');
		if ($exists) {
			return;
		}

		// Ticket Files
		$this->dbforge->add_field(array(
			'ticket_file_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
				'null' => false,
				'auto_increment' => true
			),
			'user_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => false,
				'default' => 0
			),
			'ticket_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => false,
				'default' => 0
			),
			'path' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => false,
				'default' => '',
				'unique' => ''
			),
			'file_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => false,
				'default' => '',
				'unique' => ''
			),
			'inserted_ts' => array(
				'type' => 'TIMESTAMP'
			)
		));
		$this->dbforge->add_key('ticket_file_id');
		$this->dbforge->add_key('user_id');
		$this->dbforge->add_key('ticket_id');
		$this->dbforge->create_table('ticket_files', true);

	}

	public function down() {

		$this->dbforge->drop_table('ticket_files');

	}

}
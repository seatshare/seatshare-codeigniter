<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_ticket_alias extends CI_Migration {
	
	public function up() {

		$exists = $this->db->table_exists('user_aliases');
		if ($exists) {
			return;
		}

		// User alias table
		$this->dbforge->add_field(array(
			'alias_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
				'null' => false,
				'auto_increment' => true
			),
			'first_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => false
			),
			'last_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => false
			),
			'user_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => false
			),
			'updated_ts' => array(
				'type' => 'TIMESTAMP'
			),
			'inserted_ts' => array(
				'type' => 'TIMESTAMP'
			)
		));
		$this->dbforge->add_key('alias_id', true);
		$this->dbforge->create_table('user_aliases', true);

		// New Columns
		$this->dbforge->add_column('tickets', array(
			'note' => array(
				'type' => 'TEXT',
				'null' => false,
				'default' => '',
				'after' => 'seat',
			),
			'alias_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => false,
				'default' => 0
				'after' => 'user_id'
			)
		));

	}

	public function down() {
		$this->dbforge->drop_column('tickets', 'note');
		$this->dbforge->drop_column('tickets', 'alias_id');
		$this->dbforge->drop_table('user_aliases');
	}

}
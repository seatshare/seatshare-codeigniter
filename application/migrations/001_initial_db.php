<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_initial_db extends CI_Migration {
	
	public function up() {

		$exists = $this->db->table_exists('entities');
		if ($exists) {
			return;
		}

		// Entities
		$this->dbforge->add_field(array(
			'entity_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
				'null' => false,
				'auto_increment' => true
			),
			'entity' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => false,
				'default' => ''
			),
			'logo' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => true
			),
			'status' => array(
				'type' => 'INT',
				'constraint' => 1,
				'default' => 1
			)
		));
		$this->dbforge->add_key('entity_id', true);
		$this->dbforge->create_table('entities', true);

		// Events
		$this->dbforge->add_field(array(
			'event_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
				'null' => false,
				'auto_increment' => true
			),
			'entity_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => false
			),
			'event' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => false,
				'default' => ''
			),
			'start_time' => array(
				'type' => 'TIMESTAMP',
				'null' => true
			)
		));
		$this->dbforge->add_key('event_id', true);
		$this->dbforge->create_table('events', true);

		// Group Users
		$this->dbforge->add_field(array(
			'group_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => false
			),
			'user_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => false
			),
			'role' => array(
				'type' => 'VARCHAR',
				'constraint' => 25,
				'null' => false,
				'default' => 'member'
			)
		));
		$this->dbforge->add_key(array('group_id', 'user_id'));
		$this->dbforge->create_table('group_users', true);

		// Groups
		$this->dbforge->add_field(array(
			'group_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
				'null' => false,
				'auto_increment' => true
			),
			'entity_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => false
			),
			'group' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'default' => ''
			),
			'creator_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => false
			),
			'invitation_code' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'default' => '',
				'unique' => true
			),
			'status' => array(
				'type' => 'INT',
				'constraint' => 1,
				'default' => 1,
				'null' => false
			),
			'updated_ts' => array(
				'type' => 'TIMESTAMP'
			),
			'inserted_ts' => array(
				'type' => 'TIMESTAMP'
			)
		));
		$this->dbforge->add_key('group_id', true);
		$this->dbforge->create_table('groups', true);

		// Tickets
		$this->dbforge->add_field(array(
			'ticket_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
				'null' => false,
				'auto_increment' => true
			),
			'group_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => false
			),
			'event_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => false
			),
			'owner_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => false
			),
			'user_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => false
			),
			'section' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => false
			),
			'row' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => false
			),
			'seat' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => false
			),
			'cost' => array(
				'type' => 'DECIMAL',
				'constraint' => '10,2',
				'default' => 0.00,
				'null' => false
			),
			'updated_ts' => array(
				'type' => 'TIMESTAMP'
			),
			'inserted_ts' => array(
				'type' => 'TIMESTAMP'
			)
		));
		$this->dbforge->add_key('ticket_id', true);
		$this->dbforge->create_table('tickets', true);

		// Ticket History
		$this->dbforge->add_field(array(
			'ticket_history_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
				'null' => false,
				'auto_increment' => true
			),
			'ticket_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => false
			),
			'group_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => false
			),
			'event_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => false
			),
			'user_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => false
			),
			'entry' => array(
				'type' => 'TEXT',
				'null' => false
			),
			'updated_ts' => array(
				'type' => 'TIMESTAMP'
			),
			'inserted_ts' => array(
				'type' => 'TIMESTAMP'
			)
		));
		$this->dbforge->add_key('ticket_history_id', true);
		$this->dbforge->create_table('ticket_history', true);

		// Users
		$this->dbforge->add_field(array(
			'user_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
				'null' => false,
				'auto_increment' => true
			),
			'username' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => false,
				'unique' => true,
			),
			'password' => array(
				'type' => 'VARCHAR',
				'constraint' => 32,
				'null' => false,
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
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => false,
				'unique' => true
			),
			'status' => array(
				'type' => 'INT',
				'constraint' => 1,
				'default' => 1,
				'null' => false
			),
			'updated_ts' => array(
				'type' => 'TIMESTAMP'
			),
			'inserted_ts' => array(
				'type' => 'TIMESTAMP'
			)
		));
		$this->dbforge->add_key('user_id', true);
		$this->dbforge->create_table('users', true);

	}

	public function down() {
		$this->dbforge->drop_table('entities');
		$this->dbforge->drop_table('events');
		$this->dbforge->drop_table('group_users');
		$this->dbforge->drop_table('groups');
		$this->dbforge->drop_table('tickets');
		$this->dbforge->drop_table('ticket_history');
		$this->dbforge->drop_table('users');
	}
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_event_reminders extends CI_Migration {
	
	public function up() {

		$exists = $this->db->table_exists('reminder_types');
		if ($exists) {
			return;
		}

		// Reminder Types
		$this->dbforge->add_field(array(
			'reminder_type_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
				'null' => false,
				'auto_increment' => true
			),
			'reminder_type' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => false,
				'default' => '',
				'unique' => true
			),
			'description' => array(
				'type' => 'varchar',
				'constraint' => 255,
				'null' => false,
				'default' => ''
			)
		));
		$this->dbforge->add_key('reminder_type_id', true);
		$this->dbforge->create_table('reminder_types', true);

		// Reminders
		$this->dbforge->add_field(array(
			'reminder_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
				'null' => false,
				'auto_increment' => true
			),
			'reminder_type_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => false,
				'default' => 0
			),
			'user_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => false,
				'default' => 0
			),
			'entry' => array(
				'type' => 'TEXT',
				'null' => false
			),
			'inserted_ts' => array(
				'type' => 'TIMESTAMP'
			)
		));
		$this->dbforge->add_key('reminder_id', true);
		$this->dbforge->create_table('reminders', true);

		// User Reminders
		$this->dbforge->add_field(array(
			'group_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => false,
				'default' => 0
			),
			'user_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => false,
				'default' => 0
			),
			'reminder_type_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => false,
				'default' => 0
			)
		));
		$this->dbforge->add_key(array('group_id','user_id','reminder_type_id'));
		$this->dbforge->create_table('user_reminders', true);

		// Initial data
		$record = new StdClass();
		$record->reminder_type_id = 1;
		$record->reminder_type = 'weekly';
		$record->description = 'The week ahead (sent Monday mornings)';
		$this->db->insert('reminder_types', $record);

		$record = new StdClass();
		$record->reminder_type_id = 2;
		$record->reminder_type = 'daily';
		$record->description = 'Today\'s events (sent on the morning of events)';
		$this->db->insert('reminder_types', $record);

	}

	public function down() {
		$this->dbforge->drop_table('reminder_types');
		$this->dbforge->drop_table('reminders');
		$this->dbforge->drop_table('user_reminders');
	}

}
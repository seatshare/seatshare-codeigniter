<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_group_invitations extends CI_Migration {
	
	public function up() {

		$exists = $this->db->table_exists('group_invitations');
		if ($exists) {
			return;
		}

		// Group Invitations
		$this->dbforge->add_field(array(
			'invitation_id' => array(
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
			'group_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => false,
				'default' => 0
			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => false,
				'default' => ''
			),
			'invitation_code' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => false,
				'default' => ''
			),
			'inserted_ts' => array(
				'type' => 'TIMESTAMP'
			)
		));
		$this->dbforge->add_key('invitation_id', true);
		$this->dbforge->add_key('invitation_code');
		$this->dbforge->create_table('group_invitations', true);

	}

	public function down() {
		$this->dbforge->drop_table('group_invitations');
	}

}
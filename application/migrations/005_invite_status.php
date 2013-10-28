<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_invite_status extends CI_Migration {
	
	public function up() {

		$exists = $this->db->field_exists('status', 'group_invitations');
		if ($exists) {
			return;
		}

		// New Columns
		$this->dbforge->add_column('group_invitations', array(
			'status' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => false,
				'default' => '1'
			),
			'updated_ts' => array(
				'type' => 'TIMESTAMP'
			)
		));
	}

	public function down() {
		$this->dbforge->drop_column('group_invitations', 'status');
		$this->dbforge->drop_column('group_invitations', 'updated_ts');
	}

}
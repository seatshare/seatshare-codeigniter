<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_password_reset extends CI_Migration {
	
	public function up() {

		$exists = $this->db->field_exists('activation_key', 'users');
		if ($exists) {
			return;
		}

		// New Columns
		$this->dbforge->add_column('users', array(
			'activation_key' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => false,
				'default' => ''
			)
		));
	}

	public function down() {
		$this->dbforge->drop_column('users', 'activation_key');
	}

}
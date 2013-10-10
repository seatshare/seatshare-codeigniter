<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_password_reset extends CI_Migration {
	
	public function up() {

		$exists = $this->db->query('SHOW COLUMNS IN `users` WHERE `Field` = "activation_key";');
		if ($exists->num_rows) {
			return;
		}

		// New Columns
		$this->db->query("ALTER TABLE `users` ADD `activation_key` varchar(50)  NOT NULL  DEFAULT '' AFTER `email` ");

	}

	public function down() {
		$this->db->query("ALTER TABLE `users` DROP `activation_key` ");
	}

}
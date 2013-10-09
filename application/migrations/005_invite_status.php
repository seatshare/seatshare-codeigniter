<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_invite_status extends CI_Migration {
	
	public function up() {

		$exists = $this->db->query('SHOW COLUMNS IN `group_invitations` WHERE `Field` = "status";');
		if ($exists->num_rows) {
			return;
		}

		// New Columns
		$this->db->query("ALTER TABLE `group_invitations` ADD `status` tinyint(1)  NOT NULL  DEFAULT '1' AFTER `invitation_code` ");
		$this->db->query("ALTER TABLE `group_invitations` ADD `updated_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER `status` ");

	}

	public function down() {
		$this->db->query("ALTER TABLE `group_invitations` DROP `status` ");
		$this->db->query("ALTER TABLE `group_invitations` DROP `updated_ts` ");
	}

}
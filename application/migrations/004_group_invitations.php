<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_group_invitations extends CI_Migration {
	
	public function up() {

		$exists = $this->db->query('SHOW TABLES LIKE "group_invitations"');
		if ($exists->num_rows) {
			return;
		}

		// Group Invitations
		$query = "
			CREATE TABLE `group_invitations` (
				`invitation_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`user_id` int(11) NOT NULL DEFAULT '0',
				`group_id` int(11) NOT NULL DEFAULT '0',
				`email` varchar(255) NOT NULL DEFAULT '',
				`invitation_code` varchar(50) DEFAULT NULL,
				`inserted_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
				PRIMARY KEY (`invitation_id`),
				KEY `invitation_code` (`invitation_code`),
				KEY `group_id` (`group_id`)
			)
		";
		$this->db->query($query);

	}

	public function down() {
		$query = "
			DROP TABLE IF EXISTS `group_invitations`;
		";
		$this->db->query($query);
	}

}
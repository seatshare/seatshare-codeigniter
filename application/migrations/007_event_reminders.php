<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_event_reminders extends CI_Migration {
	
	public function up() {

		$exists = $this->db->query('SHOW TABLES LIKE "reminder_types"');
		if ($exists->num_rows) {
			return;
		}

		// Reminder Types
		$query = "
			CREATE TABLE `reminder_types` (
				`reminder_type_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`reminder_type` varchar(50) NOT NULL DEFAULT '',
				`description` varchar(255) NOT NULL DEFAULT '',
				PRIMARY KEY (`reminder_type_id`),
				UNIQUE KEY `reminder_type` (`reminder_type`)
			)
		";
		$this->db->query($query);

		// Reminders
		$query = "
			CREATE TABLE `reminders` (
				`reminder_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`reminder_type_id` int(11) NOT NULL DEFAULT '0',
				`user_id` int(11) NOT NULL DEFAULT '0',
				`entry` text NOT NULL,
				`inserted_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
				PRIMARY KEY (`reminder_id`)
			)
		";
		$this->db->query($query);

		// User Reminders
		$query = "
			CREATE TABLE `user_reminders` (
				`group_id` int(11) NOT NULL,
				`user_id` int(11) NOT NULL,
				`reminder_type_id` int(11) NOT NULL,
				UNIQUE KEY `group_id` (`group_id`,`user_id`,`reminder_type_id`)
			)
		";
		$this->db->query($query);

		// Initial data
		$query = "
			INSERT INTO `reminder_types` (`reminder_type_id`, `reminder_type`, `description`)
			VALUES
				(1, 'week_ahead', 'The week ahead (sent Monday mornings)'),
				(2, 'morning', 'Today\'s events (sent on the morning of events)'
			);
		";
		$this->db->query($query);

	}

	public function down() {
		$this->db->query("DROP TABLE IF EXISTS `reminder_types` ");
		$this->db->query("DROP TABLE IF EXISTS `reminders` ");
		$this->db->query("DROP TABLE IF EXISTS `user_reminders` ");

	}

}
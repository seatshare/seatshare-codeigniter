<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_initial_db extends CI_Migration {
	
	public function up() {

		$exists = $this->db->query('SHOW TABLES LIKE "entities"');
		if ($exists->num_rows) {
			return;
		}

		// Entities
		$query = "
			CREATE TABLE `entities` (
				`entity_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`entity` varchar(100) NOT NULL DEFAULT '',
				`logo` varchar(255) DEFAULT NULL,
				`status` int(1) DEFAULT 1,
				PRIMARY KEY (`entity_id`)
			)
		";
		$this->db->query($query);

		// Events
		$query = "
			CREATE TABLE `events` (
				`event_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`entity_id` int(11) NOT NULL,
				`event` varchar(255) NOT NULL DEFAULT '',
				`start_time` datetime DEFAULT NULL,
				PRIMARY KEY (`event_id`)
			)
		";
		$this->db->query($query);

		// Group Users
		$query = "
			CREATE TABLE `group_users` (
				`group_id` int(11) NOT NULL,
				`user_id` int(11) NOT NULL,
				`role` enum('member','admin') NOT NULL DEFAULT 'member',
				UNIQUE KEY `group_id` (`group_id`,`user_id`)
			)
		";
		$this->db->query($query);

		// Groups
		$query = "
			CREATE TABLE `groups` (
				`group_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`entity_id` int(11) DEFAULT NULL,
				`group` varchar(255) DEFAULT NULL,
				`creator_id` int(11) DEFAULT NULL,
				`invitation_code` varchar(50) DEFAULT NULL,
				`status` tinyint(1) NOT NULL DEFAULT '1',
				`updated_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				`inserted_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
				PRIMARY KEY (`group_id`),
				UNIQUE KEY `invitation_code` (`invitation_code`)
			)
		";
		$this->db->query($query);

		// Tickets
		$query = "
			CREATE TABLE `tickets` (
				`ticket_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`group_id` int(11) NOT NULL,
				`event_id` int(11) NOT NULL,
				`owner_id` int(11) NOT NULL,
				`user_id` int(11) NOT NULL DEFAULT '0',
				`section` varchar(50) DEFAULT NULL,
				`row` varchar(50) DEFAULT NULL,
				`seat` varchar(50) DEFAULT NULL,
				`cost` decimal(10,2) NOT NULL DEFAULT '0.00',
				`updated_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				`inserted_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
				PRIMARY KEY (`ticket_id`)
			)
		";
		$this->db->query($query);

		// Ticket History
		$query = "
			CREATE TABLE `ticket_history` (
				`ticket_history_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`ticket_id` int(11) NOT NULL,
				`group_id` int(11) NOT NULL,
				`event_id` int(11) NOT NULL,
				`user_id` int(11) NOT NULL DEFAULT '0',
				`entry` mediumtext NOT NULL,
				`updated_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				`inserted_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
				PRIMARY KEY (`ticket_history_id`)
			)
		";
		$this->db->query($query);

		// Users
		$query = "
			CREATE TABLE `users` (
				`user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`username` varchar(100) NOT NULL DEFAULT '',
				`password` varchar(32) NOT NULL DEFAULT '',
				`first_name` varchar(100) DEFAULT NULL,
				`last_name` varchar(100) DEFAULT NULL,
				`email` varchar(255) DEFAULT NULL,
				`status` tinyint(1) NOT NULL DEFAULT '1',
				`updated_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				`inserted_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
				PRIMARY KEY (`user_id`),
				UNIQUE KEY `username` (`username`),
				UNIQUE KEY `email` (`email`)
			)
		";
		$this->db->query($query);

	}

	public function down() {
		$query = "
			DROP TABLE IF EXISTS `entities`;
			DROP TABLE IF EXISTS `events`;
			DROP TABLE IF EXISTS `group_users`;
			DROP TABLE IF EXISTS `groups`;
			DROP TABLE IF EXISTS `tickets`;
			DROP TABLE IF EXISTS `ticket_history`;
			DROP TABLE IF EXISTS `users`;
		";
		$this->db->query($query);
	}

}
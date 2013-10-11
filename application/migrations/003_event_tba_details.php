<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_event_tba_details extends CI_Migration {
	
	public function up() {

		$exists = $this->db->query('SHOW COLUMNS IN `events` WHERE `Field` = "description";');
		if ($exists->num_rows) {
			return;
		}

		// New Columns
		$this->db->query("ALTER TABLE `events` ADD `description` text NOT NULL AFTER `event` ");
		$this->db->query("ALTER TABLE `events` ADD `date_tba` tinyint(1)  NOT NULL  DEFAULT '0' AFTER `start_time` ");
		$this->db->query("ALTER TABLE `events` ADD `time_tba` tinyint(1)  NOT NULL  DEFAULT '0' AFTER `date_tba` ");

	}

	public function down() {
		$this->db->query("ALTER TABLE `events` DROP `description` ");
		$this->db->query("ALTER TABLE `events` DROP `date_tba` ");
		$this->db->query("ALTER TABLE `events` DROP `time_tba` ");
	}

}
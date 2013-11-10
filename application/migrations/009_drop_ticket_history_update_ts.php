<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_drop_ticket_history_update_ts extends CI_Migration {
	
	public function up() {

		$exists = $this->db->field_exists('updated_ts', 'ticket_history');
		if (!$exists) {
			return;
		}

		// Drop Column
		$this->dbforge->drop_column('ticket_history', 'updated_ts');

	}

	public function down() {

		// Replace Column
		$this->dbforge->add_column('ticket_history', array(
			'updated_ts' => array(
				'type' => 'TIMESTAMP',
				'after' => 'entry'
			)
		));
	}

}
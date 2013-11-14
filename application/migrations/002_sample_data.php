<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_sample_data extends CI_Migration {
	
	public function up() {

		$exists = $this->db->query("SELECT * FROM entities");
		if ($exists->num_rows) {
			return;
		}

		// Sample Entities
		$query = "
			INSERT INTO entities (entity_id, entity, logo, status)
			VALUES
				(1, 'Nashville Predators', 'https://upload.wikimedia.org/wikipedia/en/9/9c/Nashville_Predators_Logo_%282011%29.svg', 1),
				(2, 'Belmont Bruins', 'https://upload.wikimedia.org/wikipedia/en/3/3d/BelmontBruins.png', 1)
		";
		$this->db->query($query);

		// Sample events
		$query = "
			INSERT INTO events (event_id, entity_id, event, start_time)
			VALUES
				(1, 2, 'Belmont Bruins vs. Brescia', '2013-11-26 00:00:00'),
				(2, 2, 'Belmont Bruins vs. Lipscomb', '2013-11-20 00:00:00'),
				(3, 2, 'Belmont Bruins vs. Indiana State', '2013-11-14 00:00:00'),
				(4, 1, 'Nashville Predators vs. St. Louis Blues', '2013-10-26 19:00:00'),
				(5, 1, 'Nashville Predators vs. Winnipeg Jets', '2013-10-24 19:00:00'),
				(6, 1, 'Nashville Predators vs. Los Angeles Kings', '2013-10-17 19:00:00'),
				(7, 1, 'Nashville Predators vs. Florida Panthers', '2013-10-15 19:00:00'),
				(8, 1, 'Nashville Predators vs. New York Islanders', '2013-10-12 19:00:00'),
				(9, 1, 'Nashville Predators vs. Toronto Maple Leafs', '2013-10-10 19:00:00'),
				(10, 1, 'Nashville Predators vs. Minnesota Wild', '2013-10-08 19:00:00')
		";
		$this->db->query($query);

	}

	public function down() {
		$this->db->query("TRUNCATE TABLE entities");
		$this->db->query("TRUNCATE TABLE events");
	}

}
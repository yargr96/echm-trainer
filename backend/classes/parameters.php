<?php
require_once('db.php');

class Parameters 
{
	public function __construct()
	{
		$this->db = new DB();
	}

	public function get_input_parameters() {
		$query_string = "SELECT * FROM `machines`";
		$machines = $this->db->fetch_assoc_list($query_string);
		$machines_assoc = [];
		foreach ($machines as $key => $val) {
			$machines_assoc[$val[name]] = [];
			foreach ($val as $k => $v) {
				if ($k == 'name') continue;
				$machines_assoc[$val[name]][$k] = $v;
			}
		}
		
		$query_string = "SELECT * FROM `electrolytes`";
		$electrolytes = $this->db->fetch_assoc_list($query_string);
		$electrolytes_assoc = [];
		foreach ($electrolytes as $key => $val) {
			$electrolytes_assoc[$val[name]] = [];
			foreach ($val as $k => $v) {
				if ($k == 'name') continue;
				$electrolytes_assoc[$val[name]][$k] = $v;
			}
		}

		$query_string = "SELECT * FROM `materials`";
		$materials = $this->db->fetch_assoc_list($query_string);
		$materials_assoc = [];
		foreach ($materials as $key => $val) {
			$materials_assoc[$val[name]] = [];
			foreach ($val as $k => $v) {
				if ($k == 'name') continue;
				$materials_assoc[$val[name]][$k] = $v;
			}
		}

		return [
			'machines' => $machines_assoc,
			'electrolytes' => $electrolytes_assoc,
			'materials' => $materials_assoc
		];
	}
}
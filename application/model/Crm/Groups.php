<?php

class Crm_Groups {
	private $class = null;

	public function __construct() {
		$this->class =& Crm_Registry::get('class');
	}

	public function getAll() {
		$out = array();

		$res = $this->class->db->query('SELECT * FROM "group" WHERE deleted=0');
		$out = $res->fetchAll();

		return $out;
	}
}

?>

<?php

class Crm_Users {
	private $class = null;

	public function __construct() {
		$this->class =& Crm_Registry::get('class');
	}

	public function getAll() {
		$out = array();

		$res = $this->class->db->query('SELECT * FROM "user" WHERE deleted=0');
		$out = $res->fetchAll();

		return $out;
	}
}

?>

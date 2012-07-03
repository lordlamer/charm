<?php

class Crm_User {
	private $class = null;
	private $user = null;

	public function __construct() {
		$this->class =& Crm_Registry::get('class');
	}

	public function set($name, $value) {
		if($this->user == null) $this->user = array();
		$this->user[$name] = $value;
	}

	public function get($name) {
		$out = null;

		if(isset($this->user[$name])) {
			$out = $this->user[$name];
		}

		return $out;
	}

	public function getDataFromDb($username) {
		$res = $this->class->db->query('SELECT * FROM "user" WHERE username=:username', array(':username' => $username));
		$user = $res->fetch();
		$this->set('login', $user['username']);
		$this->set('firstname', $user['firstname']);
		$this->set('name', $user['name']);
		$this->set('email', $user['email']);
		$this->set('language', $user['language']);
	}
}

?>

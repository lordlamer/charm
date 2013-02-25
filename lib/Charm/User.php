<?php

class Charm_User {
	private $user = null;

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
		$db = Zend_Registry::get('db');

		$res = $db->query('SELECT * FROM users WHERE username=:username', array(':username' => $username));
		$user = $res->fetch();
		$this->set('login', $user['username']);
		$this->set('id', $user['rowid']);
		//$this->set('firstname', $user['firstname']);
		//$this->set('name', $user['name']);
		//$this->set('email', $user['email']);
		//$this->set('language', $user['language']);
	}
}
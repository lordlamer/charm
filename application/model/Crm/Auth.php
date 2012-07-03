<?php

class Crm_Auth {
	private $class = null;
	private $zauth = null;

	public function __construct() {
		$this->class = Crm_Registry::get('class');
		$this->zauth = Zend_Auth::getInstance();
	}

	/**
	 * check creadentials
	 * @param string $username
	 * @param string $password
	 * @return bool
	 */
	public function checkLogin($username, $password) {
		$res = $this->class->db->query('SELECT * FROM  "user" WHERE deleted=0 AND disabled=0 AND username=:username AND password=md5(:password)', array(':username' => $username, ':password' => $password));

		if($row = $res->fetch()) {
			$this->class->session->username = $row['username'];
			$this->class->session->passwordhash = $row['password'];
			return true;
		}

		return false;
	}

	public function isValidLogin() {
		if($this->class->session->username && $this->class->session->passwordhash) {
			$res = $this->class->db->query('SELECT id FROM "user" WHERE deleted=0 AND disabled=0 AND username=:username and password=:password', array(':username' => $this->class->session->username, ':password' => $this->class->session->passwordhash));

			if($row = $res->fetch()) {
				return true;
			}
		}

		return false;
	}
}

?>

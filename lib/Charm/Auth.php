<?php

class Charm_Auth {
	private $zauth = null;

	public function __construct() {
		$this->zauth = Zend_Auth::getInstance();
	}

	/**
	 * check creadentials
	 * @param string $username
	 * @param string $password
	 * @return bool
	 */
	public function checkLogin($username, $password) {
		$db = Zend_Registry::get('db');
		$passwordhash = crypt($password,"yk");
		$res = $db->query('SELECT * FROM  users WHERE mandant='.Zend_Registry::get('mandant').' AND username=:username AND password=:password', array(':username' => $username, ':password' => $passwordhash));

		if($row = $res->fetch()) {
			$session = Zend_Registry::get('session');
			$session->id = $row['rowid'];
			$session->username = $row['username'];
			$session->passwordhash = $row['password'];

			return true;
		}

		return false;
	}

	public function isValidLogin() {
		$db = Zend_Registry::get('db');
		$session = Zend_Registry::get('session');
		if($session->username && $session->passwordhash) {
			$res = $db->query('SELECT rowid FROM users WHERE mandant='.Zend_Registry::get('mandant').' AND username=:username and password=:password', array(':username' => $session->username, ':password' => $session->passwordhash));

			if($row = $res->fetch()) {
				return true;
			}
		}

		return false;
	}
}
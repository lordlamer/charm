<?php

class Crm_Registry {
	public $registry = array();

	static private $instance = null;

	private function __construct(){}
	private function __clone(){}

	static public function getInstance() {
		if (self::$instance === NULL) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function set($index, &$value) {
		$this->registry[$index] =& $value;
	}

	public function get($index) {
		$instance = self::getInstance();
		return $instance->registry[$index];
	}

	public function isRegistered($index) {
		return isset($this->registry[$index]);
	}
}

?>

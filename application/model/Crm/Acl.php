<?php

class Crm_Acl {
	private $class = null;
	private $zacl = null;
	private $acl = null;
	private $users = null;
	private $groups = null;
	private $usergroupmapping = null;

	public function __construct() {
		$this->class =& Crm_Registry::get('class');
		$this->zacl = new Zend_Acl();

		$users = new Crm_Users();
		$this->users = $users->getAll();

		$groups = new Crm_Groups();
		$this->groups = $groups->getAll();

		$usergroupmapping = new Crm_User_Group_Mapping();
		$this->usergroupmapping = $usergroupmapping->getAll();

		foreach($this->groups as $key => $value) {
			$this->zacl->addRole(new Zend_Acl_Role($value['id']));
		}

		$parents = array();
		foreach($this->usergroupmapping as $key => $value) {
			$parents[$value['userid']][] = $value['groupid'];
		}

		foreach($this->users as $key => $value) {
			if(isset($parents[$value['id']])) $this->zacl->addRole(new Zend_Acl_Role($value['id'], $parents[$value['id']]));
		}

		$res = $this->class->db->query('SELECT * FROM resource WHERE deleted=0');
		while($row = $res->fetch()) {
			$this->zacl->add(new Zend_Acl_Resource($row['id']));
		}

		$res = $this->class->db->query('SELECT * FROM acl');
		while($row = $res->fetch()) {
			if($row['allow'] == 1) $this->zacl->allow($row['who'], $row['resourceid']);
			if($row['disable'] == 1) $this->zacl->deny($row['who'], $row['resourceid']);
		}
	}

	/**
	 *
	 */
	public function isAllowed($whoid, $resourceid) {
		return $this->zacl->isAllowed($whoid, $resourceid);
	}
}

?>

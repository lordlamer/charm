<?php

class Charm_Employee {
    protected $id = null;
    protected $firstname = null;
    protected $name = null;

    public function __construct($id = null) {
	if(!empty($id))
	    $this->load($id);
    }

    public function load($id) {
        $employee = new Charm_Db_Employee();

	$select = $employee->select();
	$select->where('rowid = ?', $id);
        $select->where('mandant = ?', Zend_Registry::get('mandant'));

        $row = $employee->fetchRow($select);

        $this->id = $row['rowid'];
	$this->firstname = $row['firstname'];
        $this->name = $row['name'];
    }

    public function getId() {
	return $this->id;
    }

    public function getFirstName() {
	return $this->firstname;
    }

    public function getName() {
	return $this->name;
    }

    public function getEmployees() {
        $ret = array();

        $employee = new Charm_Db_Employee();
        $select = $employee->select();
        $select->where('mandant = ?', Zend_Registry::get('mandant'));
	$select->where('deactivated = ?', 0);
	$select->order('name asc');
        $rows = $employee->fetchAll($select);

        foreach($rows as $value) {
            $ret[] = new Charm_Employee($value->rowid);
        }

        return $ret;
    }
}
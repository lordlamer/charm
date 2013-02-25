<?php

class Charm_Project {
    protected $id = null;
    protected $title = null;
    protected $supervisor = null;
    protected $username = null;
    protected $private = null;
    protected $employees = null;
    protected $last_update = null;
    protected $company = null;

    public function __construct($id = null) {
	if ($id != null) {
	    $this->load((int) $id);
	}
    }

    protected function load($id) {
        $project = new Charm_Db_Project();
        $row = $project->find($id);

        $this->id = $row[0]['rowid'];
        $this->title = $row[0]['title'];
	$this->supervisor = $row[0]['supervisor'];
	$this->username = $row[0]['username'];
	$this->private = $row[0]['private'];
	$this->employees = $row[0]['employees'];
	$this->last_update = $row[0]['last_update'];

	if($row[0]['for_rowid'] != 0)
	    $this->company = new Charm_Company($row[0]['for_rowid']);
    }

    public function getId() {
	return $this->id;
    }

    public function getName() {
	return $this->title;
    }

    public function getSupervisor() {
	return $this->supervisor;
    }

    public function getUsername() {
	return $this->username;
    }

    public function getPrivate() {
	return $this->private;
    }

    public function getEmployees() {
	return $this->employees;
    }

    public function getLastUpdate() {
	return $this->last_update;
    }

    public function getCompany() {
	if(!empty($this->company))
	    return $this->company->getName();
	else
	    return '';
    }

    public function find($search = null) {
        $ret = array();

        $project = new Charm_Db_Project();
        $select = $project->select();
        $select->where('mandant = ?', 24);
	$select->where('category1 != ?', 440);
	$select->order('title asc');
        $rows = $project->fetchAll($select);

        foreach($rows as $value) {
            $ret[] = new Charm_Project($value->rowid);
        }

        return $ret;
    }
}
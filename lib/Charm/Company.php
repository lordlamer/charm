<?php

class Charm_Company {

    protected $id = null;
    protected $name = null;

    public function __construct($id = null) {
	if ($id != null) {
	    $this->load((int) $id);
	}
    }

    protected function load($id) {
        $company = new Charm_Db_Company();
        $row = $company->find($id);

        $this->id = $row[0]['rowid'];
        $this->name = $row[0]['name'];
    }

    public function getId() {
	return $this->id;
    }

    public function getName() {
	return $this->name;
    }

}
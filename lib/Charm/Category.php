<?php

/**
 *
 */
class Charm_Category {
    protected $table = null;
    protected $id = null;
    protected $name = null;

    public function __construct($table, $id = null) {
	$this->table = $table;

	if(!empty($id))
	    $this->load($id);
    }

    public function load($id) {
        $category = new Charm_Db_Category();

	$select = $category->select();
	$select->where('rowid = ?', $id);
        $select->where('mandant = ?', 24);
	$select->where('table_name = ?', $this->table);

        $row = $category->fetchRow($select);

        $this->id = $row['rowid'];
        $this->name = $row['name'];
    }

    public function getTable() {
	return $this->table;
    }

    public function getId() {
	return $this->id;
    }

    public function getName() {
	return $this->name;
    }

    public function getCategories() {
        $ret = array();

        $category = new Charm_Db_Category();
        $select = $category->select();
        $select->where('mandant = ?', 24);
	$select->where('table_name = ?', $this->table);
	$select->order('name asc');
        $rows = $category->fetchAll($select);

        foreach($rows as $value) {
            $ret[] = new Charm_Category($this->table, $value->rowid);
        }

        return $ret;
    }
}
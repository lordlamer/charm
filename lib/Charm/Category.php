<?php

/**
 *
 */
class Charm_Category {
    protected $table = null;
    protected $label = null;
    protected $id = null;
    protected $name = null;
    protected $color = null;

    public function __construct($table, $label, $id = null) {
	$this->table = $table;
	$this->label = $label;

	if(!empty($id))
	    $this->load($id);
    }

    public function load($id) {
        $category = new Charm_Db_Category();

	$select = $category->select();
	$select->where('rowid = ?', $id);
        $select->where('mandant = ?', 24);
	$select->where('table_name = ?', $this->table);
	$select->where('this_table_alias = ?', $this->label);

        $row = $category->fetchRow($select);

        $this->id = $row['rowid'];
        $this->name = $row['name'];
	$this->color = $row['color'];
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

    public function getColor() {
	return $this->color;
    }

    public function getCategories() {
        $ret = array();

        $category = new Charm_Db_Category();
        $select = $category->select();
        $select->where('mandant = ?', 24);
	$select->where('table_name = ?', $this->table);
	$select->where('this_table_alias = ?', $this->label);
	$select->order('name asc');
        $rows = $category->fetchAll($select);

        foreach($rows as $value) {
            $ret[] = new Charm_Category($this->table, $this->label, $value->rowid);
        }

        return $ret;
    }
}
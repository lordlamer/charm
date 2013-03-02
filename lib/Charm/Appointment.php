<?php

class Charm_Appointment {
    protected $id = null;
    protected $title = null;
    protected $description = null;
    protected $start = null;
    protected $end = null;
    protected $category = null;

    public function __construct($id = null) {
	if(!empty($id))
	    $this->load($id);
    }

    public function load($id) {
        $appointment = new Charm_Db_Appointment();
        $row = $appointment->find($id);

        $this->id = $row[0]['rowid'];
        $this->title = $row[0]['title'];
	$this->description = $row[0]['description'];
	$this->start = $row[0]['dt_start'];
	$this->end = $row[0]['dt_end'];
	$this->category = $row[0]['category1'];
    }

    public function getId() {
	return $this->id;
    }

    public function getTitle() {
	return $this->title;
    }

    public function getDescription() {
	return $this->description;
    }

    public function getCategory() {
	if($this->category != '')
	    return new Charm_Category('appointment', 'category1', $this->category);
	else
	    return null;
    }

    public function getStart() {
	return $this->start;
    }

    public function getEnd() {
	return $this->end;
    }

    public function find($search = null) {
        $ret = array();

        $appointment = new Charm_Db_Appointment();
        $select = $appointment->select();
        $select->where('mandant = ?', 24);

	if(is_array($search)) {
	    foreach($search as $key => $value) {
		if($key == 'dt_start')
		    $select->where('dt_start >= ?', $value);
		elseif($key == 'dt_end')
		    $select->where('dt_end <= ?', $value);
		else
		    $select->where($key.' = ?', $value);
	    }
	}

	$select->order('title asc');

        $rows = $appointment->fetchAll($select);

        foreach($rows as $value) {
            $ret[] = new Charm_Appointment($value->rowid);
        }

        return $ret;
    }
}

?>
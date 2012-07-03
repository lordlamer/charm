<?php

class Crm_Project_Task {
	/**
	 * internal link to global class
	 * @var $class
	 */
	private $class = null;

	/**
	 * construct
	 */
	public function __construct() {
		$this->class = Crm_Registry::get('class');
	}

	public function getTasks($projectId = null) {
		$tasks = array();

		if($projectId != null)
			$res = $this->class->db->query("SELECT * FROM projecttask WHERE projectid=:projectid AND deleted=0 AND disabled=0 ORDER BY name", array(':projectid' => $projectId));
		else
			$res = $this->class->db->query("SELECT * FROM projecttask WHERE deleted=0 AND disabled=0 ORDER BY name");

		$tasks = $res->fetchAll();

		return $tasks;
	}
	
	public function getMyTasks() {
		$tasks = array();

		$res = $this->class->db->query("SELECT * FROM projecttask WHERE deleted=0 AND disabled=0 ORDER BY name");

		$tasks = $res->fetchAll();

		return $tasks;
	}
	
	public function getTask($taskId) {
		$task = $this->class->db->fetchRow('SELECT * FROM projecttask WHERE deleted=0 AND disabled=0 AND id=:taskid', array(':taskid' => $taskId));
		return $task;
	}
	
	public function addTask($values) {
		if(isset($values['submit'])) unset($values['submit']);
		$this->class->db->insert('projecttask', $values);
		return $this->class->db->lastSequenceId('seq_master');
	}
	
	public function editTask($taskId, $values) {
		if(isset($values['submit'])) unset($values['submit']);
		$n = $this->class->db->update('projecttask', $values, 'id = '.$taskId);
		if($n == 1) return true;
		else false;
	}
	
	public function deleteTask($taskId) {
		$this->class->db->update('projecttask', array('deleted' => 1), 'id = '.$taskId);
		return true;
	}
}
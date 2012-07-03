<?php

class Crm_Project {
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

	public function getProjects($namePrefix = null) {
		$companies = array();

		if($namePrefix == null) {
			$res = $this->class->db->query("SELECT * FROM project WHERE deleted=0 AND disabled=0 ORDER BY name");
		} else {
			$res = $this->class->db->query("SELECT * FROM project WHERE name ilike :prefix AND deleted=0 AND disabled=0 ORDER BY name", array(':prefix' => $namePrefix.'%'));
		}

		$companies = $res->fetchAll();

		return $companies;
	}
	
	public function getMyProjects($userId, $namePrefix = null) {
		// TODO: add checks for user
		$companies = array();

		if($namePrefix == null) {
			$res = $this->class->db->query("SELECT * FROM project WHERE deleted=0 AND disabled=0 ORDER BY name");
		} else {
			$res = $this->class->db->query("SELECT * FROM project WHERE name ilike :prefix AND deleted=0 AND disabled=0 ORDER BY name", array(':prefix' => $namePrefix.'%'));
		}

		$companies = $res->fetchAll();

		return $companies;
	}
	
	public function getProject($projectId) {
		$project = $this->class->db->fetchRow('SELECT * FROM project WHERE deleted=0 AND disabled=0 AND id=:projectid', array(':projectid' => $projectId));
		return $project;
	}

	/**
	 * add a project
	 * @param array $values
	 * @return int projectid
	 */
	public function addProject($values) {
		if(isset($values['submit'])) unset($values['submit']);
		$this->class->db->insert('project', $values);
		return $this->class->db->lastSequenceId('seq_master');
	}
	
	public function editProject($projectId, $values) {
		if(isset($values['submit'])) unset($values['submit']);
		$n = $this->class->db->update('project', $values, 'id = '.$projectId);
		if($n == 1) return true;
		else false;
	}
	
	public function deleteProject($projectId) {
		$this->class->db->update('project', array('deleted' => 1), 'id = '.$projectId);
		return true;
	}
}
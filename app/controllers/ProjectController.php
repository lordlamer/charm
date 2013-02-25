<?php

class ProjectController extends Zend_Controller_Action {

    public function init() {
	/* Initialize action controller here */
    }

    public function indexAction() {
	$db = Zend_Registry::get('db');

	$session = new Zend_Session_Namespace('user');

	$project = new Charm_Project();
	$projects = $project->find();

	$showProjects = array();
print_r($session->id);
	foreach($projects as $key => $value) {
	    $users = explode('|', $value->getEmployees());
	    //foreach($users as $uvalue) {
		//if($uvalue == 435) {
		    $showProjects[] = $value;
		//}
	    //}
	}

	$this->view->userid = $session->id;
	$this->view->projects = $showProjects;
    }

    public function __call($name, $params) {
	$this->_forward('index');
    }

    public function taskAction() {

    }

    public function weeklyAction() {

    }
}


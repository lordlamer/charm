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

	// get categories
	$category1 = new Charm_Category('project', 'category1');
	$this->view->category1 = $category1->getCategories();

	$category2 = new Charm_Category('project', 'category2');
	$this->view->category2 = $category2->getCategories();

	$category3 = new Charm_Category('project', 'category3');
	$this->view->category3 = $category3->getCategories();

	// users
	$employees = new Charm_Employee();
	$this->view->employees = $employees->getEmployees();
    }

    public function __call($name, $params) {
	$this->_forward('index');
    }

    public function taskAction() {

    }

    public function weeklyAction() {

    }
}


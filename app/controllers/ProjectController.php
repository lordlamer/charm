<?php

class ProjectController extends Zend_Controller_Action {

    public function init() {
	/* Initialize action controller here */
    }

    public function indexAction() {
	// db
	$db = Zend_Registry::get('db');

	// session
	$session = new Zend_Session_Namespace('user');
	$this->view->userid = $session->id;

	// get categories
	$category1 = new Charm_Category('project', 'category1');
	$this->view->category1 = $category1->getCategories();
	$this->view->category1_selected = '';

	$category2 = new Charm_Category('project', 'category2');
	$this->view->category2 = $category2->getCategories();
	$this->view->category2_selected = '';

	$category3 = new Charm_Category('project', 'category3');
	$this->view->category3 = $category3->getCategories();
	$this->view->category3_selected = '';

	// users
	$employees = new Charm_Employee();
	$this->view->employees = $employees->getEmployees();
	$this->view->employees_selected = '';

	$projectFilter = array();

	if ($this->getRequest()->getMethod() == 'POST') {
	    $this->view->category1_selected = $this->_getParam('category1');
	    if($this->_getParam('category1') != '') $projectFilter['category1'] = $this->_getParam('category1');
	    $this->view->category2_selected = $this->_getParam('category2');
	    if($this->_getParam('category2') != '') $projectFilter['category2'] = $this->_getParam('category2');
	    $this->view->category3_selected = $this->_getParam('category3');
	    if($this->_getParam('category3') != '') $projectFilter['category3'] = $this->_getParam('category3');
	    $this->view->employee_selected = $this->_getParam('employee');
	    if($this->_getParam('employee') != '') $projectFilter['employee'] = $this->_getParam('employee');
	}

	// projects
	$project = new Charm_Project();
	$projects = $project->find($projectFilter);

	$showProjects = array();

	foreach ($projects as $key => $value) {
	    $users = explode('|', $value->getEmployees());
	    //foreach($users as $uvalue) {
	    //if($uvalue == 435) {
	    $showProjects[] = $value;
	    //}
	    //}
	}

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


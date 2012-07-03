<?php

class ProjectController extends Zend_Controller_Action {
	private $class = null;

	public function init() {
		$this->class = Crm_Registry::get('class');
		$this->view->class = $this->class;
	}

	public function __call($name, $params) {
		$this->_forward('index');
	}

	public function indexAction() {
		$this->_forward('showmytasks');
	}

	public function showmytasksAction() {
		$this->view->activetab = 'showmytasks';
	}

	public function showalltasksAction() {
		$this->view->activetab = 'showalltasks';
	}

	public function showmyprojectsAction() {
		$this->view->activetab = 'showmyprojects';

		$userid = "";

		$projects = new Crm_Project();

		if($this->getRequest()->getParam('search') != '') {
			$this->view->projects = $projects->getMyProjects($userid, $this->getRequest()->getParam('search'));
			$this->view->search = $this->getRequest()->getParam('search');
		} else {
			$this->view->projects = $projects->getMyProjects($userid);
			$this->view->search = '';
		}
	}

	public function showallprojectsAction() {
		$this->view->activetab = 'showallprojects';

		$projects = new Crm_Project();

		if($this->getRequest()->getParam('search') != '') {
			$this->view->projects = $projects->getProjects($this->getRequest()->getParam('search'));
			$this->view->search = $this->getRequest()->getParam('search');
		} else {
			$this->view->projects = $projects->getProjects();
			$this->view->search = '';
		}
	}
	
	public function showprojectAction() {
		$projects = new Crm_Project();
		$tasks = new Crm_Project_Task();

		$this->view->project = $projects->getProject($this->getRequest()->getParam('id'));
		$this->view->tasks = $tasks->getTasks($this->getRequest()->getParam('id'));

	}
	
	public function showtaskAction() {
		$task = new Crm_Project_Task();

		$this->view->task = $task->getTask($this->getRequest()->getParam('id'));
	}

	public function addprojectAction() {
		$form = new Crm_Form_Project();
		$form->setAction('./project/addproject');

		if($this->getRequest()->isPost() && $form->isValid($_POST)) {
			// save
			$project = new Crm_Project();
			$projectid = $project->addProject($form->getValues());

			// redirect to company
			$this->_redirect('./project/showproject/id/'.$projectid);
		} else {
			// show form
			$this->view->form = $form;
		}
	}

	public function addtaskAction() {
		$form = new Crm_Form_Project_Task();
		$form->setAction('./project/addtask');

		if($this->getRequest()->isPost() && $form->isValid($_POST)) {
			// save
			$task = new Crm_Project_Task();
			$taskid = $task->addTask($form->getValues());

			// redirect to task
			$this->_redirect('./project/showtask/id/'.$taskid);
		} else {
			// show form
			$this->view->form = $form;
		}
	}

	public function addfeedbackAction() {

	}

	public function editprojectAction() {
		$project = new Crm_Project();
		$this->view->project = $project->getProject($this->getRequest()->getParam('id'));
		$this->view->activetab = 'showallprojects';

		$form = new Crm_Form_Project();
		$form->setAction('./project/editproject');

		$form->addElement('hidden', 'id', array('value' => $this->getRequest()->getParam('id')));

		if($this->getRequest()->isPost() && $form->isValid($_POST)) {
			// save and redirect
			$project->editProject($this->getRequest()->getParam('id'), $form->getValues());
			$this->_redirect('./project/showproject/id/'.$this->getRequest()->getParam('id'));
		} else {
			// fill up with values
			$form->fillForm($this->view->project);

			// show form
			$this->view->form = $form;
		}
	}

	public function edittaskAction() {

	}

	public function editfeedbackAction() {

	}

	public function delprojectAction() {
		$project = new Crm_Project();
		$this->view->project = $project->getProject($this->getRequest()->getParam('id'));

		$form = new Zend_Form();
		//$form->clearDecorators();
		$form->setAction('./project/delproject');
		$form->setMethod('post');

		$hidden = new Zend_Form_Element_Hidden('id');
		$hidden->setValue($this->getRequest()->getParam('id'));
		$hidden->addDecorators(array(
                         'ViewHelper',
                         'Errors',
                         array('HtmlTag', array('tag' => 'div')),
                         array('Label', array('tag' => 'div')),
                 ));
		$form->addElement($hidden);

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->clearDecorators();
		$submit->setLabel('Wirklich loeschen!');
		$submit->setAttrib('class', 'button');
		$submit->addDecorators(array(
                         'ViewHelper',
                         'Errors',
                         array('HtmlTag', array('tag' => 'div')),
                 ));
		$form->addElement($submit);

		if($this->getRequest()->isPost() && $form->isValid($_POST)) {
			// delete and redirect
			$project->deleteProject($this->getRequest()->getParam('id'));
			$this->_redirect('./project');
		} else {
			$this->view->confirmform = $form;
		}
	}

	public function deletetaskAction() {

	}

	public function deletefeedbackAction() {

	}
}

?>

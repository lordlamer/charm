<?php

class Crm_Form_Project_Task extends Zend_Form {
	public function init() {
		$this->clearDecorators();

		$this->setMethod("post");

		// project
		$project = new Zend_Form_Element_Select('projectid');
		$project->setLabel('Projekt');
		$project->setRequired(true);
		$projects = new Crm_Project();
		foreach($projects->getProjects() as $value) {
		  $project->addMultiOption($value['id'],$value['name']);
		 }
 		
		//$project->addValidator('int');
		$project->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($project);

		// name
		$name = new Zend_Form_Element_Text('name');
		$name->setLabel('Name');
		$name->setRequired(true);
		//$name->addValidator('alnum');
		$name->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($name);

		// description
		$description = new Zend_Form_Element_Textarea('description');
		$description->setLabel('Description');
		//$description->setRequired(true);
		//$description->addValidator('alnum');
		$description->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($description);
/*
		// supervisor
		$supervisor = new Zend_Form_Element_Text('supervisor');
		$supervisor->setLabel('Supervisor');
		//$supervisor->setRequired(true);
		//$supervisor->addValidator('alnum');
		$supervisor->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($supervisor);

		// status
		$status = new Zend_Form_Element_Select('status');
		$status->setLabel('Status');
		$status->setRequired(true);
		$status->addValidator('int');
		$status->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($status);

		// priority
		$priority = new Zend_Form_Element_Select('priority');
		$priority->setLabel('Priority');
		$priority->setRequired(true);
 		$priority->addMultiOption(1,1);
 		$priority->addMultiOption(2,2);
 		$priority->addMultiOption(3,3);
 		$priority->addMultiOption(4,4);
 		$priority->addMultiOption(5,5);
 		$priority->addMultiOption(6,6);
 		$priority->addMultiOption(7,7);
 		$priority->addMultiOption(8,8);
 		$priority->addMultiOption(9,9);
 		$priority->addMultiOption(10,10);
		$priority->addValidator('int');
		$priority->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($priority);

		// company
		$company = new Zend_Form_Element_Text('company');
		$company->setLabel('Company');
		//$company->setRequired(true);
		//$company->addValidator('alnum');
		$company->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($company);

		// contactperson
		$contactperson = new Zend_Form_Element_Text('contact');
		$contactperson->setLabel('Contact');
		//$contactperson->setRequired(true);
		//$contactperson->addValidator('alnum');
		$contactperson->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($contactperson);

		// ticketprefix
		$ticketprefix = new Zend_Form_Element_Text('ticketprefix');
		$ticketprefix->setLabel('Ticketprefix');
		//$ticketprefix->setRequired(true);
		//$ticketprefix->addValidator('alnum');
		$ticketprefix->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($ticketprefix);

		// starttime
		$starttime = new Zend_Form_Element_Text('starttime');
		$starttime->setLabel('Starttime');
		//$starttime->setRequired(true);
		$starttime->addValidator('int');
		$starttime->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($starttime);

		// endtime
		$endtime = new Zend_Form_Element_Text('endtime');
		$endtime->setLabel('Endtime');
		//$endtime->setRequired(true);
		$endtime->addValidator('int');
		$endtime->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($endtime);

		// targethours
		$targethours = new Zend_Form_Element_Text('targethours');
		$targethours->setLabel('Target Hours');
		//$targethours->setRequired(true);
		$targethours->addValidator('int');
		$targethours->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($targethours);

		// targetminutes
		$targetminutes = new Zend_Form_Element_Text('targetminutes');
		$targetminutes->setLabel('Target Minutes');
		//$targetminutes->setRequired(true);
		$targetminutes->addValidator('int');
		$targetminutes->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($targetminutes);

		// private
		$private = new Zend_Form_Element_Checkbox('private');
		$private->setLabel('Private');
		//$private->setRequired(true);
		//$private->addValidator('alnum');
		$private->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($private);
*/
		// submit
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Save');
		$submit->clearDecorators();
		$submit->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td', 'colspan' => 2)),
			array()
		));
		$this->addElement($submit);

		$this->setDecorators(array(
			array('ViewScript', array('viewScript'=>'project/form/task.phtml'))
		));
	}

	/**
	 * fill form with values
	 * @param array $values
	 */
	public function fillForm($values) {
		if(is_array($values)) {
			foreach($values as $key => $value) {
				if(isset($this->$key)) $this->$key->setValue($value);
			}
		}
	}
}

?>
<?php

class Crm_Form_Address_Contact extends Zend_Form {
	public function init() {
		$this->clearDecorators();

		$this->setMethod("post");

		// name
		$name = new Zend_Form_Element_Text('name');
		$name->setLabel('Name');
		//$name->setRequired(true);
		//$name->addValidator('alnum');
		$name->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($name);

		// firstname
		$firstname = new Zend_Form_Element_Text('firstname');
		$firstname->setLabel('Firstname');
		//$firstname->setRequired(true);
		//$firstname->addValidator('alnum');
		$firstname->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($firstname);

		// salution
		$salution = new Zend_Form_Element_Text('salution');
		$salution->setLabel('Salution');
		//$salution->setRequired(true);
		//$salution->addValidator('alnum');
		$salution->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($salution);

		// title
		$title = new Zend_Form_Element_Text('title');
		$title->setLabel('Title');
		//$title->setRequired(true);
		//$title->addValidator('alnum');
		$title->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($title);

		// position
		$position = new Zend_Form_Element_Text('position');
		$position->setLabel('Position');
		//$position->setRequired(true);
		//$position->addValidator('alnum');
		$position->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($position);

		// url
		$url = new Zend_Form_Element_Text('url');
		$url->setLabel('Homepage');
		//$url->setRequired(true);
		//$url->addValidator('alnum');
		$url->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($url);

		// email
		$email = new Zend_Form_Element_Text('email');
		$email->setLabel('Email');
		//$email->setRequired(true);
		//$email->addValidator('alnum');
		$email->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($email);
		// email
		$email = new Zend_Form_Element_Text('email');
		$email->setLabel('Email');
		//$email->setRequired(true);
		//$email->addValidator('alnum');
		$email->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($email);

		// phone
		$phone = new Zend_Form_Element_Text('phone');
		$phone->setLabel('Phone');
		//$phone->setRequired(true);
		//$phone->addValidator('alnum');
		$phone->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($phone);

		// mobilephone
		$mobilephone = new Zend_Form_Element_Text('mobilephone');
		$mobilephone->setLabel('Mobilephone');
		//$mobilephone->setRequired(true);
		//$mobilephone->addValidator('alnum');
		$mobilephone->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($mobilephone);

		// fax
		$fax = new Zend_Form_Element_Text('fax');
		$fax->setLabel('Fax');
		//$fax->setRequired(true);
		//$fax->addValidator('alnum');
		$fax->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($fax);

		// privatestreet
		$privatestreet = new Zend_Form_Element_Text('privatestreet');
		$privatestreet->setLabel('Privatestreet');
		//$privatestreet->setRequired(true);
		//$privatestreet->addValidator('alnum');
		$privatestreet->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($privatestreet);

		// privatezip
		$privatezip = new Zend_Form_Element_Text('privatezip');
		$privatezip->setLabel('Privatezip');
		//$privatezip->setRequired(true);
		//$privatezip->addValidator('alnum');
		$privatezip->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($privatezip);

		// privatecity
		$privatecity = new Zend_Form_Element_Text('privatecity');
		$privatecity->setLabel('Privatecity');
		//$privatecity->setRequired(true);
		//$privatecity->addValidator('alnum');
		$privatecity->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($privatecity);

		// birthday
		$birthday = new Zend_Form_Element_Text('birthday');
		$birthday->setLabel('Birthday');
		//$birthday->setRequired(true);
		//$birthday->addValidator('alnum');
		$birthday->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($birthday);

		// note
		$note = new Zend_Form_Element_Text('note');
		$note->setLabel('Note');
		//$note->setRequired(true);
		//$note->addValidator('alnum');
		$note->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($note);

		// submit
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Save');
		$submit->setIgnore(true);
		$submit->clearDecorators();
		$submit->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td', 'colspan' => 2)),
			array()
		));
		$this->addElement($submit);

		$this->setDecorators(array(
			array('ViewScript', array('viewScript'=>'address/form/contact.phtml'))
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

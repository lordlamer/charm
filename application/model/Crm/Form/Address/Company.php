<?php

class Crm_Form_Address_Company extends Zend_Form {
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

		// street
		$street = new Zend_Form_Element_Text('street');
		$street->setLabel('Street');
		//$street->setRequired(true);
		//$street->addValidator('alnum');
		$street->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($street);

		// zip
		$zip = new Zend_Form_Element_Text('zip');
		$zip->setLabel('Zip');
		//$zip->setRequired(true);
		//$zip->addValidator('alnum');
		$zip->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($zip);

		// city
		$city = new Zend_Form_Element_Text('city');
		$city->setLabel('City');
		//$city->setRequired(true);
		//$city->addValidator('alnum');
		$city->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
		));
		$this->addElement($city);

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

		// url
		$url = new Zend_Form_Element_Text('url');
		$url->setLabel('Url');
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
		$submit->clearDecorators();
		$submit->addDecorators(array(
			'ViewHelper',
			'Errors',
			array('HtmlTag', array('tag' => 'td', 'colspan' => 2)),
			array()
		));
		$this->addElement($submit);

		$this->setDecorators(array(
			array('ViewScript', array('viewScript'=>'address/form/company.phtml'))
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

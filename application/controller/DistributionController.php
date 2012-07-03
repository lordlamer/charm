<?php

class DistributionController extends Zend_Controller_Action {
	private $class = null;

	public function init() {
		$this->class = Crm_Registry::get('class');
		$this->view->class = $this->class;
	}

	public function __call($name, $params) {
		echo "##";
		$this->_forward('index');
	}

	public function indexAction() {
		$response = $this->getResponse();
		$response->insert('menu', $this->view->render('menu.phtml'));

		$form = new Zend_Form;
		$form->setAction('./address/add')
		      ->setMethod('post');

// Ein username Element erstellen und konfigurieren:
$username = $form->createElement('text', 'username');
$username->addValidator('alnum')
         ->addValidator('regex', false, array('/^[a-z]+/'))
         ->addValidator('stringLength', false, array(6, 20))
         ->setRequired(true)
         ->addFilter('StringToLower');

// Ein Passwort Element erstellen und konfigurieren:
$password = $form->createElement('password', 'password');
$password->addValidator('StringLength', false, array(6))
         ->setRequired(true);

// Elemente der Form hinzufügen:
$form->addElement($username)
     ->addElement($password)
     // addElement() als Factory verwenden um den 'Login' Button zu erstellen:
     ->addElement('submit', 'login', array('label' => 'Login'));

		$this->view->form = $form;
	}
}

?>

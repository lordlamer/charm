<?php

class IndexController extends Zend_Controller_Action {
	private $class = null;

	public function init() {
		$this->class = Crm_Registry::get('class');
		$this->view->class = $this->class;
	}

	public function __call($name, $params) {
		$this->_forward('index');
	}

	public function indexAction() {
		$this->view->class = $this->class;
	}

	public function loginAction() {
		$this->_helper->layout->disableLayout();
		$this->class->session->username = "test";
		$this->class->session->passwordhash = "test";

		// build form
		$config = new Zend_Config_Ini($this->class->config->base->path . '/config/forms.ini', 'login');
		$form = new Zend_Form($config);

		//if ($this->getRequest()->isPost() && !$form->isValid($_POST)) {
		//	echo "not valid";
		//}

		// show form
		$this->view->form = $form;

		if($this->getRequest()->isPost() && $form->isValid($_POST)) {
			$values = $form->getValues();
			if($this->class->auth->checkLogin($values['username'], $values['password'])) {
				//echo "drin";
				$this->_redirect('index');
			} else {
				//echo "nicht drin";
			}
		}
	}

	public function logoutAction() {
		Zend_Session::destroy();
		$this->_redirect('index');
	}
}

?>

<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
	/* Initialize action controller here */
    }

    public function indexAction() {
	// action body
    }

    public function __call($name, $params) {
	$this->_forward('index');
    }

    public function loginAction() {
	$this->_helper->layout->disableLayout();

	if ($this->getRequest()->isPost()) {
	    $auth = new Charm_Auth();
	    if ($auth->checkLogin($this->_getParam('username'), $this->_getParam('password'))) {
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


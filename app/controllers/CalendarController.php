<?php

class CalendarController extends Zend_Controller_Action {

    public function init() {
	/* Initialize action controller here */
    }

    public function indexAction() {
	// action body
    }

    public function __call($name, $params) {
	$this->_forward('index');
    }

}


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

    public function datesAction() {
	$this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

$response = $this->getResponse();
$response->setHeader('Content-type', 'application/json', true);

$date = date("j", time());
$month = date("n", time());
$year = date("Y", time());
$dates = array();
$dates[] = array(
    'id' => 123,
    'title' => 'Click for Google',
    'start' => '2013-03-28T13:15:30Z',
    'end' => '2013-03-29T13:15:30Z',
    //'url' => 'http://google.com/',
    //'allDay' => false
    //color
    //backgroundColor
    //borderColor
    //textColor
);

echo json_encode($dates);
    }
}


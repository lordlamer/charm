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

	$startDate = date('Y-m-d H:i:s', $this->_getParam('start'));
	$endDate = date('Y-m-d H:i:s', $this->_getParam('end'));

	$appointment = new Charm_Appointment();
	$appointments = $appointment->find(array('dt_start' => $startDate, 'dt_end' => $endDate));

	$dates = array();

	foreach($appointments as $value) {
	    $dates[] = array(
		'id' => $value->getId(),
		'title' => $value->getTitle(),
		'start' => $value->getStart(), //'2013-03-28T13:15:30Z',
		'end' => $value->getEnd(), //'2013-03-29T13:15:30Z',
		//'url' => 'http://google.com/',
		//'allDay' => false
		//color
		//backgroundColor
		//borderColor
		//textColor
	    );
	}

	echo json_encode($dates);
    }
}


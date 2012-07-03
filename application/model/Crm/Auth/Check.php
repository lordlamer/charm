<?php
/**
 *
 */

class Crm_Auth_Check extends Zend_Controller_Plugin_Abstract {
	/**
	 *
	 */
	private $class = null;

	/**
	 *
	 */
	public function preDispatch(Zend_Controller_Request_Abstract $request) {
		$this->class =& Crm_Registry::get('class');

		// check for valid session
		$path = $this->getRequest()->getControllerName() . "/" . $this->getRequest()->getActionName();
		if(!$this->class->auth->isValidLogin() && $path != 'index/login') {
			$this->getResponse()->setRedirect($this->class->config->base->url . 'login');
		} else {
			$this->class->user->getDataFromDb($this->class->session->username);
		}
	}
}

?>

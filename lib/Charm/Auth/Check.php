<?php
/**
 *
 */

class Charm_Auth_Check extends Zend_Controller_Plugin_Abstract {
	/**
	 *
	 */
	public function preDispatch(Zend_Controller_Request_Abstract $request) {
		$auth = new Charm_Auth();
		$config = Zend_Registry::get('config');
		$session = Zend_Registry::get('session');
		$user = new Charm_User();

		$module = $request->getModuleName();
		$controller = $request->getControllerName();
		$action = $request->getActionName();;

		if(!($module == '' && $controller == 'index' && ($action == 'login' || $action == 'logout'))) {
		    // check for valid session
		    $path = $this->getRequest()->getControllerName() . "/" . $this->getRequest()->getActionName();
		    if(!$auth->isValidLogin() && $path != 'index/login') {
			    $this->getResponse()->setRedirect($config->base->base_url . '/login');
		    } else {
			    $user->getDataFromDb($session->username);
		    }
		}
	}
}
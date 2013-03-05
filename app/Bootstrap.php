<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
    /**
     * init autoloader
     */
    protected function _initAutoload() {
	try {
	    // load required class
	    require_once('Zend/Loader.php');

	    // init autoloader
	    $autoloader = Zend_Loader_Autoloader::getInstance();

	    // register charm
	    $autoloader->registerNamespace('Charm_');

	    // save in registry
	    $registry = Zend_Registry::getInstance();
	    $registry->set('loader', $autoloader);

	    return $autoloader;
	} catch (Exception $e) {
	    echo $e->getMessage();
	    die('could not create autoloader');
	}
    }

    /**
     * load config file
     */
    protected function _initConfig() {
	try {
	    // load config
	    $config = new Zend_Config_Ini(PROJECT_PATH . '/config/app.ini');

	    // save config in registry
	    Zend_Registry::set('config', $config);

	    return $config;
	} catch (Exception $e) {
	    echo $e->getMessage();
	    die('no config file');
	}
    }

    /**
     * init cache
     */
    protected function _initCache() {
	try {
	    // load config
	    $this->bootstrap('config');

	    // get config
	    $config = Zend_Registry::get('config');

	    // create cache
	    $cache = Zend_Cache::factory($config->cache->frontend->name, $config->cache->backend->name, $config->cache->frontend->options->toArray(), $config->cache->backend->options->toArray());

	    // save cache
	    Zend_Registry::set('cache', $cache);

	    return $cache;
	} catch (Zend_Exception $e) {
	    echo $e->getMessage();
	    die('could not create cache');
	}
    }

    /**
     * init database
     */
    protected function _initDatabase() {
	try {
	    // init config
	    $this->bootstrap('config');

	    // init cache
	    $this->bootstrap('cache');

	    // get config
	    $config = Zend_Registry::get('config');

	    // get cache
	    $cache = Zend_Registry::get('cache');

	    // make database connect
	    $db = Zend_Db::factory($config->database);

	    // set default adapter
	    Zend_Db_Table_Abstract::setDefaultAdapter($db);

	    // set cache for metadata
	    Zend_Db_Table_Abstract::setDefaultMetadataCache($cache);

	    // use profiler?
	    if ($config->database->profiler) {
		// init firebug profiler
		$profiler = new Zend_Db_Profiler_Firebug('All Database Queries:');

		// enable it
		$profiler->setEnabled(true);

		// attach profiler to db adapter
		$db->setProfiler($profiler);
	    }

	    // save db handle in registry
	    Zend_Registry::set('db', $db);

	    return $db;
	} catch (Zend_Exception $e) {
	    echo $e->getMessage();
	    die('no database connection');
	}
    }

    protected function _initMandant() {
	// set mandant id for system
	$mandant = 24;

	// save mandant id to registry
	Zend_Registry::set('mandant', 24);

	return $mandant;
    }

    /**
     * init layout
     */
    protected function _initLayout() {
	try {
	    // load config
	    $this->bootstrap('config');

	    // get config
	    $config = Zend_Registry::get('config');

	    // start mvc
	    Zend_Layout::startMvc();

	    // get layout instance
	    $layout = Zend_Layout::getMvcInstance();

	    // set layout path
	    $layout->setLayoutPath($config->production->resources->layout->layoutPath);

	    // set layout name
	    $layout->setLayout($config->production->resources->layout->layout);

	    // set version
	    $layout->version = $config->base->version;

	    // set config to layout
	    $layout->config = $config;
	} catch (Exception $e) {
	    echo $e->getMessage();
	    die('could not create layout');
	}
    }

    /**
     * init session
     */
    protected function _initSession() {
	try {
	    // load config
	    $this->bootstrap('config');

	    // get config
	    $config = Zend_Registry::get('config');

	    // start session
	    Zend_Session::start($config->session->toArray());

	    // save session to registry
	    $session = new Zend_Session_Namespace('default');
	    Zend_Registry::set('session', $session);

	    // set guest user if user does not exists
	    // get new session namespace and save data
	    $session = new Zend_Session_Namespace('user');
	    if (!$session->valid) {
		$session->valid = false;
		$session->id = 0;
		$session->login = 'guest';
		$session->language = 'en_US';
	    }

	    return $session;
	} catch (Exception $e) {
	    echo $e->getMessage();
	    die('Could not create session');
	}
    }

    protected function _initPlugins() {
	try {
	    // load config
	    $this->bootstrap('config');

	    // get controller instance
	    $controller = Zend_Controller_Front::getInstance();

	    $controller->registerPlugin(new Charm_Auth_Check());
	} catch (Exception $e) {
	    echo $e->getMessage();
	    die('could not create plugins');
	}
    }

    /**
     * init routes
     */
    protected function _initRoutes() {
	try {
	    // load controller
	    //$this->bootstrap('controller');
	    // add routes
	    $router = Zend_Controller_Front::getInstance()->getRouter();


	    // login
	    $router->addRoute('login', new Zend_Controller_Router_Route('login', array(
			'controller' => 'index',
			'action' => 'login')));

	    // logout
	    $router->addRoute('logout', new Zend_Controller_Router_Route('logout', array(
			'controller' => 'index',
			'action' => 'logout')));

	    // settings
	    $router->addRoute('settings', new Zend_Controller_Router_Route('settings', array(
			'controller' => 'settings',
			'action' => 'index')));

	    // dashboard
	    $router->addRoute('dashboard', new Zend_Controller_Router_Route('dashboard', array(
			'controller' => 'index',
			'action' => 'index')));
	} catch (Exception $e) {
	    echo $e->getMessage();
	    die('could not create routes');
	}
    }
}


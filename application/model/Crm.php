<?php
/**
 *
 */

/**
 * autoloader function for classes
 * @param string $class name of class
 */
function __autoload($class) {
        Zend_Loader::loadClass($class);
}

/**
 *
 */
class Crm {
	/**
	 *
	 */
	private $class = null;

	/**
	 *
	 */
	private $base_path = null;

	/**
	 *
	 */
	public function run() {
		if(!is_file('config/config.ini'))
			die('No config file found!');

		$this->base_path = dirname(dirname($_SERVER['SCRIPT_FILENAME']).'/..');

		set_include_path(get_include_path() . PATH_SEPARATOR . $this->base_path . '/lib/' . PATH_SEPARATOR . $this->base_path . '/application/model/');

		// init class
		$this->class = (object) array();

		// load zend_loader
		require_once('Zend/Loader.php');

		// set registry
		$this->class->registry = Crm_Registry::getInstance();
		$this->class->registry->set('class', $this->class);

		// load config
		$this->class->config = new Zend_Config_Ini('config/config.ini');

		// activate output compression if it is enabled
		if($this->class->config->output->compression) {
			if($this->class->config->output->level) {
				ini_set('zlib.output_compression_level', $this->class->config->output->level);
			}

			ob_start('ob_gzhandler');
		}

		// load db
		$this->class->db = Zend_Db::factory($this->class->config->database);
		$this->class->db->getConnection();

		// load debug
		$this->class->debug = new Zend_Debug();

		// log
		if($this->class->config->log->adapter == 'file' && $this->class->config->log->file != '') {
                	$this->class->log_writer = new Zend_Log_Writer_Stream($this->class->config->log->file);
                	$this->class->log = new Zend_Log($this->class->log_writer);
		}

		if(!is_writable($this->class->config->cache->path))
			die('Cache path is not writeable!');

		// load cache
		$this->class->cache = Zend_Cache::factory('Core', 'File', $this->class->config->cache->options->toArray(), array('cache_dir' => $this->class->config->cache->path)); 

		// load session
		Zend_Session::start();
		$this->class->session = new Zend_Session_Namespace('default');

		// load acl
		$this->class->acl = new Crm_Acl();

		// load auth
		$this->class->auth = new Crm_Auth();

		// load locale
		if($this->class->config->core->locale != 'auto' && $this->class->config->core->locale != '') {
			$this->class->locale = new Zend_Locale($this->class->config->core->locale);
		} else {
			$this->class->locale = new Zend_Locale();
		}

		// load user
		$this->class->user = new Crm_User();

		// load translation
		Zend_Translate::setCache($this->class->cache);
		//$this->class->translation = new Zend_Translate($this->class->config->translation->adapter, $this->class->config->translation->folder . $this->class->config->core->locale, $this->class->config->core->locale);
		$this->class->translation = new Zend_Translate($this->class->config->translation->adapter, $this->class->config->translation->folder . 'en_US.mo', 'auto', array('disableNotices' => true));
		$this->class->translation->addTranslation($this->class->config->translation->folder . 'de_DE.mo', 'de_DE');
		Zend_Registry::set('Zend_Translate', $this->class->translation);

		// load layout
		Zend_Layout::startMvc();

		// load controller
                $this->class->controller = Zend_Controller_Front::getInstance();
                $this->class->controller->setControllerDirectory(
			$this->base_path . '/application/controller'
                );
                //$this->class['controller']->setParam('noViewRenderer', true);
                $this->class->controller->throwExceptions(true);

                $this->class->controller->setParam('noErrorHandler', true);

		// add plugins
		$this->class->controller->registerPlugin(new Crm_Auth_Check());

		// add routes
		$route = $this->class->controller->getRouter();

		$route->addRoute('home', new Zend_Controller_Router_Route('home', array(
			'controller' => 'index',
			'action' => 'index')));

		$route->addRoute('dashboard', new Zend_Controller_Router_Route('dashboard', array(
			'controller' => 'index',
			'action' => 'index')));

		$route->addRoute('login', new Zend_Controller_Router_Route('login', array(
			'controller' => 'index',
			'action' => 'login')));

		$route->addRoute('logout', new Zend_Controller_Router_Route('logout', array(
			'controller' => 'index',
			'action' => 'logout')));

                // run application
                $this->class->controller->dispatch();
	}
}

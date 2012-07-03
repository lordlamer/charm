<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	/**
	 *
	 */
	protected $class = null;

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
			$autoloader->registerNamespace('Crm_');

			// save in registry
			$registry = Crm_Registry::getInstance();
			$registry->set('loader', $autoloader);

			return $autoloader;
		} catch(Exception $e) {
			echo $e->getMessage();
			die('could not create autoloader');
		}
	}

	/**
	 * init registry
	 */
	protected function _initRegistry() {
		try {
			// load autoload
			$this->bootstrap('autoload');

			// define global class object
			$this->class = (object)array();

			// get instance of registry
			$this->class->registry = Crm_Registry::getInstance();

			// save class object in registry
			$this->class->registry->set('class', $this->class);

			return $this->class;
		} catch(Exception $e) {
			echo $e->getMessage();
			die('could not create registry instance');
		}
	}

	/**
	 * load config file
	 */
	protected function _initConfig() {
		try {
			// load registry
			$this->bootstrap('registry');

			// load config
			$config = new Zend_Config_Ini(PROJECT_PATH . '/config/application.ini');

			// save config in registry
			$this->class->config = $config;

			return $config;
		} catch (Exception $e) {
			echo $e->getMessage();
			die('no config file');
		}
	}

	/**
	 * init output compression
	 */
	protected function _initOutputCompression() {
		try {
			// load config
			$this->bootstrap('config');

			if($this->class->config->output->compression) {
				if($this->class->config->output->level) {
					ini_set('zlib.output_compression_level', $this->class->config->output->level);
				}

				ob_start('ob_gzhandler');
			}
		} catch(Exception $e) {
			echo $e->getMessage();
			die('could not create output compression');
		}
	}

	/**
	 * init log
	 */
	protected function _initLog() {
		try {
			// load config
			$this->bootstrap('config');

			// get config
			$config = $this->class->config;

			// create log
			$logger = new Zend_Log();

			// create writer
			$writer = new Zend_Log_Writer_Stream($config->log->file);

			// add writer
			$logger->addWriter($writer);

			// save logger in registry
			$this->class->log = $logger;

			return $logger;
		} catch (Exception $e) {
			echo $e->getMessage();
			die('could not create log');
		}
	}

	/**
	 * init debug
	 */
	protected function _initDebug() {
		try {
			// load config
			$this->bootstrap('config');

			// load debug
			$debug = new Zend_Debug();

			// save debug to registry
			$this->class->debug = $debug;

			return $debug;
		} catch(Exception $e) {
			echo $e->getMessage();
			die('could not create debug object');
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
			$config = $this->class->config;

			// start session
			Zend_Session::start($config->session->toArray());

			// save session to registry
			$session = new Zend_Session_Namespace('default');
			$this->class->session = $session;

			return $session;
		} catch (Exception $e) {
			echo $e->getMessage();
			die('Could not create session');
		}
	}

	protected function _initTranslation() {
		//try {
			// load cache
			$this->bootstrap('cache');

			// set translate cache
			//Zend_Translate::setCache($this->class->cache);

			// create translation object
			$this->class->translation = new Zend_Translate($this->class->config->translation->adapter, $this->class->config->translation->folder . '/en_US.mo', 'auto', array('disableNotices' => true));

			// add extra translation
			$this->class->translation->addTranslation($this->class->config->translation->folder . '/de_DE.mo', 'de_DE');

			// define translation to zend registry
			Zend_Registry::set('Zend_Translate', $this->class->translation);

			return $this->class->translation;
		//} catch(Exception $e) {
		//	echo $e->getMessage();
		//	die('Could not create translation object');
		//}
	}

	/**
	 * init cache
	 */
	protected function _initCache() {
		try {
			// load config
			$this->bootstrap('config');

			// get config
			$config = $this->class->config;

			// create cache
			$cache = Zend_Cache::factory($config->cache->frontend->name, $config->cache->backend->name, $config->cache->frontend->options->toArray(), $config->cache->backend->options->toArray());

			// save cache
			$this->class->cache = $cache;

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
			$config = $this->class->config;

			// get cache
			$cache = $this->class->cache;

			// make database connect
			$db = Zend_Db::factory($config->database);

			// set default adapter
			Zend_Db_Table_Abstract::setDefaultAdapter($db);

			// set cache for metadata
			Zend_Db_Table_Abstract::setDefaultMetadataCache($cache);

			// save db handle in registry
			$this->class->db = $db;

			return $db;
		} catch (Zend_Exception $e) {
			echo $e->getMessage();
			die('no database connection');
		}
	}

	/**
	 * init auth
	 */
	protected function _initAuth() {
		try {
			// load requirements
			$this->bootstrap('database');

			// create auth object
			$auth = new Crm_Auth();
			$this->class->auth = $auth;

			return $auth;
		} catch(Exception $e) {
			echo $e->getMessage();
			die('could not create auth object');
		}
	}

	/**
	 * init acl
	 */
	protected function _initAcl() {
		try {
			// load requirements
			$this->bootstrap('database');

			// create acl object
			$acl = new Crm_Acl();
			$this->class->acl = $acl;

			return $acl;
		} catch(Exception $e) {
			echo $e->getMessage();
			die('could not create acl object');
		}
	}

	/**
	 * init routes
	 */
	protected function _initRoutes() {
		try {
			// load controller
			$this->bootstrap('controller');

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
		} catch(Exception $e) {
			echo $e->getMessage();
			die('could not create routes');
		}
	}

	/**
	 * init extensions
	 */
	protected function _initExtensions() {

	}

	/**
	 * init layout
	 */
	protected function _initLayout() {
		try {
			Zend_Layout::startMvc();
		} catch(Exception $e) {
			echo $e->getMessage();
			die('could not create layout');
		}
	}

	/**
	 * init search with lucene
	 */
	protected function _initLucene() {
		try {
			// load config
			$this->bootstrap('config');

			// get config
			$config = $this->class->config;

			try {
				// open lucene index
				$lucene = Zend_Search_Lucene::open($config->lucene->save_path);
			} catch(Zend_Search_Lucene_Exception $e) {
				try {
					// create lucene index
					$lucene = Zend_Search_Lucene::create($config->lucene->save_path);
				} catch(Exception $e) {
					throw new Exception('Could not create index for lucene');
				}
			}

			// save object in registry
			$this->class->lucene = $lucene;

			return $lucene;
		} catch (Exception $e) {
			echo $e->getMessage();
			die('could not create search');
		}
	}

	/**
	 * init email
	 */
	protected function _initMail() {
		try {
			// load config
			$this->bootstrap('config');

			// get config
			$config = $this->class->config;

			// create smtp mail transport object
			if(strtolower($config->mail->transport) == 'smtp')
				$transport = new Zend_Mail_Transport_Smtp($config->mail->host, $config->mail->options->toArray());

			// create sendmail mail transport object
			if(strtolower($config->mail->transport) == 'php')
				$transport = new Zend_Mail_Transport_Sendmail($config->mail->parameters);

			// set transport as default transport
			Zend_Mail::setDefaultTransport($transport);

			return $transport;
		} catch (Exception $e) {
			echo $e->getMessage();
			die('could not create mail transport object');
		}
	}

	/**
	 * init locale
	 */
	protected function _initLocale() {
		try {
			// load config
			$this->bootstrap('config');

			// get config
			$config = $this->class->config;

			// load cache
			$this->bootstrap('cache');

			// get cache
			$cache = $this->class->cache;

			// create locale object
			$locale = new Zend_Locale('auto');

			// set default locale


			// set cache
			$locale->setCache($cache);

			// save locale in registry
			$this->class->locale = $locale;

			return $locale;
		} catch (Exception $e) {
			echo $e->getMessage();
			die('could not set locale');
		}
	}

	/**
	 * init user
	 */
	protected function _initUser() {
		try {
			// load config
			$this->bootstrap('config');

			// get config
			$config = $this->class->config;

			$user = new Crm_User();
			$this->class->user = $user;

			return $user;
		} catch(Exception $e) {
			echo $e->getMessage();
			die('could not create user object');
		}
	}

	/**
	 * init controller
	 */
	protected function _initController() {
		try {
			// load config
			$this->bootstrap('config');
			$this->bootstrap('layout');

			// get controller instance
			$this->class->controller = Zend_Controller_Front::getInstance();
			$this->class->controller->setControllerDirectory(
				$this->class->config->base->path . '/application/controller'
			);

			//$this->class['controller']->setParam('noViewRenderer', true);
			$this->class->controller->throwExceptions(true);

			$this->class->controller->setParam('noErrorHandler', true);

			return $this->class->controller;
		} catch(Exception $e) {
			echo $e->getMessage();
			die('could not create controller');
		}
	}

	protected function _initPlugins() {
		try {
			// load config
			$this->bootstrap('config');
			$this->bootstrap('controller');
			$this->class->controller->registerPlugin(new Crm_Auth_Check());
		} catch(Exception $e) {
			echo $e->getMessage();
			die('could not create plugins');
		}
	}
}


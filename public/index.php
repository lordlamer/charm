<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define path to project directory
defined('PROJECT_PATH')
    || define('PROJECT_PATH', realpath(dirname(__FILE__) . '/..'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure lib/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(PROJECT_PATH . '/lib'),
    realpath(APPLICATION_PATH . '/model'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    PROJECT_PATH . '/config/application.ini'
);
$application->bootstrap()
            ->run();

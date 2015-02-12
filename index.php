<?php

/** Setting error reporting */
//error_reporting(E_ALL);

/** Define root path to project */
define('ROOT', dirname(__FILE__).'/');

define('SITE_URL', 'http://'.$_SERVER['HTTP_HOST']);

/** Define library root */
define('LIB_ROOT', ROOT . 'library/');

/** Set project include path */
ini_set('include_path', LIB_ROOT);

/** Set PEAR library components path */
$PEAR_PATH = LIB_ROOT . 'PEAR';
set_include_path(get_include_path() . PATH_SEPARATOR . $PEAR_PATH);

/** ************************************************ */

/** Getting loader */
require_once 'Zend/Loader.php';

/** Getting usefull libs */ 
Zend_Loader::loadClass('Zend_Controller_Front');                // Front controller
Zend_Loader::loadClass('Zend_Controller_Router_Route_Regex');   // Controller router
Zend_Loader::loadClass('Zend_Cache');                           // Cache
Zend_Loader::loadClass('Zend_Db');                              // Database
Zend_Loader::loadClass('Zend_Db_Table_Abstract');               // Database abstract
Zend_Loader::loadClass('Zend_Session');                         // Session handler
Zend_Loader::loadClass('Zend_Config_Xml');                      // Configurer
Zend_Loader::loadClass('Zend_Registry');                        // Registry
Zend_Loader::loadClass('Zend_Debug');                           // Debugger


/** ************************************************ */

/** Starting session with parameters */
Zend_Session::setOptions(array('save_path' => ROOT . 'tmp/session',
                               'use_only_cookies' => 'on',
                               'remember_me_seconds' => 864000      // Remember me 10 days
                               ));
Zend_Session::start();

//Zend_Session::rememberMe(10080);

/** Database */
Zend_Loader::loadFile('Database.php', ROOT . 'backend/', true);

/** Controller */
Zend_Loader::loadFile('Router.php', ROOT . 'backend/', true);

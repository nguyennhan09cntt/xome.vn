<?php
date_default_timezone_set('Asia/Saigon');

define('SYS_PATH', str_replace('\\', '/', dirname(dirname(__FILE__))));
defined('APPLICATION_PATH') || define('APPLICATION_PATH', SYS_PATH . '/application');
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV'): 'production'));

set_include_path(implode(PATH_SEPARATOR, array(
    SYS_PATH . '/library',
    APPLICATION_PATH . '/libs',
    get_include_path(),
)));

require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance();

$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV, true);
$filename = APPLICATION_PATH . '/configs/' . APPLICATION_ENV . '.ini';
if (file_exists($filename)) {
    $config->merge(new Zend_Config_Ini($filename));
}
$filename = APPLICATION_PATH . '/modules/cli/configs/'. APPLICATION_ENV .'.ini';
if (file_exists($filename)) {
    $config->merge(new Zend_Config_Ini($filename));
}
unset($filename);
Zend_Registry::set('config', $config);

$application = new Zend_Application(APPLICATION_ENV, $config);
$application->bootstrap();
Zend_Controller_Front::getInstance()->setRouter( new Application_Cli_Router() )
    ->setRequest( new Application_Cli_Request() )
    ->setResponse( new Application_Cli_Response() )
    ->setParam('disableOutputBuffering', 1);
$application->run();
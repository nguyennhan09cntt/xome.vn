<?php
class Application_Cli_Router extends Zend_Controller_Router_Abstract
{
    public function assemble($userParams, $name = null, $reset = false, $encode = true)
    {
        return '';
    }

    public function route(Zend_Controller_Request_Abstract $dispatcher)
    {
        $frontController = $this->getFrontController();

        $module     = $dispatcher->getParam('module', 'cli');
        $controller = $dispatcher->getParam('controller', $frontController->getDefaultControllerName());
        $action     = $dispatcher->getParam('action', $frontController->getDefaultAction());

        $dispatcher->setModuleName($module);
        $dispatcher->setControllerName($controller);
        $dispatcher->setActionName($action);

        return $this;
    }
}
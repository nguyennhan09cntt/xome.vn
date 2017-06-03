<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/20/2016
 * Time: 12:18 PM
 */
class View_Helper_ConfigMenuActive extends Zend_View_Helper_Abstract
{
    public function configMenuActive($key, $controllerName, $actionName = 'index')
    {
       return ($key == $controllerName.'-'.$actionName) ? 'active' : null;
    }
}
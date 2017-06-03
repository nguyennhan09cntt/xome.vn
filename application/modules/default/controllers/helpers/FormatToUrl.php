<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/13/15
 * Time: 11:39 AM
 */
class Controller_Helper_FormatToUrl extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($string)
    {
       return Application_Function_String::getFormatUrl($string);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 3/19/15
 * Time: 2:14 PM
 */
class Admin_View_Helper_CurrentFullUrl extends Zend_View_Helper_Abstract
{
    public function currentFullUrl($optionsUrl=array())
    {
        return Application_Function_Common::buildUrl($optionsUrl);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/21/15
 * Time: 11:50 AM
 */
class Admin_View_Helper_AdminUrl extends Zend_View_Helper_Abstract
{
    public function adminUrl($path='index')
    {
        return '/' . $path;
    }
}
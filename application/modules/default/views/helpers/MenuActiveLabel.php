<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/19/2016
 * Time: 11:35 AM
 */
class View_Helper_MenuActiveLabel extends Zend_View_Helper_Abstract
{
    public function menuActiveLabel($menuIdentify , $identify)
    {
        return $menuIdentify == $identify ? 'active' : null;
    }
}
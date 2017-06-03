<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/12/15
 * Time: 11:32 AM
 */
class Controller_Helper_GroupArray extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($array, $qty)
    {
        return Application_Function_Array::group($array, $qty);
    }
}
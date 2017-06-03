<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/2/15
 * Time: 2:34 PM
 */
class Controller_Helper_GetArrayValueByRowCol extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($array, $rowName, $colName)
    {
        return isset($array[$rowName][$colName]) ? $array[$rowName][$colName] : null;
    }
}
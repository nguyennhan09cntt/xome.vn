<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/24/15
 * Time: 12:36 PM
 */
class Controller_Helper_FilterArray extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($array, $keyCondition, $condition)
    {
        $result = array();
        if ($array) {
            foreach ($array as $item) {
                if (isset($item[$keyCondition]) && $item[$keyCondition]==$condition) {
                    $result = $item;
                    break;
                }
            }
        }
        return $result;
    }
}
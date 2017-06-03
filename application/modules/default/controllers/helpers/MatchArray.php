<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 5/25/15
 * Time: 5:14 PM
 */
class Controller_Helper_MatchArray extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($arrayKey, $match)
    {
        $result = array();
        $index = 0;
        foreach ($arrayKey as $key) {
            $result[] = isset($match[$key]) ? $match[$key] : 0;
        }
        return $result;
    }
}
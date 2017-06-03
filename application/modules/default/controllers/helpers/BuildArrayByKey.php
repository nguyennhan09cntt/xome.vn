<?php
/**
 * Created by PhpStorm.
 * User: mjphong
 * Date: 27/01/2015
 * Time: 11:32
 */
class Controller_Helper_BuildArrayByKey extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($array, $keyName)
    {
        $result = array();
        if ($array) {
            foreach ($array as $item) {
                $value = isset($item[$keyName]) ? $item[$keyName] : null ;
                if ($value && !in_array($value, $result) ) {
                    $result[] = $value;
                }
            }
        }
        return $result;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/23/15
 * Time: 2:52 PM
 */
class Controller_Helper_BuildArrayInKeyAttribute extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($array, $keyName, $attributeName)
    {
        $result = array();
        if ($array) {
            foreach ($array as $item) {
                $key = isset($item[$keyName]) ? $item[$keyName] : null ;
                $attribute = isset($item[$attributeName]) ? $item[$attributeName] : null ;
                if ( !is_null($key) && !is_null($attribute) ) {
                    $result[$key] = $attribute;
                }
            }
        }
        return $result;
    }
}
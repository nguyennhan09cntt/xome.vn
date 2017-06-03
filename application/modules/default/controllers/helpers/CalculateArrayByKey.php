<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/22/15
 * Time: 2:43 PM
 */
class Controller_Helper_CalculateArrayByKey extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($array, $keyName)
    {
        $result = 0;
        if ($array) {
            foreach ($array as $item) {
                if (isset($item[$keyName])  ) {
                    $result += $item[$keyName];
                }
            }
        }
        return $result;
    }
}
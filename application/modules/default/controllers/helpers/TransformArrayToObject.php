<?php
/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/21/15
 * Time: 11:17 AM
 */
class Controller_Helper_TransformArrayToObject extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($array)
    {
        $result = new STDClass();
        if ($array) {
            foreach ($array as $key => $value) {
                $result->$key = $value;
            }
        }
        return $result;
    }
}
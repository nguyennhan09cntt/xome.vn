<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 3/17/15
 * Time: 2:33 PM
 */
class Controller_Helper_FormatPhoneNumber extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($phoneNumber)
    {
        return sprintf('84%s', substr(trim($phoneNumber), 1));
    }
}
<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/21/2016
 * Time: 10:11 PM
 */
class View_Helper_ContactEncode extends Zend_View_Helper_Abstract
{
    public function contactEncode($id)
    {
        return Model_Contact::getInstance()->encode($id);
    }
}
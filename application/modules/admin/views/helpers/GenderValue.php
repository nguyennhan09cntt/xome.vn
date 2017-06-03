<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/4/15
 * Time: 11:16 AM
 */
class Admin_View_Helper_GenderValue extends Zend_View_Helper_Abstract
{
    public function genderValue()
    {
        return array(
            Application_Constant_Global::GENDER_MALE => Application_Constant_Global::GENDER_MALE_TEXT,
            Application_Constant_Global::GENDER_FEMALE => Application_Constant_Global::GENDER_FEMALE_TEXT
        );
    }
}
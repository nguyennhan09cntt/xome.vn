<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 1/30/15
 * Time: 11:17 AM
 */
class Admin_View_Helper_GenderLabel extends Zend_View_Helper_Abstract
{
    public function genderLabel($genderValue)
    {
        $data = array(
            Application_Constant_Global::GENDER_MALE => Application_Constant_Global::GENDER_MALE_TEXT,
            Application_Constant_Global::GENDER_FEMALE => Application_Constant_Global::GENDER_FEMALE_TEXT
        );
        return isset($data[$genderValue]) ? $data[$genderValue] : null;
    }
}
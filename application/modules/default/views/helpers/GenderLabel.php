<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/5/15
 * Time: 9:25 AM
 */
class View_Helper_GenderLabel extends Zend_View_Helper_Abstract
{
    public function genderLabel($gender)
    {
        $gender = intval($gender);
        $arrayGender = array(
            0 =>'-',
            1 => 'Nam',
            2 => 'Nũ'
        );
        return $arrayGender[$gender];
    }
}
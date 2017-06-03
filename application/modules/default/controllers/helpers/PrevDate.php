<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/20/15
 * Time: 10:39 PM
 */
class Controller_Helper_PrevDate extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($date=null, $qty=1, $pattern = 'd/m/Y')
    {
        $date = $date ? $date : date(Application_Constant_Global::PATTERN_DATE);
        return date($pattern, strtotime($date) - ($qty*3600*24));
    }
}
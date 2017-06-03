<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 1/30/15
 * Time: 11:17 AM
 */
class Admin_View_Helper_ActiveValue extends Zend_View_Helper_Abstract
{
    public function activeValue()
    {
        return array(
            Application_Constant_Db_Config_Active::INACTIVE => 'Inactive',
            Application_Constant_Db_Config_Active::ACTIVE => 'Active',
        );
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 1/30/15
 * Time: 11:17 AM
 */
class Admin_View_Helper_ActiveLabel extends Zend_View_Helper_Abstract
{
    public function activeLabel($activeValue)
    {
        $data = Admin_Model_ConfigActive::getInstance()->getById($activeValue);
        return $data ? $data[DbTable_Config_Active::COL_CONFIG_ACTIVE_NAME] : null;
    }
}
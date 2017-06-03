<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 3/24/15
 * Time: 5:07 PM
 */
class Admin_View_Helper_AdminNameById extends Zend_View_Helper_Abstract
{
    public function adminNameById($id)
    {
        $data = Admin_Model_Admin::getInstance()->getInfoById($id);
        return $data ? $data[DbTable_Admin::COL_ADMIN_FULLNAME] : null;
    }
}
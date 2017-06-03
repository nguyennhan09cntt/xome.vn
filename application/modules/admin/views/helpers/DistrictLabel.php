<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/5/15
 * Time: 9:25 AM
 */
class Admin_View_Helper_DistrictLabel extends Zend_View_Helper_Abstract
{
    /**
     * Show district name
     * @param int $districtID
     * @return null
     */
    public function districtLabel($districtID)
    {
        $data = Admin_Model_District::getInstance()->getAll();
        return isset($data[$districtID]) ? $data[$districtID][DbTable_District::COL_DISTRICT_NAME] : null;
    }
}
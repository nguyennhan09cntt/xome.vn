<?php

/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/5/15
 * Time: 9:25 AM
 */
class View_Helper_DistrictIdentify extends Zend_View_Helper_Abstract
{
    /**
     * Show district name
     * @param int $districtID
     * @return null
     */
    public function districtIdentify($districtID)
    {
        $data = Model_District::getInstance()->getAll();
        if (isset($data[$districtID])) {
            $type = $data[$districtID][DbTable_District::COL_DISTRICT_TYPE] == 'Quận' ? 'quan' : 'huyen';
            return $type . '-' . $data[$districtID][DbTable_District::COL_DISTRICT_IDENTIFY];
        }
        return null;
    }
}
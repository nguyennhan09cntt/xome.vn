<?php

/**
 * Created by PhpStorm.
 * User: nhannvt
 * Date: 12/1/2015
 * Time: 5:20 PM
 */
class View_Helper_ShowProductFacility extends Zend_View_Helper_Abstract
{
    public function showProductFacility($facility)
    {

        $facility = trim($facility);
        if($facility){
            $facilityArr = explode(', ', $facility);
            $result = array();
            $facilityNameArr = Admin_Model_ConfigProductFacility::getInstance()->getAll();

            foreach ($facilityArr as $facilityId) {
                $result[] = $facilityNameArr[$facilityId][DbTable_Config_Product_Facility::COL_CONFIG_PRODUCT_FACILITY_NAME];
            }
            return implode(', ', $result);
        }
        return '';

    }
}
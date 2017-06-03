<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/21/2016
 * Time: 5:15 PM
 */
class View_Helper_ProvinceLabel extends Zend_View_Helper_Abstract
{
    public function provinceLabel($provinceID)
    {
        $provinceData = Model_Province::getInstance()->getAll();
        return isset($provinceData[$provinceID]) ? $provinceData[$provinceID][DbTable_Province::COL_PROVINCE_NAME] : null;
    }
}
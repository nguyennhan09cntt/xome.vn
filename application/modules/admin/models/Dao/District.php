<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/21/2016
 * Time: 3:59 PM
 */
class Admin_Model_Dao_District extends DbTable_District
{

    public function getByIdentify($districtIdentify)
    {
        $select = $this->select()->where(DbTable_District::COL_DISTRICT_IDENTIFY . '=?', $districtIdentify);
        return $this->fetchRow($select);
    }
}
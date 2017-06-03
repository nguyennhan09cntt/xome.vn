<?php
/**
 * Created by PhpStorm.
 * User: duyca
 * Date: 6/9/2015
 * Time: 9:32 AM
 */
class Admin_Model_Dao_ConfigSetting extends DbTable_Config_Setting
{
    /**
     * Generate search query
     * @param string $note
     * @param string $value
     * @param string $type
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($note, $value, $type)
    {
        $select = $this->select();
        if ($note) {
            $select->where(DbTable_Config_Setting::COL_CONFIG_SETTING_NOTE . '=?', $note);
        }
        if ($value) {
            $select->where(DbTable_Config_Setting::COL_CONFIG_SETTING_VALUE . '=?', $value);
        }
        if ($type) {
            $select->where(DbTable_Config_Setting::COL_CONFIG_SETTING_TYPE . '=?', $type);
        }
        $select->order(DbTable_Config_Setting::COL_CONFIG_SETTING_ID);
        return $select;
    }
}
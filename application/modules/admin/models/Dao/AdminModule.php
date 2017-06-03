<?php
/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/23/15
 * Time: 10:02 AM
 */
class Admin_Model_Dao_AdminModule extends DbTable_Admin_Module
{

    /**
     * Generate query for searching
     * @param int $componentId
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($componentId)
    {
        $select = $this->select();
        if ($componentId) {
            $select->where(DbTable_Admin_Module::COL_FK_ADMIN_COMPONENT . '=?', intval($componentId));
        }
        $select->order(DbTable_Admin_Module::COL_FK_ADMIN_COMPONENT .' asc');
        $select->order(DbTable_Admin_Module::COL_ADMIN_MODULE_PRIORITY .' desc');
        return $select;
    }

    /**
     * Get all privilege with module & resource name
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getAllPrivileges()
    {
        $select = $this->select()->setIntegrityCheck(false)
            ->from(
                DbTable_Admin_Module::_tableName,
                array(
                    DbTable_Admin_Module::COL_ADMIN_MODULE_NAME,
                    DbTable_Admin_Module::COL_FK_ADMIN_COMPONENT
                )
            )
            ->join(
                DbTable_Admin_Resource::_tableName,
                sprintf(
                    '%s=%s',
                    DbTable_Admin_Module::COL_ADMIN_MODULE_ID,
                    DbTable_Admin_Resource::COL_FK_ADMIN_MODULE
                ),
                array(
                    DbTable_Admin_Resource::COL_ADMIN_RESOURCE_NAME
                )
            )
            ->join(
                DbTable_Admin_Privilege::_tableName,
                sprintf(
                    '%s=%s',
                    DbTable_Admin_Resource::COL_ADMIN_RESOURCE_ID,
                    DbTable_Admin_Privilege::COL_FK_ADMIN_RESOURCE
                ),
                array(
                    DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_ID,
                    DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_NAME
                )
            )
            ->where(DbTable_Admin_Resource::COL_ADMIN_RESOURCE_ACTIVE . '=?', Application_Constant_Db_Config_Active::ACTIVE)
            ->where(DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_ACTIVE . '=?', Application_Constant_Db_Config_Active::ACTIVE)
            ->order(DbTable_Admin_Module::COL_FK_ADMIN_COMPONENT . ' asc')
            ->order(DbTable_Admin_Module::COL_ADMIN_MODULE_PRIORITY . ' desc')
            ->order(DbTable_Admin_Resource::COL_ADMIN_RESOURCE_PRIORITY . ' desc')
            ->order(DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_PRIORITY . ' desc')
        ;
        return $this->fetchAll($select);
    }
}
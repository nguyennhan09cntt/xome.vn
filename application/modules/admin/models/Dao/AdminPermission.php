<?php
/**
 * Created by PhpStorm.
 * User: duyca
 * Date: 10/7/2015
 * Time: 9:31 AM
 */
class Admin_Model_Dao_AdminPermission extends DbTable_Admin_Permission
{
    /**
     * Query Permission by admin ID
     * @param int $fk_admin
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function searchByAdminId($fk_admin)
    {
        $select = $this->select()->setIntegrityCheck(false)
            ->from(DbTable_Admin_Permission::_tableName, null)
            ->join(
                DbTable_Admin_Privilege::_tableName,
                sprintf('%s=%s', DbTable_Admin_Permission::COL_FK_ADMIN_PRIVILEGE, DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_ID),
                array(
                    DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_ID,
                    DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_NAME,
                    DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_ACTION,
                    DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_DISPLAY
                )
            )
            ->join(
                DbTable_Admin_Resource::_tableName,
                sprintf('%s=%s', DbTable_Admin_Privilege::COL_FK_ADMIN_RESOURCE, DbTable_Admin_Resource::COL_ADMIN_RESOURCE_ID),
                array(
                    DbTable_Admin_Resource::COL_ADMIN_RESOURCE_DISPLAY,
                    DbTable_Admin_Resource::COL_ADMIN_RESOURCE_NAME,
                    DbTable_Admin_Resource::COL_ADMIN_RESOURCE_CONTROLLER
                )
            )
            ->join(
                DbTable_Admin_Module::_tableName,
                sprintf('%s=%s', DbTable_Admin_Resource::COL_FK_ADMIN_MODULE, DbTable_Admin_Module::COL_ADMIN_MODULE_ID),
                array(
                    DbTable_Admin_Module::COL_FK_ADMIN_COMPONENT,
                    DbTable_Admin_Module::COL_ADMIN_MODULE_NAME,
                    DbTable_Admin_Module::COL_ADMIN_MODULE_ID
                )
            )
            ->where(DbTable_Admin_Permission::COL_FK_ADMIN . '=?', intval($fk_admin))
            ->where(DbTable_Admin_Resource::COL_ADMIN_RESOURCE_ACTIVE . '=?', Application_Constant_Db_Config_Active::ACTIVE)
            ->where(DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_ACTIVE . '=?', Application_Constant_Db_Config_Active::ACTIVE)
            ->order(DbTable_Admin_Module::COL_ADMIN_MODULE_PRIORITY . ' DESC')
            ->order(DbTable_Admin_Resource::COL_ADMIN_RESOURCE_PRIORITY . ' DESC')
            ->order(DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_PRIORITY . ' DESC')
        ;
        return $this->fetchAll($select);
    }

    /**
     * Delete Permission by admin admin ID
     * @param int $adminId
     * @return int
     */
    public function deleteByAdminId($adminId)
    {
        $where = sprintf(
            '%s=%d',
            DbTable_Admin_Permission::COL_FK_ADMIN,
            intval($adminId)
        );
        return $this->delete($where);
    }
}
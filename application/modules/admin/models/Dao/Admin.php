<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10/4/14
 * Time: 10:49 AM
 */
class Admin_Model_Dao_Admin extends DbTable_Admin
{
    public function updateLastLogin($timeStamp, $ipAddress, $idAdmin)
    {
        $params = array(
            DbTable_Admin::COL_ADMIN_LAST_LOGIN => $timeStamp,
            DbTable_Admin::COL_ADMIN_LAST_LOGIN_IP => $ipAddress
        );
        return $this->update($params, sprintf('%s=%s', DbTable_Admin::COL_ADMIN_ID, intval($idAdmin)));
    }

    /**
     * Search by email
     * @param string $email
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function searchByEmail($email)
    {
        return $this->fetchRow(
            $this->select()->where(DbTable_Admin::COL_ADMIN_EMAIL . '=?', $email)
        );
    }

    /**
     * Search by Fk role
     * @param int $fk_role
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function searchByFkRole($fk_role)
    {
        return $this->fetchAll(
            $this->select()->where(DbTable_Admin::COL_FK_ADMIN_ROLE . '=?', $fk_role)
        );
    }

    /**
     * Update password by admin ID
     * @param int $adminId
     * @param string $password
     * @return int
     */
    public function updatePasswordById($adminId, $password)
    {
        $params = array(
            DbTable_Admin::COL_ADMIN_PASSWORD => md5($password)
        );
        return $this->update($params, sprintf('%s=%d', DbTable_Admin::COL_ADMIN_ID, intval($adminId)));
    }

    /**
     * Update info by admin ID
     * @param int $adminId
     * @param string $fullName
     * @param string $password
     * @return int
     */
    public function updateInfo($adminId, $fullName, $password)
    {
        $params = array(
            DbTable_Admin::COL_ADMIN_PASSWORD => md5($password),
            DbTable_Admin::COL_ADMIN_FULLNAME => trim($fullName)
        );
        return $this->update($params, sprintf('%s=%d', DbTable_Admin::COL_ADMIN_ID, intval($adminId)));
    }

    /**
     * Generate search query
     * @param string $email
     * @param int $fkRole
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($email, $fkRole)
    {
        $select = $this->select()->setIntegrityCheck(false)
            ->from(DbTable_Admin::_tableName)
            ->join(
                DbTable_Admin_Role::_tableName,
                sprintf(
                    '%s=%s',
                    DbTable_Admin::COL_FK_ADMIN_ROLE,
                    DbTable_Admin_Role::COL_ADMIN_ROLE_ID
                ),
                array(DbTable_Admin_Role::COL_ADMIN_ROLE_NAME)
            );
        if ($email) {
            $select->where(DbTable_Admin::COL_ADMIN_EMAIL . '=?', $email);
        }
        if ($fkRole) {
            $select->where(DbTable_Admin::COL_FK_ADMIN_ROLE . '=?', $fkRole);
        }
        #$select->where(DbTable_Admin::COL_ADMIN_ID . '<>?', Application_Constant_Db_Admin::ADMIN_ROOT);
        $select->order(DbTable_Admin::COL_ADMIN_ID);
        return $select;
    }

    /**
     * Get all administrator information
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getAllInfo()
    {
        return $this->fetchAll(
            $this->select()->from(
                DbTable_Admin::_tableName,
                array(DbTable_Admin::COL_ADMIN_ID, DbTable_Admin::COL_ADMIN_FULLNAME, DbTable_Admin::COL_FK_ADMIN_ROLE)
            )
        );
    }

    /**
     * Get all privilege with module & resource name
     * @param int $fk_role
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getAllPrivilegesByFkAdminRole($fk_role)
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
            ->join(
                DbTable_Admin_Acl::_tableName,
                sprintf(
                    '%s=%s',
                    DbTable_Admin_Acl::COL_FK_ADMIN_PRIVILEGE,
                    DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_ID
                ),
                null
            )
            ->where(DbTable_Admin_Acl::COL_FK_ADMIN_ROLE . '=?', $fk_role)
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
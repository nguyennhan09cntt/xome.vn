<?php
/**
 * Created by PhpStorm.
 * User: duyca
 * Date: 10/7/2015
 * Time: 9:50 AM
 */
class Admin_Model_AdminPermission extends Application_Singleton
{
    /**
     * @var Admin_Model_Dao_AdminPermission
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_AdminPermission();
    }

    /**
     * Get Permission by role ID
     * @param int $fk_admin
     * @return array
     */
    public function searchByAdminId($fk_admin)
    {
        $result = array();
        $key = Application_Cache_Admin::getInstance()->adminPermission($fk_admin);
        $result = Application_Cache::getInstance()->load($key);
        if (!$result) {
            $PermissionData = $this->_dao->searchByAdminId(intval($fk_admin));
            $result = $PermissionData ? $PermissionData->toArray() : array();
            Application_Cache::getInstance()->save(
                $result,
                $key,
                Application_Constant_Cache::ADMIN_PERMISSION_LIFE_TIME
            );
        }
        return $result;
    }

    /**
     * Insert new Permission
     * @param int $adminId
     * @param int $privilegeId
     * @return mixed
     */
    public function insert($adminId, $privilegeId)
    {
        $params = array(
            DbTable_Admin_Permission::COL_FK_ADMIN => intval($adminId),
            DbTable_Admin_Permission::COL_FK_ADMIN_PRIVILEGE => intval($privilegeId),
            DbTable_Admin_Permission::COL_ADMIN_PERMISSION_CREATED_AT => $this->_dao->mysqlSysDate()
        );
        return $this->_dao->insert($params);
    }

    /**
     * Delete Permission by admin role ID
     * @param int $adminId
     * @return int
     */
    public function deleteByAdminId($adminId)
    {
        $adminId = intval($adminId);
        Application_Cache_Admin::getInstance()->resetAdminPermission($adminId);
        return $this->_dao->deleteByAdminId($adminId);
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/21/15
 * Time: 4:55 PM
 */
class Admin_Model_AdminAcl extends Application_Singleton
{
    /**
     * @var Admin_Model_Dao_AdminAcl
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_AdminAcl();
    }

    /**
     * Get ACL by role ID
     * @param int $roleId
     * @return array
     */
    public function searchByRoleId($roleId)
    {
        $result = array();
        $key = Application_Cache_Admin::getInstance()->adminAcl($roleId);
        $result = Application_Cache::getInstance()->load($key);
        if (!$result) {
            $aclData = $this->_dao->searchByRoleId(intval($roleId));
            $result = $aclData ? $aclData->toArray() : array();
            Application_Cache::getInstance()->save(
                $result,
                $key,
                Application_Constant_Cache::ADMIN_ACL_LIFE_TIME
            );
        }
        return $result;
    }

    /**
     * Delete ACL by admin role ID
     * @param int $roleId
     * @return int
     */
    public function deleteByRoleId($roleId)
    {
        $roleId = intval($roleId);
        Application_Cache_Admin::getInstance()->resetadminAcl($roleId);
        return $this->_dao->deleteByRoleId($roleId);
    }

    /**
     * Insert new ACL
     * @param int $roleId
     * @param int $privilegeId
     * @return mixed
     */
    public function insert($roleId, $privilegeId)
    {
        $params = array(
            DbTable_Admin_Acl::COL_FK_ADMIN_ROLE => intval($roleId),
            DbTable_Admin_Acl::COL_FK_ADMIN_PRIVILEGE => intval($privilegeId)
        );
        return $this->_dao->insert($params);
    }

    /**
     * Clear cache all admin_role
     */
    public function clearCacheAllRole()
    {
        $roleArr = Admin_Model_AdminRole::getInstance()->getAll();
        if ($roleArr) {
            foreach ($roleArr as $role) {
                Application_Cache_Admin::getInstance()->resetadminAcl($role[DbTable_Admin_Role::COL_ADMIN_ROLE_ID]);
            }
        }
    }
}
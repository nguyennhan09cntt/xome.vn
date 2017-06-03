<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10/4/14
 * Time: 10:49 AM
 */
class Admin_Model_Admin extends Application_Singleton
{
    /**
     * @var Admin_Model_Dao_Admin
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_Admin();
    }

    /**
     * update last login time
     * @param int $idAdmin
     * @return int
     */
    public function updateLastLogin($idAdmin)
    {
        return $this->_dao->updateLastLogin(date('Y-m-d H:i:s'), $_SERVER['REMOTE_ADDR'], intval($idAdmin));
    }

    /**
     * Get admin info by email
     * @param string $email
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function searchByEmail($email)
    {
        $email = View_Filter_Db_Admin_Email::getInstance()->filter($email);
        return $this->_dao->searchByEmail($email);
    }

    /**
     * Get admin info by Fk role
     * @param int $fk_role
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function searchByFkRole($fk_role)
    {
        $fk_role = intval($fk_role);
        return $this->_dao->searchByFkRole($fk_role);
    }

    /**
     * Update password by admin ID
     * @param int $adminId
     * @param string $password
     * @return int
     */
    public function updatePasswordById($adminId, $password)
    {
        $adminId = intval($adminId);
        $password = View_Filter_Db_Admin_Password::getInstance()->filter($password);
        return $this->_dao->updatePasswordById($adminId, $password);
    }

    /**
     * update info
     * @param $adminId
     * @param $fullName
     * @param $password
     * @return int
     */
    public function updateInfo($adminId, $fullName, $password)
    {
        $adminId = intval($adminId);
        $password = View_Filter_Db_Admin_Password::getInstance()->filter($password);
        return $this->_dao->updateInfo($adminId, $fullName, $password);
    }


    /**
     * Generate search query
     * @param string $email
     * @param int $fkRole
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($email, $fkRole)
    {
        $email = View_Filter_Db_Admin_Email::getInstance()->filter($email);
        $fkRole = intval($fkRole);
        return $this->_dao->searchQuery($email, $fkRole);
    }

    /**
     * @param string $email
     * @param string $password
     * @param string $fullName
     * @param int $fkRole
     * @return null|string
     */
    public function insert($email, $password, $fullName, $fkRole)
    {
        $email = View_Filter_Db_Admin_Email::getInstance()->filter($email);
        $password = trim($password);
        $fullName = trim($fullName);
        $fkRole = intval($fkRole);
        $result = null;
        try {
            $params = array(
                DbTable_Admin::COL_ADMIN_EMAIL => $email,
                DbTable_Admin::COL_ADMIN_PASSWORD => md5($password),
                DbTable_Admin::COL_ADMIN_FULLNAME => $fullName,
                DbTable_Admin::COL_FK_ADMIN_ROLE => $fkRole
            );
            $result = $this->_dao->insertAndGetLastInsertId($params);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    /**
     * Update administrator information
     * @param int $id
     * @param string $fullName
     * @param int $fkRole
     * @return null|string
     */
    public function update($id, $fullName, $fkRole)
    {
        $id = intval($id);
        $fullName = trim($fullName);
        $fkRole = intval($fkRole);
        $result = null;
        try {
            $params = array(
                DbTable_Admin::COL_ADMIN_FULLNAME => $fullName,
                DbTable_Admin::COL_FK_ADMIN_ROLE => $fkRole
            );
            $where = sprintf(
                '%s IN (%s)',
                DbTable_Admin::COL_ADMIN_ID,
                $this->_dao->getAdapter()->quote($id)
            );
            $this->_dao->update($params, $where);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    /**
     * Manual update activate by Array|Single ID
     * @param int $value
     * @param array|int $id
     * @return int
     */
    public function manualUpdateActive($value, $id)
    {
        $where = sprintf(
            '%s IN (%s)',
            DbTable_Admin::COL_ADMIN_ID,
            $this->_dao->getAdapter()->quote($id)
        );
        $params = array(DbTable_Admin::COL_ADMIN_ACTIVE => intval($value));
        return $this->_dao->update($params, $where);
    }

    /**
     * Get by Id
     * @param array|int $id
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getById($id)
    {
        $id = intval($id);
        return $this->_dao->find($id);
    }

    /**
     * Get all administrator information
     * @return array|false|mixed|null
     */
    public function getAllInfo()
    {
        $result = array();
        $key = Application_Cache_Admin::getInstance()->adminInfo();
        $result = Application_Cache::getInstance()->load($key);
        if (!$result) {
            $data = $this->_dao->getAllInfo();
            foreach ($data as $item) {
                $result[$item->{DbTable_Admin::COL_ADMIN_ID}] = $item->toArray();
            }
            Application_Cache::getInstance()->save(
                $result,
                $key,
                Application_Constant_Cache::ADMIN_PRIVILEGE_LIFE_TIME
            );
        }
        return $result;
    }

    /**
     * Get admin information by ID
     * @param int $id
     * @return null
     */
    public function getInfoById($id)
    {
        $data = $this->getAllInfo();
        return isset($data[$id]) ? $data[$id] : null;
    }

    /**
     * Get all privilege with module & resource name
     * @param int $fk_role
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getAllPrivilegesByFkAdminRole($fk_role)
    {
        $result = array();
        $privilegeData = $this->_dao->getAllPrivilegesByFkAdminRole($fk_role);
        if ($privilegeData) {
            foreach ($privilegeData as $data) {
                $module = sprintf(
                    '%s | %s',
                    Admin_Model_AdminComponent::getInstance()->getNameById($data->{DbTable_Admin_Module::COL_FK_ADMIN_COMPONENT}),
                    $data->{DbTable_Admin_Module::COL_ADMIN_MODULE_NAME}
                );
                if (!isset($result[$module])) {
                    $result[$module] = array();
                }
                $resource = $data->{DbTable_Admin_Resource::COL_ADMIN_RESOURCE_NAME};
                if (!isset($result[$module][$resource])) {
                    $result[$module][$resource] = array();
                }
                $result[$module][$resource][] = array(
                    DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_ID => $data->{DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_ID},
                    DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_NAME => $data->{DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_NAME}
                );
            }
        }
        return $result;
    }
}
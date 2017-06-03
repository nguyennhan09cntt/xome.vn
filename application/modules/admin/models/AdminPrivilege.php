<?php
/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/21/15
 * Time: 4:40 PM
 */
class Admin_Model_AdminPrivilege extends Application_Singleton
{
    /**
     * @var Admin_Model_Dao_AdminPrivilege
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_AdminPrivilege();
    }

    /**
     * Query all data
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getAll()
    {
        $result = array();
        $result = Application_Cache::getInstance()->load(
            Application_Cache_Admin::getInstance()->adminPrivilege()
        );
        if (!$result) {
            $data = $this->_dao->getAll();
            $result = $data ? $data->toArray() : null;
            Application_Cache::getInstance()->save(
                $result,
                Application_Cache_Admin::getInstance()->adminPrivilege(),
                Application_Constant_Cache::ADMIN_PRIVILEGE_LIFE_TIME
            );
        }
        return $result;
    }

    /**
     * Check if controller-action is included to privilege list or not
     * @param string $controller
     * @param string $action
     * @return bool
     */
    public function isIncluded($controller, $action)
    {
        $result = false;
        $privilegeData = $this->getAll();
        if ($privilegeData) {
            foreach ($privilegeData as $data) {
                if ($controller==$data[DbTable_Admin_Resource::COL_ADMIN_RESOURCE_CONTROLLER]
                && $action==$data[DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_ACTION]) {
                    $result = true;
                    break;
                }
            }
        }
        return $result;
    }

    /**
     * Query for search function
     * @param int $fkResource
     * @return Zend_Db_Select
     */
    public function searchQuery($fkResource)
    {
        return $this->_dao->searchQuery($fkResource);
    }

    /**
     * Insert new privilege
     * @param string $privilegeName
     * @param string $actionName
     * @param int $priority
     * @param int $fkResource
     * @return null|string
     */
    public function insert($privilegeName, $actionName, $priority, $fkResource)
    {
        $privilegeName = trim($privilegeName);
        $actionName = trim($actionName);
        $priority = intval($priority);
        $fkResource = intval($fkResource);
        $result = null;
        try {
            $params = array(
                DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_NAME => $privilegeName,
                DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_ACTION => $actionName,
                DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_PRIORITY => $priority,
                DbTable_Admin_Privilege::COL_FK_ADMIN_RESOURCE => $fkResource
            );
            $this->_dao->insert($params);
            Application_Cache_Admin::getInstance()->resetAdminPrivilege();
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    /**
     * Update privilege information
     * @param int $id
     * @param string $privilegeName
     * @param string $actionName
     * @param int $priority
     * @param int $fkResource
     * @return null|string
     */
    public function update($id, $privilegeName, $actionName, $priority, $fkResource)
    {
        Admin_Model_AdminAcl::getInstance()->clearCacheAllRole();

        $id = intval($id);
        $privilegeName = trim($privilegeName);
        $actionName = trim($actionName);
        $priority = intval($priority);
        $fkResource = intval($fkResource);
        $result = null;
        try {
            $params = array(
                DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_NAME => $privilegeName,
                DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_ACTION => $actionName,
                DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_PRIORITY => $priority,
                DbTable_Admin_Privilege::COL_FK_ADMIN_RESOURCE => $fkResource
            );
            $where = sprintf(
                '%s IN (%s)',
                DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_ID,
                $this->_dao->getAdapter()->quote($id)
            );
            $this->_dao->update($params, $where);
            Application_Cache_Admin::getInstance()->resetAdminPrivilege();
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
        Admin_Model_AdminAcl::getInstance()->clearCacheAllRole();

        $where = sprintf(
            '%s IN (%s)',
            DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_ID,
            $this->_dao->getAdapter()->quote($id)
        );
        $params = array(DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_ACTIVE => intval($value));

        Application_Cache_Admin::getInstance()->resetAdminPrivilege();
        return $this->_dao->update($params, $where);
    }

    /**
     * Manual update display by Array|Single ID
     * @param int $value
     * @param array|int $id
     * @return int
     */
    public function manualUpdateDisplay($value, $id)
    {
        Admin_Model_AdminAcl::getInstance()->clearCacheAllRole();

        $where = sprintf(
            '%s IN (%s)',
            DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_ID,
            $this->_dao->getAdapter()->quote($id)
        );
        $params = array(DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_DISPLAY => intval($value));

        Application_Cache_Admin::getInstance()->resetAdminPrivilege();
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
}
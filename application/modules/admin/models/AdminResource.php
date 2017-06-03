<?php
/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/21/15
 * Time: 4:37 PM
 */
class Admin_Model_AdminResource extends Application_Singleton
{
    /**
     * @var Admin_Model_Dao_AdminResource
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_AdminResource();
    }

    /**
     * Query all data
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getAll()
    {
        return $this->_dao->fetchAll();
    }

    /**
     * Query for search function
     * @param int $fkModule
     * @return Zend_Db_Select
     */
    public function searchQuery($fkModule)
    {
        return $this->_dao->searchQuery($fkModule);
    }

    /**
     * Insert new resource
     * @param string $resourceName
     * @param string $controllerName
     * @param int $priority
     * @param int $fkModule
     * @return null|string
     */
    public function insert($resourceName, $controllerName, $priority, $fkModule)
    {
        $resourceName = trim($resourceName);
        $controllerName = trim($controllerName);
        $priority = intval($priority);
        $fkModule = intval($fkModule);
        $result = null;
        try {
            $params = array(
                DbTable_Admin_Resource::COL_ADMIN_RESOURCE_NAME => $resourceName,
                DbTable_Admin_Resource::COL_ADMIN_RESOURCE_CONTROLLER => $controllerName,
                DbTable_Admin_Resource::COL_ADMIN_RESOURCE_PRIORITY => $priority,
                DbTable_Admin_Resource::COL_FK_ADMIN_MODULE => $fkModule
            );
            $this->_dao->insert($params);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    /**
     * Update resource
     * @param int $id
     * @param string $resourceName
     * @param string $controllerName
     * @param int $priority
     * @param int $fkModule
     * @return null|string
     */
    public function update($id, $resourceName, $controllerName, $priority, $fkModule)
    {
        $id = intval($id);
        $resourceName = trim($resourceName);
        $controllerName = trim($controllerName);
        $priority = intval($priority);
        $fkModule = intval($fkModule);
        $result = null;
        try {
            $params = array(
                DbTable_Admin_Resource::COL_ADMIN_RESOURCE_NAME => $resourceName,
                DbTable_Admin_Resource::COL_ADMIN_RESOURCE_CONTROLLER => $controllerName,
                DbTable_Admin_Resource::COL_ADMIN_RESOURCE_PRIORITY => $priority,
                DbTable_Admin_Resource::COL_FK_ADMIN_MODULE => $fkModule
            );
            $where = sprintf(
                '%s IN (%s)',
                DbTable_Admin_Resource::COL_ADMIN_RESOURCE_ID,
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
        Admin_Model_AdminAcl::getInstance()->clearCacheAllRole();

        $where = sprintf(
            '%s IN (%s)',
            DbTable_Admin_Resource::COL_ADMIN_RESOURCE_ID,
            $this->_dao->getAdapter()->quote($id)
        );
        $params = array(DbTable_Admin_Resource::COL_ADMIN_RESOURCE_ACTIVE => intval($value));
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
            DbTable_Admin_Resource::COL_ADMIN_RESOURCE_ID,
            $this->_dao->getAdapter()->quote($id)
        );
        $params = array(DbTable_Admin_Resource::COL_ADMIN_RESOURCE_DISPLAY => intval($value));
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
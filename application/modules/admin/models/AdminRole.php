<?php
/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/21/15
 * Time: 4:21 PM
 */
class Admin_Model_AdminRole extends Application_Singleton
{
    /**
     * @var Admin_Model_Dao_AdminRole
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_AdminRole();
    }

    /**
     * Get all roles
     * @return array
     */
    public function getAll()
    {
        $data = $this->_dao->fetchAll();
        return $data ? $data->toArray() : array();
    }

    /**
     * Query for search function
     * @return Zend_Db_Select
     */
    public function searchQuery()
    {
        return $this->_dao->searchQuery();
    }

    /**
     * Insert & return last insert Id
     * @param string $roleName
     * @return int
     */
    public function insert($roleName)
    {
        $roleName = trim($roleName);
        $params = array(
            DbTable_Admin_Role::COL_ADMIN_ROLE_NAME => $roleName
        );
        return $this->_dao->insertAndGetLastInsertId($params);
    }

    /**
     * Update role information
     * @param int $id
     * @param string $roleName
     * @return null|string
     */
    public function update($id, $roleName)
    {
        $id = intval($id);
        $roleName = trim($roleName);
        $result = null;
        try {
            $params = array(
                DbTable_Admin_Role::COL_ADMIN_ROLE_NAME => $roleName
            );
            $where = sprintf(
                '%s IN (%s)',
                DbTable_Admin_Role::COL_ADMIN_ROLE_ID,
                $this->_dao->getAdapter()->quote($id)
            );
            $this->_dao->update($params, $where);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
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
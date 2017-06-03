<?php
/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/21/15
 * Time: 4:40 PM
 */
class Admin_Model_Dao_AdminPrivilege extends DbTable_Admin_Privilege
{
    /**
     * Get all privilege data including controller name
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getAll()
    {
        return $this->fetchAll($this->searchQuery(0));
    }

    /**
     * Get search query
     * @param int $fkResource
     * @return Zend_Db_Select
     */
    public function searchQuery($fkResource)
    {
        $select = $this->select()->setIntegrityCheck(false)
            ->from(DbTable_Admin_Privilege::_tableName)
            ->join(
                DbTable_Admin_Resource::_tableName,
                sprintf('%s=%s', DbTable_Admin_Privilege::COL_FK_ADMIN_RESOURCE, DbTable_Admin_Resource::COL_ADMIN_RESOURCE_ID),
                array(
                    DbTable_Admin_Resource::COL_ADMIN_RESOURCE_CONTROLLER,
                    DbTable_Admin_Resource::COL_ADMIN_RESOURCE_NAME
                )
            )
        ;
        if ($fkResource) {
            $select->where(DbTable_Admin_Privilege::COL_FK_ADMIN_RESOURCE . '=?', intval($fkResource));
        }
        $select->order(DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_PRIORITY . ' desc');
        return $select;
    }
}
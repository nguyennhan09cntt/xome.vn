<?php
/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/21/15
 * Time: 4:36 PM
 */
class Admin_Model_Dao_AdminResource extends DbTable_Admin_Resource
{
    /**
     * Get search query
     * @param int $fkModule
     * @return Zend_Db_Select
     */
    public function searchQuery($fkModule)
    {
        $select = $this->select()->setIntegrityCheck(false)
            ->from(DbTable_Admin_Resource::_tableName)
            ->join(
                DbTable_Admin_Module::_tableName,
                sprintf('%s=%s', DbTable_Admin_Module::COL_ADMIN_MODULE_ID, DbTable_Admin_Resource::COL_FK_ADMIN_MODULE),
                array(DbTable_Admin_Module::COL_ADMIN_MODULE_NAME)
            );
        if ($fkModule) {
            $select->where(DbTable_Admin_Resource::COL_FK_ADMIN_MODULE . '=?', intval($fkModule));
        }
        $select->order(DbTable_Admin_Resource::COL_FK_ADMIN_MODULE . ' DESC');
        $select->order(DbTable_Admin_Resource::COL_ADMIN_RESOURCE_PRIORITY . ' DESC');
        return $select;
    }
}
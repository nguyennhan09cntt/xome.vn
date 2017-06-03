<?php
/**
 * Created by PhpStorm.
 * User: duyca
 * Date: 5/29/2015
 * Time: 4:16 PM
 */
class Cli_Model_Dao_Admin extends DbTable_Admin
{
    /**
     * Get admin info by fk_admin_role
     * @param int $fk_admin_role
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function searchByAdminRoleId($fk_admin_role)
    {
        return $this->fetchAll(
            $this->select()->where(DbTable_Admin::COL_FK_ADMIN_ROLE . '=?', $fk_admin_role)
        );
    }
}
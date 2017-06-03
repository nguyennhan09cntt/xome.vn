<?php
/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/21/15
 * Time: 4:21 PM
 */
class Admin_Model_Dao_AdminRole extends DbTable_Admin_Role
{
    /**
     * Get search query
     * @return Zend_Db_Select
     */
    public function searchQuery()
    {
        return $this->select();
    }
}
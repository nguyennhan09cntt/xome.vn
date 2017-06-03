<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 6/18/2016
 * Time: 2:54 PM
 */
class Admin_Model_Dao_Contact extends DbTable_Contact
{

    /**
     *
     * @param string $name
     * @param int $fkActive
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($name, $fkActive)
    {
        $select = $this->select();

        if ($name) {
            $select->where(sprintf('%s like %s', new Zend_Db_Expr ('LOWER(' . DbTable_Contact::COL_CONTACT_NAME . ')'), $this->getAdapter()->quote('%' . strtolower($name) . '%')));
        }

        if ($fkActive > -1) {
            $select->where(DbTable_Contact::COL_CONTACT_STATUS . ' =?', $fkActive);
        }
        $select->order(DbTable_Contact::COL_CONTACT_CREATED_AT . ' desc');
        $select->order(DbTable_Contact::COL_CONTACT_NAME . ' asc');

        return $select;
    }

}
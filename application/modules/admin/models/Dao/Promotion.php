<?php

/**
 * Created by PhpStorm.
 * User: nhannvt
 * Date: 10/22/2015
 * Time: 9:02 AM
 */
class Admin_Model_Dao_Promotion extends DbTable_Promotion
{
    /**
     * @param int $fkConfigComponent
     * @param string $title
     * @param int $active
     * @param $expiredDate
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($fkConfigComponent, $title, $active, $expiredDate)
    {
        $select = $this->select();
        if ($fkConfigComponent > -1) {
            $select->where(DbTable_Promotion::COL_FK_CONFIG_COMPONENT . '=?', $fkConfigComponent);
        }
        if ($title) {
            $select->where(
                sprintf(
                    '%s like %s',
                    new Zend_Db_Expr('LOWER(' . DbTable_Promotion::COL_PROMOTION_TITLE . ')'),
                    $this->getAdapter()->quote('%' . strtolower($title) . '%')
                )
            );
        }
        if ($active > -1) {
            $select->where(
                sprintf(
                    '%s = %s',
                    DbTable_Promotion::COL_PROMOTION_ACTIVE,
                    $active
                )
            );
        }
        if ($expiredDate) {
            $select->where(
                sprintf(
                    'DATE(%s) = %s',
                    DbTable_Promotion::COL_PROMOTION_EXPIRED_DATE,
                    $this->getAdapter()->quote($expiredDate)
                )
            );
        }
        $select->order(DbTable_Promotion::COL_PROMOTION_ID . ' DESC');
        return $select;
    }
}
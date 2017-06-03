<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 8/9/2016
 * Time: 8:03 AM
 */
class Admin_Model_Dao_ProductFacility extends DbTable_Product_Facility
{

    /**
     * Delete facility by $productId
     * @param int $productId
     * @return int
     */
    public function deleteByProductId($productId)
    {
        $where = sprintf(
            '%s=%d',
            DbTable_Product_Facility::COL_PRODUCT_ID,
            intval($productId)
        );
        return $this->delete($where);
    }

    /**
     * @param $productId
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function searchByProductId($productId)
    {
        $select = $this->select()->setIntegrityCheck(false)
            ->from(DbTable_Product_Facility::_tableName)
            ->join(
                DbTable_Product::_tableName,
                sprintf(
                    '%s.%s=%s.%s',
                    DbTable_Product::_tableName,
                    DbTable_Product::COL_PRODUCT_ID,
                    DbTable_Product_Facility::_tableName,
                    DbTable_Product_Facility::COL_PRODUCT_ID
                ),
                array()
            )
            ->where(
                sprintf(
                    '%s.%s=%d',
                    DbTable_Product::_tableName,
                    DbTable_Product::COL_PRODUCT_ID,
                    $productId
                )
            );
        //$select->assemble()

        return $this->fetchAll($select);
    }

}
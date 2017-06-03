<?php

/**
 * Created by PhpStorm.
 * User: nguyennhan09cntt
 * Date: 5/11/2015
 * Time: 4:36 PM
 */
class Cli_Model_Dao_Product extends DbTable_Product
{
    public function duplicate()
    {
        $select = $this->select()->setIntegrityCheck(false)
            ->from(
                DbTable_Product::_tableName,
                array(
                    sprintf(
                        '%s.%s',
                        DbTable_Product::_tableName,
                        DbTable_Product::COL_PRODUCT_ID
                    ),
                    'ids' => new Zend_Db_Expr(
                        sprintf(
                            'GROUP_CONCAT(%s.%s SEPARATOR ", ")',
                            'p2',
                            DbTable_Product::COL_PRODUCT_ID
                        )
                    )

                )
            )
            ->join(
                array('p2' => DbTable_Product::_tableName),
                sprintf(
                    '%s.%s = %s.%s',
                    'p2',
                    DbTable_Product::COL_PRODUCT_IDENTIFY,
                    DbTable_Product::_tableName,
                    DbTable_Product::COL_PRODUCT_IDENTIFY
                ),
                array()
            )
            ->group(
                sprintf(
                    '%s.%s',
                    DbTable_Product::_tableName,
                    DbTable_Product::COL_PRODUCT_IDENTIFY
                )
            );
        return $this->fetchAll($select);
    }


    /**
     * @param $productIdentify
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function getDetail($productIdentify)
    {
        $select = $this->select()
            ->from(
                DbTable_Product::_tableName,
                array(
                    DbTable_Product::COL_PRODUCT_ID,
                )
            )
            ->where(
                sprintf(
                    '%s.%s = %s',
                    DbTable_Product::_tableName,
                    DbTable_Product::COL_PRODUCT_IDENTIFY,
                    $this->getAdapter()->quote($productIdentify)
                )
            );
        return $this->fetchRow($select);
    }
}
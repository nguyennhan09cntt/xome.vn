<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/21/2016
 * Time: 4:31 PM
 */
class Admin_Model_Dao_ProductProductOrder extends DbTable_Product_Product_Order
{
    /**
     * get product order by fkOrder
     * @param int $fkOrder
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function getByFkOrder($fkOrder)
    {
        $select = $this->select()->setIntegrityCheck(false)
            ->from(
                DbTable_Product_Product_Order::_tableName,
                array(
                    DbTable_Product_Product_Order::COL_PRODUCT_PRODUCT_ORDER_ID,
                    DbTable_Product_Product_Order::COL_PRODUCT_PRODUCT_ORDER_QTY,
                    Application_Constant_Global::KEY_TOTAL => new Zend_Db_Expr(
                        sprintf(
                            '%s * %s',
                            DbTable_Product_Product_Order::COL_PRODUCT_PRODUCT_ORDER_QTY,
                            DbTable_Product_Product_Order::COL_PRODUCT_PRODUCT_ORDER_PAID_PRICE
                        )
                    ),
                    DbTable_Product_Product_Order::COL_PRODUCT_PRODUCT_ORDER_SIZE,
                    DbTable_Product_Product_Order::COL_PRODUCT_PRODUCT_ORDER_COLOR,
                    DbTable_Product_Product_Order::COL_PRODUCT_PRODUCT_ORDER_PAID_PRICE
                )
            )
            ->joinLeft(
                DbTable_Product::_tableName,
                sprintf(
                    '%s.%s = %s.%s',
                    DbTable_Product::_tableName,
                    DbTable_Product::COL_PRODUCT_ID,
                    DbTable_Product_Product_Order::_tableName,
                    DbTable_Product_Product_Order::COL_FK_PRODUCT
                ),
                array(
                    DbTable_Product::COL_PRODUCT_ID,
                    DbTable_Product::COL_PRODUCT_REFER_CODE,
                    DbTable_Product::COL_PRODUCT_THUMB_NAIL,
                    DbTable_Product::COL_PRODUCT_NAME,
                    DbTable_Product::COL_PRODUCT_PAID_PRICE,
                    DbTable_Product::COL_PRODUCT_CATEGORY_ID,
                    DbTable_Product::COL_PRODUCT_ORIGINAL_PRICE,
                    DbTable_Product::COL_PRODUCT_IDENTIFY,
                    DbTable_Product::COL_FK_PRODUCT_COMPONENT,
                    DbTable_Product::COL_PRODUCT_SIZE,
                    DbTable_Product::COL_PRODUCT_COLOR
                )
            )
            ->where(DbTable_Product_Product_Order::COL_FK_PRODUCT_ORDER . '=?', $fkOrder);
        return $this->fetchAll($select);
    }

    /**
     * delete category by id
     *
     * @param int $id
     * @return int
     */
    public function deleteById($id)
    {
        $where = sprintf('%s=%d', DbTable_Product_Product_Order::COL_PRODUCT_PRODUCT_ORDER_ID, $id);
        return $this->delete($where);
    }
}
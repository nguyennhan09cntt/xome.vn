<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/21/2016
 * Time: 2:43 PM
 */
class Admin_Model_Dao_ProductOrder extends DbTable_Product_Order
{

    /**
     * generate query for searching
     * @param int $id
     * @param string $userName
     * @param string $phone
     * @param string $email
     * @param int $fkActive
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($id, $userName, $phone, $email, $fkActive)
    {
        $select = $this->select();

        if ($id) {
            $select->where(DbTable_Product_Order::COL_PRODUCT_ORDER_ID . ' =?', $id);
        }

        if ($fkActive > -1) {
            $select->where(DbTable_Product_Order::COL_FK_CONFIG_STATUS . ' =?', $fkActive);
        } else {
            $select->where(
                sprintf(
                    '%s.%s IN (%s)',
                    DbTable_Product_Order::_tableName,
                    DbTable_Product_Order::COL_FK_CONFIG_STATUS,
                    $this->getAdapter()->quote(
                        Admin_Model_ProductOrder::getInstance()->getOrderStatusId()
                    )
                )
            );
        }
        if ($phone) {
            $select->where(
                sprintf(
                    '%s like %s',
                    new Zend_Db_Expr ('LOWER(' . DbTable_Product_Order::COL_PRODUCT_ORDER_CUSTOMER_PHONE . ')'),
                    $this->getAdapter()->quote('%' . strtolower($phone) . '%')
                )
            );
        }
        if ($email) {
            $select->where(
                sprintf(
                    '%s like %s',
                    new Zend_Db_Expr ('LOWER(' . DbTable_Product_Order::COL_PRODUCT_ORDER_CUSTOMER_MAIL . ')'),
                    $this->getAdapter()->quote('%' . strtolower($email) . '%')
                )
            );
        }
        if ($userName) {
            $select->where(
                sprintf(
                    '%s like %s',
                    new Zend_Db_Expr ('LOWER(' . DbTable_Product_Order::COL_PRODUCT_ORDER_CUSTOMER_NAME . ')'),
                    $this->getAdapter()->quote('%' . strtolower($userName) . '%')
                )
            );
        }
        $select->order(DbTable_Product_Order::COL_PRODUCT_ORDER_CREATED_AT . ' desc');
        return $select;
    }

    /**
     * get detail info
     * @param int $id
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function getDetail($id)
    {
        $select = $this->select()->setIntegrityCheck(false)
            ->from(
                DbTable_Product_Order::_tableName,
                array(
                    DbTable_Product_Order::COL_PRODUCT_ORDER_ID,
                    DbTable_Product_Order::COL_PRODUCT_ORDER_CREATED_AT,
                    DbTable_Product_Order::COL_PRODUCT_ORDER_UPDATED_AT,
                    DbTable_Product_Order::COL_PRODUCT_ORDER_CUSTOMER_MAIL,
                    DbTable_Product_Order::COL_PRODUCT_ORDER_CUSTOMER_NAME,
                    DbTable_Product_Order::COL_PRODUCT_ORDER_CUSTOMER_PHONE,
                    DbTable_Product_Order::COL_PRODUCT_ORDER_TOTAL_PRICE
                )
            )
            ->joinLeft(
                DbTable_Product_Product_Order::_tableName,
                sprintf(
                    '%s.%s = %s.%s',
                    DbTable_Product_Product_Order::_tableName,
                    DbTable_Product_Product_Order::COL_PRODUCT_PRODUCT_ORDER_ID,
                    DbTable_Product_Order::_tableName,
                    DbTable_Product_Order::COL_PRODUCT_ORDER_ID
                ),
                array(
                    DbTable_Product_Product_Order::COL_PRODUCT_PRODUCT_ORDER_QTY
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
                    DbTable_Product::COL_PRODUCT_REFER_CODE,
                    DbTable_Product::COL_PRODUCT_NAME,
                    DbTable_Product::COL_PRODUCT_PAID_PRICE,
                    DbTable_Product::COL_PRODUCT_CATEGORY_ID
                )
            );
        return $this->fetchRow($select);
    }
}
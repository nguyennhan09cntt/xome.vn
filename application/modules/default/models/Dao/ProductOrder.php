<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/21/2016
 * Time: 9:21 PM
 */
class Model_Dao_ProductOrder extends DbTable_Product_Order
{
    /**
     * get order HOLDING
     * @param $sessionId
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function searchBySessionId($sessionId)
    {
        return $this->fetchRow(
            $this->select()
                ->where(DbTable_Product_Order::COL_FK_CONFIG_STATUS .'=?', Application_Constant_Db_Config_Active::PENDING)
                ->where(DbTable_Product_Order::COL_PRODUCT_ORDER_SESSION_ID . '=?', $sessionId)
        );
    }

    /**
     * initialize order
     * @param $sessionId
     * @param $productId
     * @param $quantity
     * @return string
     */
    public function initialize($sessionId, $productId, $quantity, $price, $color, $size){
        $message = '';
        $this->beginTransaction();
        try {
            #add product order
            $params = array (
                DbTable_Product_Order::COL_PRODUCT_ORDER_SESSION_ID => $sessionId,
                DbTable_Product_Order::COL_FK_CONFIG_STATUS => Application_Constant_Db_Config_Active::PENDING,
                DbTable_Product_Order::COL_PRODUCT_ORDER_CREATED_AT => $this->mysqlSysDate ()
            );
            $orderId = DbTable_Product_Order::getInstance()->insertAndGetLastInsertId($params);
            #add product order

            #add fk product
            $params = array (
                DbTable_Product_Product_Order::COL_FK_PRODUCT => intval($productId),
                DbTable_Product_Product_Order::COL_FK_PRODUCT_ORDER => $orderId,
                DbTable_Product_Product_Order::COL_PRODUCT_PRODUCT_ORDER_PAID_PRICE => $price,
                DbTable_Product_Product_Order::COL_PRODUCT_PRODUCT_ORDER_QTY => $quantity,
                DbTable_Product_Product_Order::COL_PRODUCT_PRODUCT_ORDER_SIZE => $size,
                DbTable_Product_Product_Order::COL_PRODUCT_PRODUCT_ORDER_COLOR =>$color
            );
            DbTable_Product_Product_Order::getInstance()->insert($params);
            #add fk product

            $this->commitTransaction();
        } catch (Exception $e) {
            $message = $e->getMessage();
            $this->rollbackTransaction();
        }
        return $message;
    }

    /**
     * @param $sessionId
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function getProductCartBySessionId($sessionId){
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
                    DbTable_Product::COL_PRODUCT_CATEGORY_ID,
                    DbTable_Product::COL_FK_PRODUCT_COMPONENT,
                    DbTable_Product::COL_PRODUCT_IDENTIFY
                )
            )
            ->where(DbTable_Product_Order::COL_PRODUCT_ORDER_SESSION_ID . '=?', $sessionId)
            ->where(
                sprintf(
                    '%s.%s = %d',
                    DbTable_Product_Order::_tableName,
                    DbTable_Product_Order::COL_FK_CONFIG_STATUS,
                   Application_Constant_Db_Config_Active::PENDING
                )
            );
        return $this->fetchRow($select);
    }

}
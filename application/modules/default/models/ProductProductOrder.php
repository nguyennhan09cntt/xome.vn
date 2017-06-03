<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/21/2016
 * Time: 9:47 PM
 */
class Model_ProductProductOrder extends Application_Singleton
{
    /**
     * @var Model_Dao_ProductProductOrder
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Model_Dao_ProductProductOrder();
    }

    public function checkProductExistOrder($orderId, $productId)
    {
        $productId = intval($productId);
        $orderId = intval($orderId);
        return $this->_dao->checkProductExistOrder($orderId, $productId);
    }

    /**
     * insert fk product
     * @param $orderId
     * @param $productId
     * @param $quantity
     * @return null|string
     */
    public function insert($orderId, $productId, $quantity, $price, $color, $size)
    {
        $productId = intval($productId);
        $quantity = intval($quantity);
        $orderId = intval($orderId);
        $result = null;
        try {
            $params = array(
                DbTable_Product_Product_Order::COL_FK_PRODUCT => $productId,
                DbTable_Product_Product_Order::COL_FK_PRODUCT_ORDER => $orderId,
                DbTable_Product_Product_Order::COL_PRODUCT_PRODUCT_ORDER_QTY => $quantity,
                DbTable_Product_Product_Order::COL_PRODUCT_PRODUCT_ORDER_PAID_PRICE => $price,
                DbTable_Product_Product_Order::COL_PRODUCT_PRODUCT_ORDER_COLOR => $color,
                DbTable_Product_Product_Order::COL_PRODUCT_PRODUCT_ORDER_SIZE => $size
            );
            $this->_dao->insert($params);
            Application_Cache_Default::getInstance()->resetProductSale();
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    /**
     * insert fk product
     * @param $orderId
     * @param $productId
     * @param $quantity
     * @return null|string
     */
    public function update($productOrderId, $quantity)
    {

        $quantity = intval($quantity);
        $productOrderId = intval($productOrderId);
        $result = null;
        try {
            $params = array(
                DbTable_Product_Product_Order::COL_PRODUCT_PRODUCT_ORDER_QTY => $quantity
            );
            $where = sprintf(
                '%s =%d',
                DbTable_Product_Product_Order::COL_PRODUCT_PRODUCT_ORDER_ID,
                $productOrderId
            );
            $this->_dao->update($params, $where);
            Application_Cache_Default::getInstance()->resetProductSale();
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    /**
     * update color
     * @param $orderId
     * @param $productId
     * @param $quantity
     * @return null|string
     */
    public function updateColor($productOrderId, $color)
    {
        $productOrderId = intval($productOrderId);
        $color = trim($color);

        $result = null;
        try {
            $params = array(
                DbTable_Product_Product_Order::COL_PRODUCT_PRODUCT_ORDER_COLOR => $color
            );
            $where = sprintf(
                '%s =%d',
                DbTable_Product_Product_Order::COL_PRODUCT_PRODUCT_ORDER_ID,
                $productOrderId
            );
            $this->_dao->update($params, $where);
            Application_Cache_Default::getInstance()->resetProductSale();
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    /**
     * update color
     * @param $orderId
     * @param $productId
     * @param $quantity
     * @return null|string
     */
    public function updateSize($productOrderId, $size)
    {
        $productOrderId = intval($productOrderId);
        $size = trim($size);

        $result = null;
        try {
            $params = array(
                DbTable_Product_Product_Order::COL_PRODUCT_PRODUCT_ORDER_SIZE => $size
            );
            $where = sprintf(
                '%s =%d',
                DbTable_Product_Product_Order::COL_PRODUCT_PRODUCT_ORDER_ID,
                $productOrderId
            );
            $this->_dao->update($params, $where);
            Application_Cache_Default::getInstance()->resetProductSale();
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    /**
     *  update product qty  + 1
     * @param $orderId
     * @param $productId
     * @param $quantity
     * @return null|string
     */
    public function updateQty($orderId, $productId)
    {
        $productId = intval($productId);

        $orderId = intval($orderId);
        $result = null;
        try {
            $params = array(
                DbTable_Product_Product_Order::COL_PRODUCT_PRODUCT_ORDER_QTY => new Zend_Db_Expr(DbTable_Product_Product_Order::COL_PRODUCT_PRODUCT_ORDER_QTY . ' + 1'),
            );
            $where = sprintf(
                '%s =%d AND %s = %d',
                DbTable_Product_Product_Order::COL_FK_PRODUCT_ORDER,
                $orderId,
                DbTable_Product_Product_Order::COL_FK_PRODUCT,
                $productId
            );
            $this->_dao->update($params, $where);
            Application_Cache_Default::getInstance()->resetProductSale();
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    /**
     * get product by fkOrder
     * @param $fkOrder
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function getByFkOrder($fkOrder)
    {
        return Admin_Model_ProductProductOrder::getInstance()->getByFkOrder($fkOrder);
    }

    /**
     * delete  by id
     *
     * @param int $id
     * @return int
     */
    public function deleteById($id)
    {
        $id = intval($id);
        return Admin_Model_ProductProductOrder::getInstance()->deleteById($id);
    }

}
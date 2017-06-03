<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/21/2016
 * Time: 9:20 PM
 */
class Model_ProductOrder extends Application_Singleton
{
    /*
    *
    * @var Model_Dao_ProductOrder
    */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Model_Dao_ProductOrder();
    }

    /**
     * get order HOLDING by session id
     * @param string $sessionId
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function searchBySessionId($sessionId)
    {
        $sessionId = trim($sessionId);
        return $this->_dao->searchBySessionId($sessionId);
    }

    /**
     * get cart HOLDING by session id
     * @param string $sessionId
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function getProductCartBySessionId($sessionId)
    {
        $sessionId = trim($sessionId);
        return $this->_dao->getProductCartBySessionId($sessionId);
    }

    /**
     * @param $sessionId
     * @param $productId
     * @param $quantity
     */
    public function initialize($sessionId, $productId, $quantity, $price, $color, $size)
    {
        $color = trim($color);
        $size = trim($size);
        $this->_dao->initialize($sessionId, $productId, $quantity, $price, $color, $size);
    }

    /**
     * update customer info
     * @param $orderId
     * @param $name
     * @param $email
     * @param $address
     * @param $phone
     * @return string
     */
    public function updateCustomerInfo($orderId, $name, $email, $address, $phone)
    {

        $result = null;
        try {
            $params = array(
                DbTable_Product_Order::COL_FK_CONFIG_STATUS => Application_Constant_Db_Config_Active::ACTIVE,
                DbTable_Product_Order::COL_PRODUCT_ORDER_CUSTOMER_NAME => trim($name),
                DbTable_Product_Order::COL_PRODUCT_ORDER_CUSTOMER_MAIL => trim($email),
                DbTable_Product_Order::COL_PRODUCT_ORDER_CUSTOMER_ADDRESS => trim($address),
                DbTable_Product_Order::COL_PRODUCT_ORDER_CUSTOMER_PHONE => trim($phone)

            );
            $where = sprintf('%s IN (%s)', DbTable_Product_Order::COL_PRODUCT_ORDER_ID, $this->_dao->getAdapter()->quote($orderId));
            $this->_dao->update($params, $where);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

}
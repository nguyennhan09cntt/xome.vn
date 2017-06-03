<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/21/2016
 * Time: 2:42 PM
 */
class Admin_Model_ProductOrder extends Application_Singleton
{

    /**
     *
     * @var Admin_Model_Dao_ProductOrder
     */
    private $_dao;

    /**
     *
     * @var string
     */
    private $_prefix = 'LN3';

    /**
     *
     * @var int
     */
    private $_secret = 2103;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_ProductOrder ();
    }

    /**
     * Encode ID
     *
     * @param int $id
     * @return string
     */
    public function encode($id)
    {
        return $this->_prefix . strtoupper(dechex($id + $this->_secret));
    }

    /**
     * Decode ID to number
     *
     * @param string $code
     * @return int
     */
    public function decode($code)
    {
        $result = 0;
        if ($code && strstr($code, $this->_prefix)) {
            $code = strtoupper($code);
            $result = intval(hexdec(strtolower(str_replace($this->_prefix, '', $code))));
            $result = $result - $this->_secret;
        }
        return $result > 0 ? $result : 0;
    }

    /**
     * generate query for searching
     * @param $id
     * @param $userName
     * @param $phone
     * @param $email
     * @param $fkActive
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($id, $userName, $phone, $email, $fkActive)
    {
        $id = intval($id);
        $userName = trim($userName);
        $email = trim($email);
        $phone = trim($phone);
        $fkActive = intval($fkActive);
        return $this->_dao->searchQuery($id, $userName, $phone, $email, $fkActive);
    }

    /**
     * Manual update active by Array|Single ID
     *
     * @param int $value
     * @param array|int $id
     * @return int
     */
    public function manualUpdateActive($value, $id)
    {

        $where = sprintf('%s IN (%s)', DbTable_Product_Order::COL_PRODUCT_ORDER_ID, $this->_dao->getAdapter()->quote($id));
        $params = array(
            DbTable_Product_Order::COL_FK_CONFIG_STATUS => intval($value)
        );
        return $this->_dao->update($params, $where);
    }

    /**
     * @param $id
     * @param $note
     * @return null|string
     */
    public function updateNote($id, $note)
    {

        $note = trim($note);
        $id = intval($id);
        $result = null;
        try {
            $params = array(
                DbTable_Product_Order::COL_PRODUCT_ORDER_NOTE => $note,
            );
            $where = sprintf('%s IN (%s)', DbTable_Product_Order::COL_PRODUCT_ORDER_ID, $this->_dao->getAdapter()->quote($id));
            $this->_dao->update($params, $where);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    /**
     * get by id
     *
     * @param array|int $id
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getById($id)
    {
        $id = intval($id);
        return $this->_dao->find($id);
    }

    /**
     * @param $id
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function getDetail($id)
    {
        $id = intval($id);
        return $this->_dao->getDetail($id);
    }

    /**
     * order status
     * @return array
     */
    public function getOrderStatus()
    {
        return array(
            // Application_Constant_Db_Config_Active::PENDING => 'Pending',
            Application_Constant_Db_Config_Active::ACTIVE => 'Active',
            Application_Constant_Db_Config_Active::INACTIVE => 'Inactive',
            Application_Constant_Db_Config_Active::FINISHED => 'Finished',
            Application_Constant_Db_Config_Active::SUCCESSFUL => 'Successful',
            Application_Constant_Db_Config_Active::FAILED => 'Failed',
            Application_Constant_Db_Config_Active::DELETED => 'Deleted'
        );
    }

    /**
     * order status id
     * @return array
     */
    public function getOrderStatusId()
    {
        return array(
            // Application_Constant_Db_Config_Active::PENDING,
            Application_Constant_Db_Config_Active::ACTIVE,
            Application_Constant_Db_Config_Active::INACTIVE,
            Application_Constant_Db_Config_Active::FINISHED,
            Application_Constant_Db_Config_Active::SUCCESSFUL,
            Application_Constant_Db_Config_Active::FAILED,
            Application_Constant_Db_Config_Active::DELETED
        );
    }
}
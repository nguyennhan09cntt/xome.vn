<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 6/18/2016
 * Time: 2:53 PM
 */
class Admin_Model_Contact extends Application_Singleton
{

    /**
     *
     * @var Admin_Model_Dao_Contact
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_Contact ();
    }

    /**
     * @param $name
     * @param $fkActive
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($name, $fkActive)
    {
        $name = intval($name);
        $fkActive = intval($fkActive);
        return $this->_dao->searchQuery($name, $fkActive);
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
        $where = sprintf('%s IN (%s)', DbTable_Contact::COL_CONTACT_ID, $this->_dao->getAdapter()->quote($id));
        $params = array(
            DbTable_Contact::COL_CONTACT_STATUS => intval($value)
        );
        return $this->_dao->update($params, $where);
    }

    /**
     * @param $name
     * @param $email
     * @param $phone
     * @param $message
     * @return null|string
     */
    public function insert($name, $email, $phone, $message, $address, $price, $product, $city = 1, $district = 1)
    {
        $name = trim($name);
        $email = trim($email);
        $phone = trim($phone);
        $message = trim($message);

        $result = null;
        try {
            $params = array(
                DbTable_Contact::COL_CONTACT_NAME => $name,
                DbTable_Contact::COL_CONTACT_EMAIL => $email,
                DbTable_Contact::COL_CONTACT_PHONE => $phone,
                DbTable_Contact::COL_CONTACT_MESSAGE => $message,
                DbTable_Contact::COL_CONTACT_ADDRESS => $address,
                DbTable_Contact::COL_CONTACT_PRICE => $price,
                DbTable_Contact::COL_CONTACT_PRODUCT => $product,
                DbTable_Contact::COL_CONTACT_STATUS => Application_Constant_Db_Config_Active::PENDING,
                DbTable_Contact::COL_CONTACT_CITY => $city,
                DbTable_Contact::COL_CONTACT_DISTRICT => $district,
                DbTable_Contact::COL_CONTACT_CREATED_AT => $this->_dao->mysqlSysDate()
            );
            $this->_dao->insert($params);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    public function update($id, $name, $email, $phone, $message, $address, $price, $product, $city = 1, $district = 1)
    {
        $name = trim($name);
        $email = trim($email);
        $phone = trim($phone);
        $message = trim($message);

        $result = null;
        try {
            $params = array(
                DbTable_Contact::COL_CONTACT_NAME => $name,
                DbTable_Contact::COL_CONTACT_EMAIL => $email,
                DbTable_Contact::COL_CONTACT_PHONE => $phone,
                DbTable_Contact::COL_CONTACT_MESSAGE => $message,
                DbTable_Contact::COL_CONTACT_ADDRESS => $address,
                DbTable_Contact::COL_CONTACT_PRICE => $price,
                DbTable_Contact::COL_CONTACT_PRODUCT => $product,
                //DbTable_Contact::COL_CONTACT_STATUS => Application_Constant_Db_Config_Active::PENDING,
                DbTable_Contact::COL_CONTACT_CITY => $city,
                DbTable_Contact::COL_CONTACT_DISTRICT => $district
            );
            $where = sprintf('%s IN (%s)', DbTable_Contact::COL_CONTACT_ID, $this->_dao->getAdapter()->quote($id));
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


}
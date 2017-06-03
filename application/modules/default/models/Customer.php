<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 6/11/2016
 * Time: 11:09 AM
 */
class Model_Customer extends Application_Singleton
{
    /**
     * @var Model_Dao_Customer
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Model_Dao_Customer();
    }

    public function getListing($page, $limit, $fkProvince, $fkDistrict, $category, $grade)
    {
        $page = intval($page);
        $limit = intval($limit);
        $category = intval($category);

        return $this->_dao->getListing($page, $limit, $fkProvince, $fkDistrict, $category, $grade);
    }

    /**
     * Insert new customer & get inserted ID
     * @param string $email
     * @param string $password
     * @param string $name
     * @param string $phone
     * @param string $address
     * @param int $province
     * @param int $district
     * @param int $country
     * @return int
     */
    public function insert($email, $password, $name, $phone, $address, $province, $district, $country = null, $lastName, $firstName)
    {
        $email = strtolower(trim($email));
        $name = trim($name);
        $lastName = trim($lastName);
        $firstName = trim($firstName);
        $password = trim($password);
        $address = trim($address);
        $province = trim($province);
        $district = trim($district);
        $country = intval($country);
        $params = array(
            DbTable_Customer::COL_CUSTOMER_EMAIL => $email,
            DbTable_Customer::COL_CUSTOMER_PASSWORD => md5($password),
            DbTable_Customer::COL_CUSTOMER_NAME => $name,
            DbTable_Customer::COL_CUSTOMER_LAST_NAME => $lastName,
            DbTable_Customer::COL_CUSTOMER_FIST_NAME => $firstName,
            DbTable_Customer::COL_CUSTOMER_PHONE => $phone,
            DbTable_Customer::COL_CUSTOMER_ADDRESS => $address,
            DbTable_Customer::COL_FK_CONFIG_ACTIVE => Application_Constant_Db_Config_Active::ACTIVE,
            DbTable_Customer::COL_FK_PROVINCE => $province,
            DbTable_Customer::COL_FK_DISTRICT => $district,
            DbTable_Customer::COL_FK_COUNTRY => $country ? $country : null,
            DbTable_Customer::COL_CUSTOMER_CREATED_AT => $this->_dao->mysqlSysDate()
        );
        return $this->_dao->insertAndGetLastInsertId($params);
    }

    /**
     * @param $id
     * @param $name
     * @param $phone
     * @param $address
     * @param $province
     * @param $district
     * @param null $country
     * @param $lastName
     * @param $firstName
     * @return null|string
     */
    public function update($id, $name, $phone, $address, $province, $district, $country = null, $lastName, $firstName)
    {

        $name = trim($name);
        $lastName = trim($lastName);
        $firstName = trim($firstName);
        $address = trim($address);
        $province = trim($province);
        $district = trim($district);
        $country = intval($country);
        $result = null;
        try {
            $params = array(
                DbTable_Customer::COL_CUSTOMER_NAME => $name,
                DbTable_Customer::COL_CUSTOMER_LAST_NAME => $lastName,
                DbTable_Customer::COL_CUSTOMER_FIST_NAME => $firstName,
                DbTable_Customer::COL_CUSTOMER_PHONE => $phone,
                DbTable_Customer::COL_CUSTOMER_ADDRESS => $address,
                DbTable_Customer::COL_FK_CONFIG_ACTIVE => Application_Constant_Db_Config_Active::ACTIVE,
                DbTable_Customer::COL_FK_PROVINCE => $province,
                DbTable_Customer::COL_FK_DISTRICT => $district,
                DbTable_Customer::COL_FK_COUNTRY => $country ? $country : null,

            );
            $where = sprintf('%s IN (%s)', DbTable_Customer::COL_CUSTOMER_ID, $this->_dao->getAdapter()->quote($id));
            $this->_dao->update($params, $where);

        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    /**
     * Insert customer width facebook
     * @param $facebookId
     * @param $email
     * @param $firstName
     * @param $lastName
     * @param $name
     * @param $gender
     * @return int
     */
    public function insertFacebook($facebookId, $email, $firstName, $lastName, $name, $gender, $birthDay, $phone, $link)
    {
        $params = array(
            DbTable_Customer::COL_CUSTOMER_EMAIL => $email,
            DbTable_Customer::COL_CUSTOMER_FACEBOOK_ID => $facebookId,
            DbTable_Customer::COL_CUSTOMER_NAME => $name,
            DbTable_Customer::COL_CUSTOMER_LAST_NAME => $lastName,
            DbTable_Customer::COL_CUSTOMER_FIST_NAME => $firstName,
            DbTable_Customer::COL_CUSTOMER_GENDER => $gender,
            DbTable_Customer::COL_CUSTOMER_PHONE => $phone,
            DbTable_Customer::COL_CUSTOMER_FACEBOOK_LINK => $link,
            DbTable_Customer::COL_CUSTOMER_BIRTH_DAY => $birthDay,
            DbTable_Customer::COL_FK_CONFIG_ACTIVE => Application_Constant_Db_Config_Active::ACTIVE,

            DbTable_Customer::COL_CUSTOMER_CREATED_AT => $this->_dao->mysqlSysDate()
        );
        return $this->_dao->insertAndGetLastInsertId($params);
    }

    /**
     * Get customer information by ID
     * @param int $id
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function getById($id)
    {
        $data = $this->_dao->find($id);
        return $data ? $data->current() : null;
    }

    /**
     * @param $session
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function searchBySession($session)
    {
        $session = trim($session);
        return $this->_dao->searchBySession($session);
    }

    /**
     * @param $facebookId
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function searchByFacebookId($facebookId)
    {
        $session = trim($facebookId);
        return $this->_dao->searchByFacebookId($facebookId);
    }

    /**
     * Update session by ID
     * @param int $id
     * @param string $session
     * @return int
     */
    public function updateSessionById($id, $session)
    {
        $params = array(
            DbTable_Customer::COL_CUSTOMER_SESSION => trim($session)
        );
        $where = sprintf('%s=%d', DbTable_Customer::COL_CUSTOMER_ID, intval($id));
        return $this->_dao->update($params, $where);
    }


}
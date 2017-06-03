<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 2/16/2017
 * Time: 12:29 PM
 */
class Cli_Model_ProductOwner extends Application_Singleton
{
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Cli_Model_Dao_ProductOwner();
    }

    /**
     * @param $name
     * @param $phone
     * @param $email
     * @param $facebookId
     * @param $type
     * @return int|null|string
     */
    public function insert($name, $phone, $email, $facebookId, $type)
    {
        $name = trim($name);
        $phone = trim($phone);
        $email = trim($email);
        $facebookId = trim($facebookId);
        $type = intval($type);
        $result = null;
        try {
            $params = array(
                DbTable_Product_Own::COL_PRODUCT_OWN_NAME => $name,
                DbTable_Product_Own::COL_PRODUCT_OWN_PHONE => $phone,
                DbTable_Product_Own::COL_PRODUCT_OWN_EMAIL => $email,
                DbTable_Product_Own::COL_PRODUCT_OWN_FACEBOOK_ID => $facebookId,
                DbTable_Product_Own::COL_PRODUCT_OWN_TYPE => $type,
                DbTable_Product_Own::COL_PRODUCT_OWN_CREATED_AT => $this->_dao->mysqlSysDate()
            );
            $result = $this->_dao->insertAndGetLastInsertId($params);

        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    /**
     * @param string $facebookId
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function getByFacebookId($facebookId)
    {
        $facebookId = trim($facebookId);
        return $this->_dao->getByFacebookId($facebookId);
    }

}
<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 6/11/2016
 * Time: 11:10 AM
 */
class Model_Dao_Customer extends DbTable_Customer
{


    /**
     * Search by email
     * @param string $email
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function searchByEmail($email)
    {
        return $this->fetchRow(
            $this->select()->where(DbTable_Customer::COL_CUSTOMER_EMAIL . '=?', $email)
        );
    }

    /**
     * Search by phone
     * @param string $phone
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function searchByPhone($phone)
    {
        return $this->fetchRow(
            $this->select()->where(DbTable_Customer::COL_CUSTOMER_PHONE . '=?', $phone)
        );
    }

    /**
     * @param $session
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function searchBySession($session)
    {
        return $this->fetchRow(
            $this->select()->where(DbTable_Customer::COL_CUSTOMER_SESSION . '=?', $session)
        );
    }

    /**
     * @param $facebookId
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function searchByFacebookId($facebookId)
    {
        return $this->fetchRow(
            $this->select()->where(DbTable_Customer::COL_CUSTOMER_FACEBOOK_ID . '=?', $facebookId)
        );
    }

    /**
     * @param $page
     * @param $limit
     * @param $fkProvince
     * @param $fkDistrict
     * @param $category
     * @param $grade
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getListing($page, $limit, $fkProvince, $fkDistrict, $category, $grade)
    {
        $select = $this->select();
        if ($fkProvince) {
            $select->where(DbTable_Customer::COL_FK_PROVINCE . '=?', $fkProvince);
        }

        if ($fkDistrict) {
            $select->where(DbTable_Customer::COL_FK_DISTRICT . '=?', $fkDistrict);
        }

        if ($category) {
            //$select->where(DbTable_Customer::COLFK . '=?', $fkDistrict);
        }

        if ($grade) {

        }
        $select->where(DbTable_Customer::COL_CUSTOMER_TYPE . '=?', 1);
        $select->limitPage($page, $limit);
        return $this->fetchAll($select);
    }
}
<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/3/2017
 * Time: 8:26 PM
 */
class Model_Dao_ProductOwner extends DbTable_Product_Own
{
    /**
     * @param $page
     * @param $limit
     * @param $key
     * @return array
     */
    public function getListing($page, $limit, $key)
    {
        $select = $this->select()->setIntegrityCheck(false)
            ->from(
                DbTable_Product_Own::_tableName,
                array(
                    new Zend_Db_Expr('SQL_CALC_FOUND_ROWS ' . DbTable_Product_Own::COL_PRODUCT_OWN_ID),
                    DbTable_Product_Own::COL_PRODUCT_OWN_NAME,
                    DbTable_Product_Own::COL_PRODUCT_OWN_PHONE,
                    DbTable_Product_Own::COL_PRODUCT_OWN_EMAIL,
                    DbTable_Product_Own::COL_PRODUCT_OWN_FACEBOOK_ID
                )
            )

            ->order(DbTable_Product_Own::COL_PRODUCT_OWN_ID . ' desc')
            ->limitPage($page, $limit);
        if ($key) {
            $select->where(
                sprintf(
                    '%s.%s like %s',
                    DbTable_Product_Own::_tableName,
                    DbTable_Product_Own::COL_PRODUCT_OWN_PHONE,
                    $this->getAdapter()->quote($key)
                )
            );
        }
        $select->order(DbTable_Product_Own::COL_PRODUCT_OWN_ID .' DESC');

        return array(
            Application_Constant_Global::KEY_DATA => $this->fetchAll($select),
            Application_Constant_Global::KEY_TOTAL => $this->fetchOne($this->queryTotalRow())
        );
    }

    /**
     * @param $phone
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function getByPhone($phone){

        return $this->fetchRow($this->select()->where(DbTable_Product_Own::COL_PRODUCT_OWN_PHONE .'=?', $phone));
    }
}
<?php

class Admin_Model_Dao_Product extends DbTable_Product
{

    /**
     * generate query for searching
     *
     * @param int $name
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($name, $code, $category, $active, $priority)
    {
        $select = $this->select();
        if ($name) {
            $select->where(sprintf('%s like %s', new Zend_Db_Expr ('LOWER(' . DbTable_Product::COL_PRODUCT_NAME . ')'), $this->getAdapter()->quote('%' . strtolower($name) . '%')));
        }
        if ($code) {
            $select->where(sprintf('%s like %s', new Zend_Db_Expr ('LOWER(' . DbTable_Product::COL_PRODUCT_REFER_CODE . ')'), $this->getAdapter()->quote('%' . strtolower($code) . '%')));
            $select->orWhere(
                sprintf(
                    'CONCAT("LN3",HEX(%s.%s+5050)) = %s',
                    DbTable_Product::_tableName,
                    DbTable_Product::COL_PRODUCT_ID,
                    $this->getAdapter()->quote($code)

                )
            );
        }

        if ($category > -1) {
            $select->where(sprintf('%s=%d', DbTable_Product::COL_PRODUCT_CATEGORY_ID, $category));
        }
        if ($active > -1) {
            $select->where(sprintf('%s=%d', DbTable_Product::COL_FK_CONFIG_STATUS, $active));
        } else {
            $select->where(sprintf('%s!=%d', DbTable_Product::COL_FK_CONFIG_STATUS, Application_Constant_Db_Config_Active::PENDING));
        }

        if ($priority > -1) {

            $select->where(sprintf('%s=%d', DbTable_Product::COL_PRODUCT_PRIORITY, $priority));
        }

        $select->order(DbTable_Product::COL_PRODUCT_ID . ' desc');

        return $select;
    }

    /**
     * delete  by id
     * @param int|array $id
     * @return int
     */
    public function deleteById($id)
    {
        $where = sprintf('%s IN(%s)', DbTable_Product::COL_PRODUCT_ID, $this->getAdapter()->quote($id));
        return $this->delete($where);
    }

    /**
     * @param $id
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function searchCustomerByProductId($id)
    {
        $select = $this->select()->setIntegrityCheck(false)
            ->from(
                DbTable_Product::_tableName,
                array(
                    DbTable_Product::COL_PRODUCT_ID
                )
            )
            ->join(
                DbTable_Customer::_tableName,
                sprintf(
                    '%s.%s = %s.%s',
                    DbTable_Customer::_tableName,
                    DbTable_Customer::COL_CUSTOMER_ID,
                    DbTable_Product::_tableName,
                    DbTable_Product::COL_FK_CUSTOMER
                ),
                array(                   
                    DbTable_Customer::COL_CUSTOMER_ID,
                    DbTable_Customer::COL_CUSTOMER_NAME,
                    DbTable_Customer::COL_CUSTOMER_EMAIL,
                    DbTable_Customer::COL_CUSTOMER_PHONE
                )
            )
            ->where(
                sprintf(
                    '%s.%s IN(%s)',
                    DbTable_Product::_tableName,
                    DbTable_Product::COL_PRODUCT_ID,
                    $this->getAdapter()->quote($id)
                )
            );
        return $this->fetchAll($select);
    }
}
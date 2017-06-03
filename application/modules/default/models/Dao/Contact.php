<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 6/18/2016
 * Time: 2:27 PM
 */
class Model_Dao_Contact extends DbTable_Contact
{

    /**
     * @param $page
     * @param $limit
     * @param $componentId
     * @param $categoryId
     * @return array
     */
    public function getListing($page, $limit, $componentId, $categoryId)
    {
        $select = $this->select()->setIntegrityCheck(false)
            ->from(
                DbTable_Contact::_tableName,
                array(
                    new Zend_Db_Expr('SQL_CALC_FOUND_ROWS ' . DbTable_Contact::COL_CONTACT_ID),
                    DbTable_Contact::COL_CONTACT_NAME,
                    DbTable_Contact::COL_CONTACT_PHONE,
                    DbTable_Contact::COL_CONTACT_MESSAGE,
                    DbTable_Contact::COL_CONTACT_ADDRESS,
                    DbTable_Contact::COL_CONTACT_PRICE,
                    DbTable_Contact::COL_CONTACT_IMAGE,
                    DbTable_Contact::COL_CONTACT_URL_STATIC_MAP,
                    DbTable_Contact::COL_CONTACT_CREATED_AT
                )
            )
            ->where(
                sprintf(
                    '%s.%s = "" || %s.%s IS NULL',
                    DbTable_Contact::_tableName,
                    DbTable_Contact::COL_CONTACT_PRODUCT,
                    DbTable_Contact::_tableName,
                    DbTable_Contact::COL_CONTACT_PRODUCT
                )
            )
            ->where(
                DbTable_Contact::COL_CONTACT_STATUS . ' IN(?)',
                array(
                    Application_Constant_Db_Config_Active::PENDING,
                    Application_Constant_Db_Config_Active::ACTIVE,
                    Application_Constant_Db_Config_Active::FINISHED
                )
            )
            ->order(DbTable_Contact::COL_CONTACT_ID . ' desc')
            ->limitPage($page, $limit);
        if ($componentId) {
            $select->where(sprintf(
                    '%s.%s = %d',
                    DbTable_Contact::_tableName,
                    DbTable_Contact::COL_CONTACT_CITY,
                    $componentId

                )
            );
        }
        if ($categoryId) {
            $select->where(
                sprintf(
                    '%s.%s = %d',
                    DbTable_Contact::_tableName,
                    DbTable_Contact::COL_CONTACT_DISTRICT,
                    $categoryId
                )
            );
        }

        return array(
            Application_Constant_Global::KEY_DATA => $this->fetchAll($select),
            Application_Constant_Global::KEY_TOTAL => $this->fetchOne($this->queryTotalRow())
        );
    }
}
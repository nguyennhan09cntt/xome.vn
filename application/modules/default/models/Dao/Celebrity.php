<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 8/17/2016
 * Time: 10:53 PM
 */
class Model_Dao_Celebrity extends DbTable_Celebrity
{

    public function search($page, $limit, $name, $code, $category, $active, $priority, $tag, $province)
    {
        $select = $this->select()->from(
            DbTable_Celebrity::_tableName,
            array(
                new Zend_Db_Expr('SQL_CALC_FOUND_ROWS ' . DbTable_Celebrity::COL_CELEBRITY_ID),
                DbTable_Celebrity::COL_CELEBRITY_IDENTIFY,
                DbTable_Celebrity::COL_CELEBRITY_NAME,
                DbTable_Celebrity::COL_CELEBRITY_THUMB_NAIL,
                DbTable_Celebrity::COL_CELEBRITY_GENDER,
                DbTable_Celebrity::COL_CELEBRITY_TAG,
                DbTable_Celebrity::COL_FK_PROVICE,
                DbTable_Celebrity::COL_CELEBRITY_DESCRIPTION
            )
        );
        if ($name) {
            $select->where(
                sprintf(
                    '%s like %s',
                    new Zend_Db_Expr (
                        'LOWER(' . DbTable_Celebrity::COL_CELEBRITY_NAME . ')'),
                    $this->getAdapter()->quote('%' . strtolower($name) . '%')
                )
            );
        }

        if ($tag) {
            $select->where(
                sprintf(
                    '%s like %s',
                    new Zend_Db_Expr (
                        'LOWER(' . DbTable_Celebrity::COL_CELEBRITY_TAG . ')'),
                    $this->getAdapter()->quote('%' . strtolower($tag) . '%')
                )
            );
        }
        if($category){
            $select->where(
                DbTable_Celebrity::COL_FK_CELEBRITY_CATEGORY .'=?',
                $category
            );
        }
        if($province){
            $select->where(
                DbTable_Celebrity::COL_FK_PROVICE .'=?',
                $province
            );
        }
        $select->limitPage($page, $limit);
		//var_dump($select->assemble());
        return array(
            Application_Constant_Global::KEY_DATA => $this->fetchAll($select),
            Application_Constant_Global::KEY_TOTAL => $this->fetchOne($this->queryTotalRow())
        );
    }

    /**
     * @param $page
     * @param $limit
     * @param $componentId
     * @param $categoryId
     * @return array
     */
    public function getListing($page, $limit, $componentId, $categoryId, $gender)
    {
        $select = $this->select()->from(
            DbTable_Celebrity::_tableName,
            array(
                new Zend_Db_Expr('SQL_CALC_FOUND_ROWS ' . DbTable_Celebrity::COL_CELEBRITY_ID),
                DbTable_Celebrity::COL_CELEBRITY_IDENTIFY,
                DbTable_Celebrity::COL_CELEBRITY_NAME,
                DbTable_Celebrity::COL_CELEBRITY_THUMB_NAIL,
                DbTable_Celebrity::COL_CELEBRITY_GENDER,
                DbTable_Celebrity::COL_CELEBRITY_TAG,
                DbTable_Celebrity::COL_FK_PROVICE,
                DbTable_Celebrity::COL_CELEBRITY_DESCRIPTION
            )
        );
        if ($componentId) {
            $select->where(DbTable_Celebrity::COL_FK_CELEBRITY_COMPONENT . '=?', $componentId);
        }

        if ($categoryId) {
            $select->where(DbTable_Celebrity::COL_FK_CELEBRITY_CATEGORY . '=?', $categoryId);
        }
        if ($gender) {
            $select->where(DbTable_Celebrity::COL_CELEBRITY_GENDER . '=?', $gender);
        }
        $select->limitPage($page, $limit);

        return array(
            Application_Constant_Global::KEY_DATA => $this->fetchAll($select),
            Application_Constant_Global::KEY_TOTAL => $this->fetchOne($this->queryTotalRow())
        );

    }

    /**
     * get by identify
     * @param string $identify
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function getByIdentify($identify)
    {
        $select = $this->select()
            ->where(DbTable_Celebrity::COL_CELEBRITY_IDENTIFY . ' =?', $identify)
            ->where(DbTable_Celebrity::COL_FK_CONFIG_STATUS . '=?', Application_Constant_Db_Config_Active::ACTIVE);

        return $this->fetchRow($select);
    }

    public function getByFacebookId($userId)
    {
        $select = $this->select()
            ->where(DbTable_Celebrity::COL_CELEBRITY_FACEBOOK_ID . ' =?', $userId)
            ->where(DbTable_Celebrity::COL_FK_CONFIG_STATUS . '=?', Application_Constant_Db_Config_Active::ACTIVE);

        return $this->fetchRow($select);
    }
}
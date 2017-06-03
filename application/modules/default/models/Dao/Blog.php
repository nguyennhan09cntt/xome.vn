<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/19/2016
 * Time: 5:57 PM
 */
class Model_Dao_Blog extends DbTable_Blog
{
    /**
     * get blog listing
     * @param int $page
     * @param int $limit
     * @param int $categoryId
     * @return array
     */
    public function getListing($page, $limit, $categoryId, $componentId = 1)
    {
        $select = $this->select()
            ->from(
                DbTable_Blog::_tableName,
                array(
                    new Zend_Db_Expr('SQL_CALC_FOUND_ROWS ' . DbTable_Blog::COL_BLOG_ID),
                    DbTable_Blog::COL_BLOG_NAME,
                    DbTable_Blog::COL_BLOG_DESCRIPTION,
                    DbTable_Blog::COL_BLOG_THUMB_IMAGE,
                    DbTable_Blog::COL_BLOG_IMPORT_FLAG,
                    DbTable_Blog::COL_BLOG_VIEW_QTY,
                    DbTable_Blog::COL_BLOG_IDENTIFY,
                    DbTable_Blog::COL_BLOG_CONTENT,
                    DbTable_Blog::COL_BLOG_CREATED_AT,
                    DbTable_Blog::COL_FK_BLOG_CATEGORY,
                    DbTable_Blog::COL_FK_COMPONENT
                )
            );
        if ($categoryId) {
            $select->where(DbTable_Blog::COL_FK_BLOG_CATEGORY . '=?', $categoryId);
        }/* else {
            $select->where(DbTable_Blog::COL_FK_BLOG_CATEGORY . '!=?', 3);
        }*/
        if ($componentId) {
            $select->where(DbTable_Blog::COL_FK_COMPONENT . '=?', $componentId);
        }
        $select->where(DbTable_Blog::COL_FK_CONFIG_STATUS . '=?', Application_Constant_Db_Config_Active::ACTIVE);
        $select->order(DbTable_Blog::COL_BLOG_ID . ' desc');
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
            ->where(DbTable_Blog::COL_BLOG_IDENTIFY . ' =?', $identify)
            ->where(DbTable_Blog::COL_FK_CONFIG_STATUS . '=?', Application_Constant_Db_Config_Active::ACTIVE);

        return $this->fetchRow($select);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 11/10/15
 * Time: 9:24 AM
 */
class Model_Dao_Promotion extends DbTable_Promotion
{
    /**
     * Get promotion listing
     * @param int $page
     * @param int $limit
     * @param int $componentId
     * @return array
     */
    public function getListing($page, $limit, $componentId)
    {
        $select = $this->select()
            ->from(
                DbTable_Promotion::_tableName,
                array(
                    new Zend_Db_Expr('SQL_CALC_FOUND_ROWS '. DbTable_Promotion::COL_PROMOTION_ID),
                    DbTable_Promotion::COL_PROMOTION_ID,
                    DbTable_Promotion::COL_PROMOTION_SUB_CONTENT,
                    DbTable_Promotion::COL_PROMOTION_TITLE,
                    DbTable_Promotion::COL_PROMOTION_IMAGE,
                    DbTable_Promotion::COL_PROMOTION_EXPIRED_DATE,
                    DbTable_Promotion::COL_FK_CONFIG_COMPONENT,
                    DbTable_Promotion::COL_PROMOTION_IDENTIFY
                )
            )
            ->where(DbTable_Promotion::COL_FK_CONFIG_COMPONENT . '=?', $componentId)
            ->limitPage($page, $limit)->order(DbTable_Promotion::COL_PROMOTION_ID . ' desc');
        return array(
            Application_Constant_Global::KEY_DATA => $this->fetchAll($select),
            Application_Constant_Global::KEY_TOTAL => $this->fetchOne($this->queryTotalRow())
        );
    }

    /**
     * Get promotion listing by fk component
     * @param int $componentId
     * @return array
     */
    public function getByFkComponent($componentId)
    {
        $select = $this->select()
            ->from(
                DbTable_Promotion::_tableName,
                array(
                    DbTable_Promotion::COL_PROMOTION_ID,
                    DbTable_Promotion::COL_PROMOTION_SUB_CONTENT,
                    DbTable_Promotion::COL_PROMOTION_TITLE,
                    DbTable_Promotion::COL_PROMOTION_IMAGE,
                    DbTable_Promotion::COL_PROMOTION_EXPIRED_DATE,
                    DbTable_Promotion::COL_FK_CONFIG_COMPONENT
                )
            )
            ->where(DbTable_Promotion::COL_FK_CONFIG_COMPONENT . '=?', $componentId);
        return $this->fetchAll($select);
    }
}
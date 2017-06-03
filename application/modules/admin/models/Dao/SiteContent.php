<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 6/18/2016
 * Time: 4:09 PM
 */
class Admin_Model_Dao_SiteContent extends DbTable_Site_Content
{
    /**
     *
     * @param string $name
     * @param int $fkActive
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($name, $fkActive)
    {
        $select = $this->select();

        if ($name) {
            $select->where(sprintf('%s like %s', new Zend_Db_Expr ('LOWER(' . DbTable_Site_Content::COL_SITE_CONTENT_NAME . ')'), $this->getAdapter()->quote('%' . strtolower($name) . '%')));
        }

        if ($fkActive > -1) {
            $select->where(DbTable_Site_Content::COL_FK_CONFIG_ACTIVE . ' =?', $fkActive);
        }
        $select->order(DbTable_Site_Content::COL_SITE_CONTENT_CREATED_AT . ' desc');
        $select->order(DbTable_Site_Content::COL_SITE_CONTENT_NAME . ' asc');

        return $select;
    }

    /**
     * get by identify
     * @param string $identify
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function getByIdentify($identify)
    {
        $select = $this->select()
            ->where(DbTable_Site_Content::COL_SITE_CONTENT_IDENTIFY . ' =?', $identify)
            ->where(DbTable_Site_Content::COL_FK_CONFIG_ACTIVE . '=?', Application_Constant_Db_Config_Active::ACTIVE);

        return $this->fetchRow($select);
    }
}
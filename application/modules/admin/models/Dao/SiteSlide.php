<?php

class Admin_Model_Dao_SiteSlide extends DbTable_Site_Slide
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
            $select->where(sprintf('%s like %s', new Zend_Db_Expr ('LOWER(' . DbTable_Site_Slide::COL_SITE_SLIDE_NAME . ')'), $this->getAdapter()->quote('%' . strtolower($name) . '%')));
        }

        if ($fkActive > -1) {
            $select->where(DbTable_Site_Slide::COL_FK_CONFIG_ACTIVE . ' =?', $fkActive);
        }
        $select->order(DbTable_Site_Slide::COL_SITE_SLIDE_CREATED_AT . ' desc');
        $select->order(DbTable_Site_Slide::COL_SITE_SLIDE_NAME . ' asc');

        return $select;
    }

    /**
     * @param $id
     * @return int
     */
    public function deleteById($id)
    {
        $where = sprintf('%s=%d', DbTable_Site_Slide::COL_SITE_SLIDE_ID, $id);
        return $this->delete($where);
    }

    /**
     * get all
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getAll()
    {
        $select = $this->select()
            ->where(DbTable_Site_Slide::COL_FK_CONFIG_ACTIVE . '=?', Application_Constant_Db_Config_Active::ACTIVE)
            ->order(DbTable_Site_Slide::COL_SITE_SLIDE_ID . ' asc');
        return $this->fetchAll($select);
    }
}
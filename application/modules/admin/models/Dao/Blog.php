<?php

class Admin_Model_Dao_Blog extends DbTable_Blog
{

    /**
     *
     * @param string $name
     * @param int $fkActive
     * @param int $fkComponent
     * @param int $fkCategory
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($name, $fkActive, $fkComponent, $fkCategory)
    {
        $select = $this->select();

        if ($name) {
            $select->where(sprintf('%s like %s', new Zend_Db_Expr ('LOWER(' . DbTable_Blog::COL_BLOG_NAME . ')'), $this->getAdapter()->quote('%' . strtolower($name) . '%')));
        }

        if ($fkActive > -1) {
            $select->where(DbTable_Blog::COL_FK_CONFIG_STATUS . ' =?', $fkActive);
        }

        if ($fkComponent) {
            $select->where(DbTable_Blog::COL_BLOG_CONTENT . ' =?', $fkComponent);
        }

        if ($fkCategory) {
            $select->where(DbTable_Blog::COL_FK_BLOG_CATEGORY . ' =?', $fkCategory);
        }

        $select->order(DbTable_Blog::COL_BLOG_ID . ' desc');

        return $select;
    }

    /**
     * delete blog by id
     *
     * @param int $id
     * @return int
     */
    public function deleteById($id)
    {
        $where = sprintf('%s=%d', DbTable_Blog::COL_BLOG_ID, $id);
        return $this->delete($where);
    }
}
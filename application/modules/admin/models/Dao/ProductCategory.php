<?php

class Admin_Model_Dao_ProductCategory extends DbTable_Product_Category
{

    /**
     * generate query for searching
     *
     * @param int $name
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($name)
    {
        $select = $this->select();
        if ($name) {
            $select->where(sprintf('%s like %s', new Zend_Db_Expr ('LOWER(' . DbTable_Product_Category::COL_PRODUCT_CATEGORY_NAME . ')'), $this->getAdapter()->quote('%' . strtolower($name) . '%')));
        }
        $select->order(DbTable_Product_Category::COL_FK_PRODUCT_COMPONENT . ' asc');
        $select->order(DbTable_Product_Category::COL_PRODUCT_CATEGORY_PARENT_ID . ' asc');
        $select->order(DbTable_Product_Category::COL_PRODUCT_CATEGORY_NAME . ' asc');
        $select->order(DbTable_Product_Category::COL_PRODUCT_CATEGORY_CREATED_AT . ' desc');

        return $select;
    }

    /**
     * delete category by id
     *
     * @param int $id
     * @return int
     */
    public function deleteById($id)
    {
        $where = sprintf('%s=%d', DbTable_Product_Category::COL_PRODUCT_CATEGORY_ID, $id);
        return $this->delete($where);
    }

    /**
     * get all parent category
     *
     */
    public function getAllParentCategory()
    {
        $select = $this->select()
            ->where(DbTable_Product_Category::COL_PRODUCT_CATEGORY_PARENT_ID . ' is null')
            ->where(DbTable_Product_Category::COL_PRODUCT_CATEGORY_STATUS . '=?', Application_Constant_Db_Config_Active::ACTIVE)
            ->order(DbTable_Product_Category::COL_PRODUCT_CATEGORY_PRIORITY . ' asc')
            ->order(DbTable_Product_Category::COL_PRODUCT_CATEGORY_NAME . ' asc');
        return $this->fetchAll($select);
    }

    /**
     * get all  category
     *
     */
    public function getAll()
    {
        $select = $this->select()
            ->order(DbTable_Product_Category::COL_PRODUCT_CATEGORY_PRIORITY . ' asc');
        return $this->fetchAll($select);
    }
}

?>
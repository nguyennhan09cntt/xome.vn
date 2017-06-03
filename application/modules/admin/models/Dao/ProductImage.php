<?php

class Admin_Model_Dao_ProductImage extends DbTable_Product_Image
{

    /**
     *
     * @param int $product
     * @param int $fkActive
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($product, $fkActive)
    {
        $select = $this->select();

        if ($product) {
            $select->where(DbTable_Product_Image::COL_FK_PRODUCT . ' =?', $product);
        }

        if ($fkActive > -1) {
            $select->where(DbTable_Product_Image::COL_FK_ACTIVE . ' =?', $fkActive);
        }
        $select->order(DbTable_Product_Image::COL_PRODUCT_IMAGE_CREATED_AT . ' desc');
        $select->order(DbTable_Product_Image::COL_PRODUCT_IMAGE_NAME . ' asc');

        return $select;
    }

    /**
     * delete category by id
     *
     * @param int|array $id
     * @return int
     */
    public function deleteById($id)
    {
        $where = sprintf('%s IN (%s)', DbTable_Product_Image::COL_PRODUCT_IMAGE_ID, $this->getAdapter()->quote($id));
        return $this->delete($where);
    }

    /**
     * @param $id
     * @return int
     */
    public function deleteByProductId($id)
    {
        $where = sprintf('%s IN (%s)', DbTable_Product_Image::COL_FK_PRODUCT, $this->getAdapter()->quote($id));
        return $this->delete($where);
    }
}

?>
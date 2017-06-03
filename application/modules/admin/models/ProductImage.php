<?php

class Admin_Model_ProductImage extends Application_Singleton
{

    /**
     *
     * @var Admin_Model_Dao_ProductImage
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_ProductImage ();
    }

    /**
     * @param $product
     * @param $fkActive
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($product, $fkActive)
    {

        $product = intval($product);
        $fkActive = intval($fkActive);
        return $this->_dao->searchQuery($product, $fkActive);
    }

    /**
     * @param $name
     * @param $note
     * @param $product
     * @return null|string
     */
    public function insert($name, $note, $product, $import = false)
    {
        $name = trim($name);
        $note = trim($note);
        $product = intval($product);
        $result = null;
        try {
            $params = array(
                DbTable_Product_Image::COL_PRODUCT_IMAGE_NAME => $name,
                DbTable_Product_Image::COL_PRODUCT_IMAGE_NOTE => $note,
                DbTable_Product_Image::COL_FK_PRODUCT => $product,
                DbTable_Product_Image::COL_PRODUCT_IMAGE_IMPORT => $import,
                DbTable_Product_Image::COL_PRODUCT_IMAGE_CREATED_AT => $this->_dao->mysqlSysDate()
            );
            $this->_dao->insert($params);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    /**
     * @param $id
     * @param $name
     * @param $note
     * @param $product
     * @return null|string
     */
    public function update($id, $name, $note, $product)
    {
        $name = trim($name);
        $note = trim($note);
        $product = intval($product);
        $result = null;
        try {
            $params = array(
                DbTable_Product_Image::COL_PRODUCT_IMAGE_NAME => $name,
                DbTable_Product_Image::COL_PRODUCT_IMAGE_NOTE => $note,
                DbTable_Product_Image::COL_FK_PRODUCT => $product
            );
            $where = sprintf('%s IN (%s)', DbTable_Product_Image::COL_PRODUCT_IMAGE_ID, $this->_dao->getAdapter()->quote($id));
            $this->_dao->update($params, $where);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    /**
     * delete image by id
     *
     * @param int|array $id
     * @return int
     */
    public function deleteById($id)
    {
        $id = is_array($id) ? $id : intval($id);
        return $this->_dao->deleteById($id);
    }

    public function deleteByProductId($productId)
    {
        $productId = is_array($productId) ? $productId : intval($productId);
        return $this->_dao->deleteByProductId($productId);
    }

    /**
     * get by id
     *
     * @param array|int $id
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getById($id)
    {
        $id = intval($id);
        return $this->_dao->find($id);
    }

    /**
     * Manual update active by Array|Single ID
     *
     * @param int $value
     * @param array|int $id
     * @return int
     */
    public function manualUpdateActive($value, $id)
    {

        $where = sprintf('%s IN (%s)', DbTable_Product_image::COL_PRODUCT_IMAGE_ID, $this->_dao->getAdapter()->quote($id));
        $params = array(
            DbTable_Product_image::COL_FK_ACTIVE => intval($value)
        );
        return $this->_dao->update($params, $where);
    }


}

?>
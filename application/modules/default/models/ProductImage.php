<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/20/2016
 * Time: 5:02 PM
 */
class Model_ProductImage extends Application_Singleton
{
    /**
     *
     * @var Model_Dao_ProductImage
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Model_Dao_ProductImage ();
    }

    /**
     * get by fk product
     * @param int $fkProduct
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getByFkProduct($fkProduct)
    {
        $select = Admin_Model_ProductImage::getInstance()->searchQuery($fkProduct, Application_Constant_Db_Config_Active::ACTIVE);
        return $this->_dao->fetchAll($select);
    }

    /**
     * Insert Image
     * @param $name
     * @param $note
     * @param $product
     * @return null|string
     */
    public function insert($name, $note, $product)
    {
        return Admin_Model_ProductImage::getInstance()->insert($name, $note, $product);
    }
}
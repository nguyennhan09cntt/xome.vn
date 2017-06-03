<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/21/2016
 * Time: 4:31 PM
 */
class Admin_Model_ProductProductOrder extends Application_Singleton
{
    /**
     *
     * @var Admin_Model_Dao_ProductProductOrder
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_ProductProductOrder ();
    }

    /**
     * @param $fkOrder
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function getByFkOrder($fkOrder)
    {
        $fkOrder = intval($fkOrder);
        return $this->_dao->getByFkOrder($fkOrder);
    }

    /**
     * delete  by id
     *
     * @param int $id
     * @return int
     */
    public function deleteById($id)
    {
        $id = intval($id);
        return $this->_dao->deleteById($id);
    }
}
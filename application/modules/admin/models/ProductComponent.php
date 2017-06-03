<?php
/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 4/22/2016
 * Time: 11:58 PM
 */

class Admin_Model_ProductComponent extends Application_Singleton
{

    /**
     *
     * @var Admin_Model_Dao_ProductComponent
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_ProductComponent ();
    }

    /**
     * get all
     * @return array|false|mixed
     */
    public function getAll()
    {
        $result = array();
        $key = Application_Cache_Admin::getInstance()->productComponentAllInfo();
        $result = Application_Cache::getInstance()->load($key);
        if (!$result) {
            $data = $this->_dao->fetchAll();
            if ($data) {
                foreach ($data as $item) {
                    $result[$item->{DbTable_Product_Component::COL_PRODUCT_COMPONENT_ID}] = $item->toArray();
                }
            }
            Application_Cache::getInstance()->save($result, $key, Application_Constant_Cache::PRODUCT_COMPONENT_ALL_INFO_LIFE_TIME);
        }
        return $result;
    }
}
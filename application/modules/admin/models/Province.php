<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/21/2016
 * Time: 3:57 PM
 */
class Admin_Model_Province extends Application_Singleton
{

    /**
     *
     * @var Admin_Model_Dao_Province
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_Province();
    }

    /**
     * get all
     * @return array|false|mixed
     */
    public function getAll(){
        $result = array();
        $key = Application_Cache_Admin::getInstance()->provinceAllInfo();
        $result = Application_Cache::getInstance()->load($key);
        if (!$result) {
            $data = $this->_dao->fetchAll();
            if ($data) {
                foreach ($data as $item) {
                    $result[$item->{DbTable_Province::COL_PROVINCE_ID}] = $item->toArray();
                }
            }
            Application_Cache::getInstance()->save($result, $key, Application_Constant_Cache::PROVINCE_ALL_INFO_LIFE_TIME);
        }
        return $result;
    }

}
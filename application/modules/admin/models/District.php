<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/21/2016
 * Time: 3:59 PM
 */
class Admin_Model_District extends Application_Singleton
{
    /**
     *
     * @var Admin_Model_Dao_District
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_District();
    }

    /**
     * get all
     * @return array|false|mixed
     */
    public function getAll()
    {
        $result = array();
        $key = Application_Cache_Admin::getInstance()->districtAllInfo();
        $result = Application_Cache::getInstance()->load($key);
        if (!$result) {
            $data = $this->_dao->fetchAll();
            if ($data) {
                foreach ($data as $item) {
                    $result[$item->{DbTable_District::COL_DISTRICT_ID}] = $item->toArray();
                }
            }
            Application_Cache::getInstance()->save($result, $key, Application_Constant_Cache::DISTRICT_ALL_INFO_LIFE_TIME);
        }
        return $result;
    }

    /**
     * @param $id
     * @param $identify
     * @return string
     */
    public function updateIdentify($id , $identify){
        $result = null;
        try {
            $params = array(
                DbTable_District::COL_DISTRICT_IDENTIFY => $identify
            );
            $where = sprintf('%s IN (%s)', DbTable_District::COL_DISTRICT_ID, $this->_dao->getAdapter()->quote($id));
            $this->_dao->update($params, $where);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }


    public function getByIdentify($districtIdentify)
    {

        return $this->_dao->getByIdentify($districtIdentify);
    }
}
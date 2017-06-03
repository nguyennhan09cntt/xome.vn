<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 4/23/15
 * Time: 10:45 AM
 */
class Admin_Model_ConfigProductFacility extends Application_Singleton
{
    /**
     * @var Admin_Model_Dao_ConfigProductFacility
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_ConfigProductFacility();
    }

    /**
     * Get all config of activation
     * @return array|false|mixed
     */
    public function getAll()
    {
        $result = array();
        $key = Application_Cache_Admin::getInstance()->configProductFacility();
        $result = Application_Cache::getInstance()->load($key);
        if (!$result) {
            $data = $this->_dao->fetchAll();
            if ($data) {
                foreach ($data as $item) {
                    $result[$item->{DbTable_Config_Product_Facility::COL_CONFIG_PRODUCT_FACILITY_ID}] = $item->toArray();                }

            }
            Application_Cache::getInstance()->save($result, $key, Application_Constant_Cache::CONFIG_PRODUCT_FACILITY_LIFE_TIME);
        }
        return $result;
    }

    /**
     * Get by ID
     * @param int $id
     * @return null|array
     */
    public function getById($id)
    {
        $id = intval($id);
        $dataAll = $this->getAll();
        return isset($dataAll[$id]) & $dataAll[$id] ? $dataAll[$id] : null;
    }
}
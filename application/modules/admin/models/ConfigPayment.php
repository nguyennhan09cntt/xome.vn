<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/21/2016
 * Time: 5:10 PM
 */
class Admin_Model_ConfigPayment extends Application_Singleton
{
    /**
     * @var Admin_Model_Dao_ConfigPayment
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_ConfigPayment();
    }

    /**
     * Get all config of activation
     * @return array|false|mixed
     */
    public
    function getAll()
    {
        $result = array();
        $key = Application_Cache_Admin::getInstance()->configPayment();
        $result = Application_Cache::getInstance()->load($key);
        if (!$result) {
            $data = $this->_dao->fetchAll();
            if ($data) {
                foreach ($data as $item) {
                    $result[$item->{DbTable_Config_Payment::COL_CONFIG_PAYMENT_ID}] = $item->toArray();
                }

            }
            Application_Cache::getInstance()->save($result, $key, null);
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
        $dataAll = $this->getAll();
        return isset($dataAll[$id]) & $dataAll[$id] ? $dataAll[$id] : null;
    }
}
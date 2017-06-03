<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 4/23/15
 * Time: 10:45 AM
 */
class Admin_Model_ConfigActive extends Application_Singleton
{
    /**
     * @var Admin_Model_Dao_ConfigActive
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_ConfigActive();
    }

    /**
     * Get all config of activation
     * @return array|false|mixed
     */
    public function getAll()
    {
        $result = array();
        $key = Application_Cache_Admin::getInstance()->configActive();
        $result = Application_Cache::getInstance()->load($key);
        if (!$result) {
            $data = $this->_dao->fetchAll();
            if ($data) {
                foreach ($data as $item) {
                    $result[$item->{DbTable_Config_Active::COL_CONFIG_ACTIVE_ID}] = $item->toArray();
                }
                $result[0] = array(
                    DbTable_Config_Active::COL_CONFIG_ACTIVE_NAME => 'Inactive'
                );
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
        $id = intval($id);
        $dataAll = $this->getAll();
        return isset($dataAll[$id]) & $dataAll[$id] ? $dataAll[$id] : null;
    }
}
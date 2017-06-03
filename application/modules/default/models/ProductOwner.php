<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 6/18/2016
 * Time: 2:26 PM
 */
class Model_ProductOwner extends Application_Singleton
{
    /**
     *
     * @var Model_Dao_ProductOwner
     */
    private $_dao;
    /**
     *
     * @var string
     */
    private $_prefix = 'XOMEVN';

    /**
     *
     * @var int
     */
    private $_secret = 5050;

    /**
     * Encode ID
     *
     * @param int $id
     * @return string
     */
    public function encode($id)
    {
        return $this->_prefix . strtoupper(dechex($id + $this->_secret));
    }

    /**
     * Decode ID to number
     *
     * @param string $code
     * @return int
     */
    public function decode($code)
    {
        $result = 0;
        if ($code && strstr(strtoupper($code), $this->_prefix)) {
            $code = strtoupper($code);
            $result = intval(hexdec(strtolower(str_replace($this->_prefix, '', $code))));
            $result = $result - $this->_secret;
        }
        return $result > 0 ? $result : 0;
    }

    protected function __construct()
    {
        $this->_dao = new Model_Dao_ProductOwner ();
    }

    public function insert($name, $phone, $email, $facebookId, $type){
        return Cli_Model_ProductOwner::getInstance()->insert($name, $phone, $email, $facebookId, $type);
    }
    /**
     * @param $page
     * @param $limit
     * @param $key
     * @return array
     */
    public function getListing($page, $limit, $key)
    {
        $page = intval($page);
        $limit = intval($limit);
        $key = trim($key);
        $isCache = false;
        $result = array();
        $paramsPage = $isCache ? 0 : $page;
        $paramsLimit = $isCache ? Application_Constant_Cache::CACHE_PAGE * $limit : $limit;
        $data = $this->_dao->getListing($paramsPage, $paramsLimit, $key);
        if ($data) {
            $total = isset($data[Application_Constant_Global::KEY_TOTAL]) ? $data[Application_Constant_Global::KEY_TOTAL] : 0;
            if ($total) {
                $data[Application_Constant_Global::KEY_DATA] = $data[Application_Constant_Global::KEY_DATA]->toArray();
                $result = $data;
            }
        }
        return $result;
    }

    /**
     * Get by id
     * @param $id
     * @return Zend_Db_Table_Rowset_Abstract
     * @throws Zend_Db_Table_Exception
     */
    public function getById($id)
    {
        $id = intval($id);
        return $this->_dao->find($id);
    }

    /**
     * @param $phone
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function getByPhone($phone){
        $phone = trim($phone);
        return $this->_dao->getByPhone($phone);
    }
}
<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 6/18/2016
 * Time: 2:26 PM
 */
class Model_Contact extends Application_Singleton
{
    /**
     *
     * @var Model_Dao_Contact
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
        $this->_dao = new Model_Dao_Contact ();
    }

    /**
     * @param $name
     * @param $email
     * @param $phone
     * @param $message
     * @return null|string|int
     */
    public function insert($name, $email, $phone, $message, $address, $price, $product, $image, $lat, $lng, $radius, $url, $color, $userId = null)
    {
        $name = trim($name);
        $email = trim($email);
        $phone = trim($phone);
        $message = trim($message);

        $result = null;
        try {
            $params = array(
                DbTable_Contact::COL_CONTACT_NAME => $name,
                DbTable_Contact::COL_CONTACT_EMAIL => $email,
                DbTable_Contact::COL_CONTACT_PHONE => $phone,
                DbTable_Contact::COL_CONTACT_MESSAGE => $message,
                DbTable_Contact::COL_CONTACT_ADDRESS => $address,
                DbTable_Contact::COL_CONTACT_PRICE => $price,
                DbTable_Contact::COL_CONTACT_PRODUCT => $product,
                DbTable_Contact::COL_CONTACT_IMAGE => $image,
                DbTable_Contact::COL_CONTACT_LAT => $lat,
                DbTable_Contact::COL_CONTACT_LNG => $lng,
                DbTable_Contact::COL_CONTACT_RADIUS => $radius,
                DbTable_Contact::COL_CONTACT_COLOR => $color,
                DbTable_Contact::COL_CONTACT_STATUS => Application_Constant_Db_Config_Active::PENDING,
                DbTable_Contact::COL_CONTACT_URL_STATIC_MAP => $url,
                DbTable_Contact::COL_FK_CUSTOMER => $userId,
                DbTable_Contact::COL_CONTACT_CREATED_AT => $this->_dao->mysqlSysDate()
            );
            $result = $this->_dao->insertAndGetLastInsertId($params);
            Application_Cache_Default::getInstance()->cleanTags(array(Application_Constant_Global::KEY_COMPONENT_CONTACT));
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    public function getListing($page, $limit, $componentId, $categoryId)
    {
        $page = intval($page);
        $limit = intval($limit);
        $categoryId = $categoryId ? intval($categoryId) : null;

        $isCache = $page <= Application_Constant_Cache::CACHE_PAGE;
        $result = array();
        $key = Application_Cache_Default::getInstance()->contactListing($componentId, $categoryId);
        if ($isCache) {
            $result = Application_Cache_Default::getInstance()->load($key);
        }
        if (!$result) {
            $paramsPage = $isCache ? 0 : $page;
            $paramsLimit = $isCache ? Application_Constant_Cache::CACHE_PAGE * $limit : $limit;
            $data = $this->_dao->getListing($paramsPage, $paramsLimit, $componentId, $categoryId);

            if ($data) {
                $total = isset($data[Application_Constant_Global::KEY_TOTAL]) ? $data[Application_Constant_Global::KEY_TOTAL] : 0;
                if ($total) {
                    $data[Application_Constant_Global::KEY_DATA] = $data[Application_Constant_Global::KEY_DATA]->toArray();
                    if ($isCache) {
                        Application_Cache_Default::getInstance()->save($data, $key, Application_Constant_Cache::PRODUCT_LISTING_ALL_INFO_LIFE_TIME, array(Application_Constant_Global::KEY_COMPONENT_CONTACT));
                    }
                    $result = $data;
                }
            }
        }
        if ($isCache && $result) {
            $offset = ($page - 1) * $limit;
            $result[Application_Constant_Global::KEY_DATA] = array_slice(
                $result[Application_Constant_Global::KEY_DATA],
                $offset,
                $limit
            );
        }
        return $result;
    }

    /**
     * @param int $id
     * @return Zend_Db_Table_Rowset_Abstract
     * @throws Zend_Db_Table_Exception
     */
    public function getById($id)
    {
        $id = intval($id);
        return $this->_dao->find($id);
    }
}
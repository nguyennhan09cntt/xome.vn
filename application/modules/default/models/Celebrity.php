<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 8/15/2016
 * Time: 1:58 PM
 */
class Model_Celebrity extends Application_Singleton
{

    /**
     *
     * @var Admin_Model_Dao_Celebrity
     */
    private $_dao;

    /**
     *
     * @var string
     */
    private $_prefix = 'LN3';

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
        if ($code && strstr($code, $this->_prefix)) {
            $code = strtoupper($code);
            $result = intval(hexdec(strtolower(str_replace($this->_prefix, '', $code))));
            $result = $result - $this->_secret;
        }
        return $result > 0 ? $result : 0;
    }

    protected function __construct()
    {
        $this->_dao = new Model_Dao_Celebrity();
    }


    public function search($page, $limit, $name, $code, $category, $active, $priority, $tag, $province)
    {
        $name = trim($name);
        $code = trim($code);
        return $this->_dao->search($page, $limit, $name, $code, $category, $active, $priority, $tag, $province);
    }

    public function getListing($page, $limit, $componentId, $categoryId, $gender)
    {
        $page = intval($page);
        $limit = intval($limit);
        $categoryId = intval($categoryId);

        $isCache = $page <= Application_Constant_Cache::CACHE_PAGE;
        $result = array();
        $key = Application_Cache_Default::getInstance()->celebrityListing($componentId, $categoryId, $gender);
        if ($isCache) {
            $result = Application_Cache_Default::getInstance()->load($key);
        }
        if (!$result) {
            $paramsPage = $isCache ? 0 : $page;
            $paramsLimit = $isCache ? Application_Constant_Cache::CACHE_PAGE * $limit : $limit;
            $data = $this->_dao->getListing($paramsPage, $paramsLimit, $componentId, $categoryId, $gender);
            if ($data) {
                $total = isset($data[Application_Constant_Global::KEY_TOTAL]) ? $data[Application_Constant_Global::KEY_TOTAL] : 0;
                if ($total) {
                    $data[Application_Constant_Global::KEY_DATA] = $data[Application_Constant_Global::KEY_DATA]->toArray();
                    if ($isCache) {
                        Application_Cache_Default::getInstance()->save($data, $key, Application_Constant_Cache::CELEBRITY_LISTING_ALL_INFO_LIFE_TIME, array(Application_Constant_Global::KEY_COMPONENT_CELEBRITY));
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

    public function getById($id)
    {
        return $this->_dao->find($id);
    }


    public function insert($name, $facebookLink, $image, $category, $componentId, $description, $shortDescription, $note, $province, $district, $gender, $tag, $userId = null)
    {
        $name = trim($name);
        $identify = Application_Function_String::getFormatUrl($name);
        $category = $category ? intval($category) : null;
        $result = null;
        try {
            $params = array(
                DbTable_Celebrity::COL_CELEBRITY_NAME => $name,
                DbTable_Celebrity::COL_CELEBRITY_IDENTIFY => $identify,
                DbTable_Celebrity::COL_CELEBRITY_THUMB_NAIL => $image,
                DbTable_Celebrity::COL_FK_CELEBRITY_CATEGORY => $category,
                DbTable_Celebrity::COL_FK_CELEBRITY_COMPONENT => $componentId,
                DbTable_Celebrity::COL_CELEBRITY_FACEBOOK_URL => $facebookLink,
                DbTable_Celebrity::COL_CELEBRITY_DESCRIPTION => $shortDescription,
                DbTable_Celebrity::COL_CELEBRITY_CONTENT => $description,
                DbTable_Celebrity::COL_CELEBRITY_NOTE => $note,
                DbTable_Celebrity::COL_FK_PROVICE => $province,
                DbTable_Celebrity::COL_FK_DISTRICT => $district,
                DbTable_Celebrity::COL_CELEBRITY_GENDER => $gender,
                DbTable_Celebrity::COL_CELEBRITY_TAG => $tag,
                DbTable_Celebrity::COL_CELEBRITY_FACEBOOK_ID => $userId,
                DbTable_Celebrity::COL_FK_CONFIG_STATUS => Application_Constant_Db_Config_Active::ACTIVE,
                DbTable_Celebrity::COL_CELEBRITY_CREATED_AT => $this->_dao->mysqlSysDate()
            );
            $this->_dao->insert($params);

        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    public function update($id, $name, $facebookLink, $image, $category, $componentId, $description, $shortDescription, $note, $province, $district, $gender, $tag)
    {
        $name = trim($name);

        $result = null;
        try {
            $params = array(
                DbTable_Celebrity::COL_CELEBRITY_NAME => $name,
                //DbTable_Celebrity::COL_CELEBRITY_IDENTIFY => $identify,
                DbTable_Celebrity::COL_CELEBRITY_THUMB_NAIL => $image,
                DbTable_Celebrity::COL_FK_CELEBRITY_CATEGORY => $category,
                DbTable_Celebrity::COL_FK_CELEBRITY_COMPONENT => $componentId,
                DbTable_Celebrity::COL_CELEBRITY_FACEBOOK_URL => $facebookLink,
                DbTable_Celebrity::COL_CELEBRITY_DESCRIPTION => $shortDescription,
                DbTable_Celebrity::COL_CELEBRITY_CONTENT => $description,
                DbTable_Celebrity::COL_CELEBRITY_NOTE => $note,
                DbTable_Celebrity::COL_FK_PROVICE => $province,
                DbTable_Celebrity::COL_FK_DISTRICT => $district,
                DbTable_Celebrity::COL_CELEBRITY_GENDER => $gender,
                DbTable_Celebrity::COL_CELEBRITY_TAG => $tag,
            );
            $where = sprintf('%s IN (%s)', DbTable_Celebrity::COL_CELEBRITY_ID, $this->_dao->getAdapter()->quote($id));
            $this->_dao->update($params, $where);

        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }


    /**
     * get identify
     * @param string $identify
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function getByIdentify($identify)
    {
        $identify = trim($identify);
        return $this->_dao->getByIdentify($identify);
    }


    public function getByFacebookId($userId)
    {
        $userId = trim($userId);
        return $this->_dao->getByFacebookId($userId);
    }


}
<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/19/2016
 * Time: 5:56 PM
 */
class Model_Blog extends Application_Singleton
{
    /**
     *
     * @var Model_Dao_Blog
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Model_Dao_Blog ();
    }

    /**
     * get blog listing at home page
     * @param $page
     * @param $limit
     * @param $categoryId
     * @return array|false|mixed
     */
    public function getHomeListing($page, $limit, $categoryId)
    {
        $page = intval($page);
        $limit = intval($limit);
        $categoryId = intval($categoryId);

        $isCache = $page <= Application_Constant_Cache::CACHE_PAGE;
        $result = array();
        $key = Application_Cache_Default::getInstance()->homeBlog();
        if ($isCache) {
            $result = Application_Cache_Default::getInstance()->load($key);
        }
        if (!$result) {
            $paramsPage = $isCache ? 0 : $page;
            $paramsLimit = $isCache ? Application_Constant_Cache::CACHE_PAGE * $limit : $limit;
            $data = $this->_dao->getListing($paramsPage, $paramsLimit, $categoryId);
            if ($data) {
                $total = isset($data[Application_Constant_Global::KEY_TOTAL]) ? $data[Application_Constant_Global::KEY_TOTAL] : 0;
                if ($total) {
                    $data[Application_Constant_Global::KEY_DATA] = $data[Application_Constant_Global::KEY_DATA]->toArray();
                    if ($isCache) {
                        Application_Cache_Default::getInstance()->save($data, $key, Application_Constant_Cache::HOME_BLOG_ALL_INFO_LIFE_TIME);
                    }
                    $result = $data;
                }
            }
        }
        if ($isCache && $result) {
            $offset = ($page-1) * $limit;
            $result[Application_Constant_Global::KEY_DATA] = array_slice(
                $result[Application_Constant_Global::KEY_DATA],
                $offset,
                $limit
            );
        }
        return $result;
    }


    /**
     * get blog listing at home page
     * @param $page
     * @param $limit
     * @param $categoryId
     * @return array|false|mixed
     */
    public function getListing($page, $limit, $categoryId)
    {
        $page = intval($page);
        $limit = intval($limit);
        $categoryId = intval($categoryId);

        $isCache = $page <= Application_Constant_Cache::CACHE_PAGE;
        $result = array();
        $key = Application_Cache_Default::getInstance()->newsListingBlog($categoryId);
        if ($isCache) {
            $result = Application_Cache_Default::getInstance()->load($key);
        }
        if (!$result) {
            $paramsPage = $isCache ? 0 : $page;
            $paramsLimit = $isCache ? Application_Constant_Cache::CACHE_PAGE * $limit : $limit;
            $data = $this->_dao->getListing($paramsPage, $paramsLimit, $categoryId);
            if ($data) {
                $total = isset($data[Application_Constant_Global::KEY_TOTAL]) ? $data[Application_Constant_Global::KEY_TOTAL] : 0;
                if ($total) {
                    $data[Application_Constant_Global::KEY_DATA] = $data[Application_Constant_Global::KEY_DATA]->toArray();
                    if ($isCache) {
                        Application_Cache_Default::getInstance()->save($data, $key, Application_Constant_Cache::BLOG_NEW_LISTING_LIFE_TIME, array(Application_Constant_Cache::BLOG_NEW_LISTING));
                    }
                    $result = $data;
                }
            }
        }
        if ($isCache && $result) {
            $offset = ($page-1) * $limit;
            $result[Application_Constant_Global::KEY_DATA] = array_slice(
                $result[Application_Constant_Global::KEY_DATA],
                $offset,
                $limit
            );
        }
        return $result;
    }

    /**
     * get identify
     * @param string $identify
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function getByIdentify($identify){
        $identify = trim($identify);
        return $this->_dao->getByIdentify($identify);
    }

    /**
     * get blog listing at home page
     * @param $page
     * @param $limit
     * @param $categoryId
     * @return array|false|mixed
     */
    public function getNewBlog($page, $limit, $categoryId)
    {
        $page = intval($page);
        $limit = intval($limit);
        $categoryId = intval($categoryId);

        $isCache = $page <= Application_Constant_Cache::CACHE_PAGE;
        $result = array();
        $key = Application_Cache_Default::getInstance()->blogNewListing();
        if ($isCache) {
            $result = Application_Cache_Default::getInstance()->load($key);
        }
        if (!$result) {
            $paramsPage = $isCache ? 0 : $page;
            $paramsLimit = $isCache ? Application_Constant_Cache::CACHE_PAGE * $limit : $limit;
            $data = $this->_dao->getListing($paramsPage, $paramsLimit, $categoryId);
            if ($data) {
                $total = isset($data[Application_Constant_Global::KEY_TOTAL]) ? $data[Application_Constant_Global::KEY_TOTAL] : 0;
                if ($total) {
                    $data[Application_Constant_Global::KEY_DATA] = $data[Application_Constant_Global::KEY_DATA]->toArray();
                    if ($isCache) {
                        Application_Cache_Default::getInstance()->save($data, $key, Application_Constant_Cache::HOME_BLOG_ALL_INFO_LIFE_TIME);
                    }
                    $result = $data;
                }
            }
        }
        if ($isCache && $result) {
            $offset = ($page-1) * $limit;
            $result[Application_Constant_Global::KEY_DATA] = array_slice(
                $result[Application_Constant_Global::KEY_DATA],
                $offset,
                $limit
            );
        }
        return $result;
    }
}
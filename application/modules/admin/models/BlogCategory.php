<?php

class Admin_Model_BlogCategory extends Application_Singleton
{

    /**
     *
     * @var Admin_Model_Dao_BlogCategory
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_BlogCategory ();
    }

    /**
     *
     * @param int $componentId
     * @param string $name
     * @param int $status
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($componentId, $name, $status)
    {
        $name = trim($name);
        $componentId = intval($componentId);
        return $this->_dao->searchQuery($componentId, $name, $status);
    }

    /**
     * insert blog category
     * @param $name
     * @param $category
     * @param $componentId
     * @return null|string
     */
    public function insert($name, $category, $componentId)
    {
        $name = trim($name);
        $identify = Application_Function_String::getFormatUrl($name);
        $category = $category ? intval($category) : null;
        $componentId = $componentId ? intval($componentId) : null;
        $result = null;
        try {
            $params = array(
                DbTable_Blog_Category::COL_BLOG_CATEGORY_NAME => $name,
                DbTable_Blog_Category::COL_BLOG_CATEGORY_IDENTIFY => $identify,
                DbTable_Blog_Category::COL_BLOG_CATEGORY_PARENT_ID => $category,
                DbTable_Blog_Category::COL_FK_COMPONENT => $componentId,
                DbTable_Blog_Category::COL_BLOG_CATEGORY_CREATED_AT => $this->_dao->mysqlSysDate()
            );
            $this->_dao->insert($params);
            Application_Cache_Admin::getInstance()->resetBlogCategory();
            Application_Cache_Admin::getInstance()->resetBlogCategoryAllInfo();
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    /**
     * update blog category
     * @param int $id
     * @param string $name
     * @param string $identify
     * @param int $position
     * @return null|string
     */
    public function update($id, $name, $identify, $position)
    {
        $name = trim($name);
        $identify = trim($identify);
        $position = intval($position);
        $result = null;
        try {
            $params = array(
                DbTable_Blog_Category::COL_BLOG_CATEGORY_NAME => $name,
                DbTable_Blog_Category::COL_BLOG_CATEGORY_IDENTIFY => $identify,
                /*DbTable_Blog_Category::COL_BLOG_CATEGORY_POSITION => $position*/
            );
            $where = sprintf('%s IN (%s)', DbTable_Blog_Category::COL_BLOG_CATEGORY_ID, $this->_dao->getAdapter()->quote($id));
            $this->_dao->update($params, $where);
            Application_Cache_Admin::getInstance()->resetBlogCategory();
            Application_Cache_Admin::getInstance()->resetBlogCategoryAllInfo();
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    /**
     * delete category by id
     *
     * @param int $id
     * @return int
     */
    public function deleteById($id)
    {
        $id = intval($id);
        Application_Cache_Admin::getInstance()->resetBlogCategory();
        Application_Cache_Admin::getInstance()->resetBlogCategoryAllInfo();
        return $this->_dao->deleteById($id);
    }

    /**
     * get by id
     *
     * @param array|int $id
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getById($id)
    {
        $id = intval($id);
        return $this->_dao->find($id);
    }

    /**
     * Manual update active by Array|Single ID
     *
     * @param int $value
     * @param array|int $id
     * @return int
     */
    public function manualUpdateActive($value, $id)
    {
        $where = sprintf('%s IN (%s)', DbTable_Blog_Category::COL_BLOG_CATEGORY_ID, $this->_dao->getAdapter()->quote($id));
        $params = array(
            DbTable_Blog_Category::COL_FK_CONFIG_STATUS => intval($value)
        );
        Application_Cache_Admin::getInstance()->resetBlogCategory();
        Application_Cache_Admin::getInstance()->resetBlogCategoryAllInfo();
        return $this->_dao->update($params, $where);
    }

    /**
     * get category
     * @return array|false|mixed
     */
    public function getAllParentCategory()
    {
        $result = array();
        $key = Application_Cache_Admin::getInstance()->blogCategory();
        $result = Application_Cache::getInstance()->load($key);
        if (!$result) {
            $data = $this->_dao->getAllParentCategory();
            if ($data) {
                foreach ($data as $item) {
                    $result[$item->{DbTable_Blog_Category::COL_BLOG_CATEGORY_ID}] = $item->toArray();
                }
            }
            Application_Cache::getInstance()->save($result, $key, Application_Constant_Cache::BLOG_CATEGORY_LIFE_TIME);
        }
        return $result;
    }

    /**
     * get all
     * @return array|false|mixed
     */
    public function getAll()
    {
        $result = array();
        $key = Application_Cache_Admin::getInstance()->blogCategoryAllInfo();
        $result = Application_Cache::getInstance()->load($key);
        if (!$result) {
            $data = $this->_dao->fetchAll();
            if ($data) {
                foreach ($data as $item) {
                    $result[$item->{DbTable_Blog_Category::COL_BLOG_CATEGORY_ID}] = $item->toArray();
                }
            }
            Application_Cache::getInstance()->save($result, $key, Application_Constant_Cache::BLOG_CATEGORY_ALL_INFO_LIFE_TIME);
        }
        return $result;
    }
}
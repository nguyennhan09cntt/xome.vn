<?php

class Admin_Model_Blog extends Application_Singleton
{

    /**
     *
     * @var Admin_Model_Dao_Blog
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_Blog ();
    }

    /**
     * @param $name
     * @param $fkActive
     * @param $fkComponent
     * @param $fkCategory
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($name, $fkActive, $fkComponent, $fkCategory)
    {
        $name = intval($name);
        $fkActive = intval($fkActive);
        return $this->_dao->searchQuery($name, $fkActive, $fkComponent, $fkCategory);
    }

    /**
     * @param $name
     * @param $image
     * @param $content
     * @param $description
     * @param $category
     * @param $component
     * @return null|string
     */
    public function insert($name, $image, $content, $description, $category, $component)
    {
        $name = trim($name);
        $identify = Application_Function_String::getFormatUrl($name);
        $image = trim($image);
        $content = trim($content);
        $category = intval($category);
        $component = intval($component);
        $result = null;
        try {
            $params = array(
                DbTable_Blog::COL_BLOG_NAME => $name,
                DbTable_Blog::COL_BLOG_IDENTIFY => $identify,
                DbTable_Blog::COL_BLOG_IMAGE => $image,
                DbTable_Blog::COL_BLOG_THUMB_IMAGE => $image,
                DbTable_Blog::COL_BLOG_CONTENT => $content,
                DbTable_Blog::COL_BLOG_DESCRIPTION => $description,
                DbTable_Blog::COL_FK_BLOG_CATEGORY => $category,
                DbTable_Blog::COL_FK_COMPONENT => $component,
                DbTable_Blog::COL_FK_CONFIG_STATUS => Application_Constant_Db_Config_Active::ACTIVE,
                DbTable_Blog::COL_BLOG_CREATED_AT => $this->_dao->mysqlSysDate()
            );
            $this->_dao->insert($params);
            Application_Cache_Default::getInstance()->resetNewsListingBlog($category);
            Application_Cache_Default::getInstance()->resetHomeBlog();
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }


    public function update($id, $name, $image, $content, $description, $category, $component)
    {
        $name = trim($name);
        $identify = Application_Function_String::getFormatUrl($name);
        $image = trim($image);
        $content = trim($content);
        $category = intval($category);
        $component = intval($component);
        $id = intval($id);
        $result = null;
        try {
            $params = array(
                DbTable_Blog::COL_BLOG_NAME => $name,
                DbTable_Blog::COL_BLOG_IDENTIFY => $identify,
                DbTable_Blog::COL_BLOG_IMAGE => $image,
                DbTable_Blog::COL_BLOG_THUMB_IMAGE => $image,
                DbTable_Blog::COL_BLOG_CONTENT => $content,
                DbTable_Blog::COL_BLOG_DESCRIPTION => $description,
                DbTable_Blog::COL_FK_BLOG_CATEGORY => $category,
                DbTable_Blog::COL_FK_COMPONENT => $component,
            );
            $where = sprintf('%s IN (%s)', DbTable_Blog::COL_BLOG_ID, $this->_dao->getAdapter()->quote($id));
            $this->_dao->update($params, $where);
            Application_Cache_Default::getInstance()->resetNewsListingBlog($category);
            Application_Cache_Default::getInstance()->resetHomeBlog();
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    /**
     * delete image by id
     *
     * @param int $id
     * @return int
     */
    public function deleteById($id)
    {
        $id = intval($id);
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
        $where = sprintf('%s IN (%s)', DbTable_Blog::COL_BLOG_ID, $this->_dao->getAdapter()->quote($id));
        $params = array(
            DbTable_Blog::COL_FK_CONFIG_STATUS => intval($value)
        );
        Application_Cache_Default::getInstance()->resetNewsListingBlog(1);
        Application_Cache_Default::getInstance()->resetNewsListingBlog(2);
        Application_Cache_Default::getInstance()->resetNewsListingBlog(3);
        Application_Cache_Default::getInstance()->resetHomeBlog();
        return $this->_dao->update($params, $where);
    }

    public function getAll()
    {
        $data = $this->_dao->fetchAll();
        return $data ? $data->toArray() : array();
    }

    /**
     * @param $id
     * @param $content
     * @return null|string
     */
    public function updateContent($id, $content)
    {
        $content = trim($content);
        $id = intval($id);
        $result = null;
        try {
            $params = array(
                DbTable_Blog::COL_BLOG_CONTENT => $content,
            );
            $where = sprintf('%s IN (%s)', DbTable_Blog::COL_BLOG_ID, $this->_dao->getAdapter()->quote($id));
            $this->_dao->update($params, $where);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }


}


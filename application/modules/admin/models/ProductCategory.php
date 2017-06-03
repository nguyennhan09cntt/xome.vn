<?php

class Admin_Model_ProductCategory extends Application_Singleton
{

    /**
     *
     * @var Admin_Model_Dao_ProductCategory
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_ProductCategory ();
    }

    /**
     * @param $name
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($name)
    {
        $name = trim($name);
        return $this->_dao->searchQuery($name);
    }

    /**
     * @param string $name
     * @param int $category
     * @param int $componentId
     * @return null|string
     */
    public function insert($name, $category, $componentId, $display, $priority)
    {
        $name = trim($name);
        $identify = Application_Function_String::getFormatUrl($name);
        $category = $category ? intval($category) : null;
        $result = null;
        try {
            $params = array(
                DbTable_Product_Category::COL_PRODUCT_CATEGORY_NAME => $name,
                DbTable_Product_Category::COL_PRODUCT_CATEGORY_IDENTIFY => $identify,
                DbTable_Product_Category::COL_PRODUCT_CATEGORY_PARENT_ID => $category,
                DbTable_Product_Category::COL_FK_PRODUCT_COMPONENT => $componentId,
                DbTable_Product_Category::COL_PRODUCT_CATEGORY_DISPLAY_HOME => $display,
                DbTable_Product_Category::COL_PRODUCT_CATEGORY_PRIORITY => $priority,
                DbTable_Product_Category::COL_PRODUCT_CATEGORY_CREATED_AT => $this->_dao->mysqlSysDate()
            );
            $this->_dao->insert($params);
            Application_Cache_Admin::getInstance()->resetProductCategoryAllInfo();
            Application_Cache_Admin::getInstance()->resetProductCategory();
            Application_Cache_Admin::getInstance()->resetProductCategoryAll();
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    /**
     * update product category
     * @param $id
     * @param $name
     * @param $identify
     * @param $category
     * @return null|string
     */
    public function update($id, $name, $identify, $category, $componentId, $display, $priority)
    {
        $name = trim($name);
        $identify = str_replace(' ', "", $identify);//Application_Function_String::getFormatUrl($identify);
        $category = $category ? intval($category) : null;
        $display = intval($display);
        $result = null;
        try {
            $params = array(
                DbTable_Product_Category::COL_PRODUCT_CATEGORY_NAME => $name,
                DbTable_Product_Category::COL_PRODUCT_CATEGORY_IDENTIFY => $identify,
                DbTable_Product_Category::COL_PRODUCT_CATEGORY_PARENT_ID => $category,
                DbTable_Product_Category::COL_PRODUCT_CATEGORY_DISPLAY_HOME => $display,
                DbTable_Product_Category::COL_FK_PRODUCT_COMPONENT => $componentId,
                DbTable_Product_Category::COL_PRODUCT_CATEGORY_PRIORITY => $priority
            );
            $where = sprintf('%s IN (%s)', DbTable_Product_Category::COL_PRODUCT_CATEGORY_ID, $this->_dao->getAdapter()->quote($id));
            $this->_dao->update($params, $where);
            Application_Cache_Admin::getInstance()->resetProductCategoryAllInfo();
            Application_Cache_Admin::getInstance()->resetProductCategory();
            Application_Cache_Admin::getInstance()->resetProductCategoryAll();
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
     * @param int $value
     * @param array|int $id
     * @return int
     */
    public function manualUpdateActive($value, $id)
    {

        $where = sprintf(
            '%s IN (%s)',
            DbTable_Product_Category::COL_PRODUCT_CATEGORY_ID,
            $this->_dao->getAdapter()->quote($id)
        );
        $params = array(DbTable_Product_Category::COL_PRODUCT_CATEGORY_STATUS => intval($value));
        Application_Cache_Admin::getInstance()->resetProductCategoryAllInfo();
        Application_Cache_Admin::getInstance()->resetProductCategory();
        Application_Cache_Admin::getInstance()->resetProductCategoryAll();
        return $this->_dao->update($params, $where);
    }


    /**
     * get category
     * @return array|false|mixed
     */
    public function getAllParentCategory()
    {
        $result = array();
        $key = Application_Cache_Admin::getInstance()->productCategory();
        $result = Application_Cache::getInstance()->load($key);
        if (!$result) {
            $data = $this->_dao->getAllParentCategory();
            if ($data) {
                foreach ($data as $item) {
                    $result[$item->{DbTable_Product_Category::COL_PRODUCT_CATEGORY_ID}] = $item->toArray();
                }
            }
            Application_Cache::getInstance()->save($result, $key, Application_Constant_Cache::PRODUCT_CATEGORY_ALL_INFO);
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
        $key = Application_Cache_Admin::getInstance()->productCategoryAllInfo();
        $result = Application_Cache::getInstance()->load($key);
        if (!$result) {
            $data = $this->_dao->getAll();
            if ($data) {
                foreach ($data as $item) {
                    $result[$item->{DbTable_Product_Category::COL_PRODUCT_CATEGORY_ID}] = $item->toArray();
                }
            }
            Application_Cache::getInstance()->save($result, $key, Application_Constant_Cache::PRODUCT_CATEGORY_ALL_INFO_LIFE_TIME);
        }
        return $result;
    }

    /**
     * get category
     * @return array|false|mixed
     */
    public function getAllProductCategory()
    {
        $result = array();
        $key = Application_Cache_Admin::getInstance()->productCategoryAll();
        $result = Application_Cache::getInstance()->load($key);
        if (!$result) {
            $data = $this->getAll();
            if ($data) {
                foreach ($data as $item) {
                    if ($item[DbTable_Product_Category::COL_PRODUCT_CATEGORY_PARENT_ID] == null)
                        $result[$item[DbTable_Product_Category::COL_PRODUCT_CATEGORY_ID]] = $item;
                }
            }
            Application_Cache::getInstance()->save($result, $key, Application_Constant_Cache::PRODUCT_CATEGORY_ALL_LIFE_TIME);
        }
        return $result;
    }
}

?>
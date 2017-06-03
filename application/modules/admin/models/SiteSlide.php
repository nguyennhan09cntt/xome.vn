<?php

class Admin_Model_SiteSlide extends Application_Singleton
{

    /**
     *
     * @var Admin_Model_Dao_SiteSlide
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_SiteSlide ();
    }

    /**
     * @param $name
     * @param $fkActive
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($name, $fkActive)
    {
        $name = intval($name);
        $fkActive = intval($fkActive);
        return $this->_dao->searchQuery($name, $fkActive);
    }

    /**
     * insert slide
     * @param $name
     * @param $image
     * @return null|string
     */
    public function insert($name, $image)
    {
        $name = trim($name);
        $image = trim($image);

        $result = null;
        try {
            $params = array(
                DbTable_Site_Slide::COL_SITE_SLIDE_NAME => $name,
                DbTable_Site_Slide::COL_SITE_SLIDE_THUMBNAIL => $image,
                DbTable_Site_Slide::COL_SITE_SLIDE_CREATED_AT => $this->_dao->mysqlSysDate()
            );
            $this->_dao->insert($params);
            Application_Cache_Default::getInstance()->resetSiteSlideAllInfo();
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    /**
     * update product image
     * @param $id
     * @param $name
     * @param $image
     * @return null|string
     */
    public function update($id, $name, $image)
    {
        $name = trim($name);
        $image = trim($image);
        $id = intval($id);
        $result = null;
        try {
            $params = array(
                DbTable_Site_Slide::COL_SITE_SLIDE_NAME => $name,
                DbTable_Site_Slide::COL_SITE_SLIDE_THUMBNAIL => $image
            );
            $where = sprintf('%s IN (%s)', DbTable_Site_Slide::COL_SITE_SLIDE_ID, $this->_dao->getAdapter()->quote($id));
            $this->_dao->update($params, $where);
            Application_Cache_Default::getInstance()->resetSiteSlideAllInfo();
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
        Application_Cache_Default::getInstance()->resetSiteSlideAllInfo();
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
        $where = sprintf('%s IN (%s)', DbTable_Site_Slide::COL_SITE_SLIDE_ID, $this->_dao->getAdapter()->quote($id));
        $params = array(
            DbTable_Site_Slide::COL_FK_CONFIG_ACTIVE => intval($value)
        );
        Application_Cache_Default::getInstance()->resetSiteSlideAllInfo();
        return $this->_dao->update($params, $where);
    }

    /**
     * get all
     * @return array|false|mixed
     */
    public function getAll(){
        $result = array();
        $key = Application_Cache_Default::getInstance()->siteSlideAllInfo();
        $result = Application_Cache::getInstance()->load($key);
        if (!$result) {
            $data = $this->_dao->getAll();
            if ($data) {
                foreach ($data as $item) {
                    $result[$item->{DbTable_Site_Slide::COL_SITE_SLIDE_ID}] = $item->toArray();
                }
            }
            Application_Cache::getInstance()->save($result, $key, Application_Constant_Cache::SITE_SLIDE_ALL_INFO_LIFE_TIME);
        }
        return $result;
    }
}

?>
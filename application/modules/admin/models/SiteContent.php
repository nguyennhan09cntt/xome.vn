<?php

class Admin_Model_SiteContent extends Application_Singleton
{

    /**
     *
     * @var Admin_Model_Dao_SiteContent
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_SiteContent ();
    }

    /**
     * @param $name
     * @param $fkActive
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($name, $fkActive)
    {
        $name = trim($name);
        $fkActive = intval($fkActive);
        return $this->_dao->searchQuery($name, $fkActive);
    }

    /**
     * insert slide
     * @param $name
     * @param $image
     * @return null|string
     */
    public function insert($name, $content)
    {
        $name = trim($name);
        $identify = Application_Function_String::getFormatUrl($name);

        $result = null;
        try {
            $params = array(
                DbTable_Site_Content::COL_SITE_CONTENT_NAME => $name,
                DbTable_Site_Content::COL_SITE_CONTENT_IDENTIFY => $identify,
                DbTable_Site_Content::COL_SITE_CONTENT_CONTENT => $content,
                DbTable_Site_Content::COL_SITE_CONTENT_CREATED_AT => $this->_dao->mysqlSysDate()
            );
            $this->_dao->insert($params);

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
    public function update($id, $name, $identify, $content)
    {
        $name = trim($name);
        $identify = trim($identify);
        $id = intval($id);
        $result = null;
        try {
            $params = array(
                DbTable_Site_Content::COL_SITE_CONTENT_NAME => $name,
                DbTable_Site_Content::COL_SITE_CONTENT_IDENTIFY => $identify,
                DbTable_Site_Content::COL_SITE_CONTENT_CONTENT => $content,
            );
            $where = sprintf('%s IN (%s)', DbTable_Site_Content::COL_SITE_CONTENT_ID, $this->_dao->getAdapter()->quote($id));
            $this->_dao->update($params, $where);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
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
        $where = sprintf('%s IN (%s)', DbTable_Site_Content::COL_SITE_CONTENT_ID, $this->_dao->getAdapter()->quote($id));
        $params = array(
            DbTable_Site_Content::COL_FK_CONFIG_ACTIVE => intval($value)
        );

        return $this->_dao->update($params, $where);
    }

    /**
     * get by id
     *
     * @param array|int $id
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getByIdentify($identify)
    {
        $identify = trim($identify);
        return $this->_dao->getByIdentify($identify);
    }
}

?>
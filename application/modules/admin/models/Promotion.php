<?php

/**
 * Created by PhpStorm.
 * User: nhannvt
 * Date: 10/21/2015
 * Time: 6:52 PM
 */
class Admin_Model_Promotion extends Application_Singleton
{
    /**
     * @var Admin_Model_Dao_Promotion
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_Promotion();
    }

    /**
     * Generate search query
     * @param int $fkConfigComponent
     * @param string $title
     * @param int $active
     * @param string $expiredDate
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($fkConfigComponent, $title, $active, $expiredDate)
    {
        $fkConfigComponent = intval($fkConfigComponent);
        $title = ($title && $title != '') ? trim($title) : null;
        $active = intval($active);
        $expiredDate = $expiredDate ? View_Filter_Common_Date::getInstance()->filter($expiredDate) : null;
        return $this->_dao->searchQuery($fkConfigComponent, $title, $active, $expiredDate);
    }

    /**
     * Insert new promotion news
     * @param int $fkConfigComponent
     * @param string $title
     * @param string $subContent
     * @param string $content
     * @param string $image
     * @param string $expiredDate
     * @param string $imageSlider
     * @return null|string
     */

    public function insert($fkConfigComponent, $title, $subContent, $content, $image, $expiredDate, $imageSlider)
    {
        $fkConfigComponent = intval($fkConfigComponent);
        $title = trim($title);
        $subContent = trim($subContent);
        $content = trim($content);
        $image = trim($image);
        $imageSlider = trim($imageSlider);
        $expiredDate = View_Filter_Common_Date::getInstance()->filter($expiredDate);
        $createAt = $this->_dao->mysqlSysDate();
        $identify = Application_Function_String::getFormatUrl($title);
        $result = null;
        try {
            $params = array(
                DbTable_Promotion::COL_FK_CONFIG_COMPONENT => $fkConfigComponent,
                DbTable_Promotion::COL_PROMOTION_TITLE => $title,
                DbTable_Promotion::COL_PROMOTION_IDENTIFY => $identify,
                DbTable_Promotion::COL_PROMOTION_SUB_CONTENT => $subContent,
                DbTable_Promotion::COL_PROMOTION_CONTENT => $content,
                DbTable_Promotion::COL_PROMOTION_IMAGE => $image,
                DbTable_Promotion::COL_PROMOTION_IMAGE_SLIDER => $imageSlider,
                DbTable_Promotion::COL_PROMOTION_EXPIRED_DATE => $expiredDate,
                DbTable_Promotion::COL_PROMOTION_CREATED_AT => $createAt,
                DbTable_Promotion::COL_PROMOTION_UPDATED_AT => $createAt,
                DbTable_Promotion::COL_PROMOTION_ACTIVE => Application_Constant_Db_Config_Active::ACTIVE
            );
            $this->_dao->insert($params);
            Application_Cache_Default::getInstance()->resetPromotionListing($fkConfigComponent);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    /**
     * update promotion news
     * @param int $id
     * @param int $fkConfigComponent
     * @param string $title
     * @param string $subContent
     * @param string $content
     * @param string $image
     * @param string $expiredDate
     * @param string $imageSlider
     * @return null|string
     */
    public function update($id, $fkConfigComponent, $title, $subContent, $content, $image, $expiredDate, $imageSlider)
    {
        $fkConfigComponent = intval($fkConfigComponent);
        $title = trim($title);
        $subContent = trim($subContent);
        $content = trim($content);
        $image = trim($image);
        $imageSlider = trim($imageSlider);
        $expiredDate = View_Filter_Common_Date::getInstance()->filter($expiredDate);
        $result = null;
        try {
            $params = array(
                DbTable_Promotion::COL_FK_CONFIG_COMPONENT => $fkConfigComponent,
                DbTable_Promotion::COL_PROMOTION_TITLE => $title,
                DbTable_Promotion::COL_PROMOTION_SUB_CONTENT => $subContent,
                DbTable_Promotion::COL_PROMOTION_CONTENT => $content,
                DbTable_Promotion::COL_PROMOTION_IMAGE => $image,
                DbTable_Promotion::COL_PROMOTION_IMAGE_SLIDER => $imageSlider,
                DbTable_Promotion::COL_PROMOTION_EXPIRED_DATE => $expiredDate
            );
            $where = sprintf(
                '%s IN (%s)',
                DbTable_Promotion::COL_PROMOTION_ID,
                $this->_dao->getAdapter()->quote($id)
            );
            $this->_dao->update($params, $where);
            Application_Cache_Default::getInstance()->resetPromotionListing($fkConfigComponent);

        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }


    /**
     * Manual update activate by Array|Single ID
     * @param int $value
     * @param array|int $id
     * @return int
     */
    public function manualUpdateActive($value, $id)
    {
        $where = sprintf(
            '%s IN (%s)',
            DbTable_Promotion::COL_PROMOTION_ID,
            $this->_dao->getAdapter()->quote($id)
        );
        $params = array(DbTable_Promotion::COL_PROMOTION_ACTIVE => intval($value));
        $response =  $this->_dao->update($params, $where);
        if ($response) {
            Application_Cache_Default::getInstance()->resetPromotionListing(Application_Constant_Db_Config_Component::BUS);
            Application_Cache_Default::getInstance()->resetPromotionListing(Application_Constant_Db_Config_Component::PLANE);
            Application_Cache_Default::getInstance()->resetPromotionListing(Application_Constant_Db_Config_Component::HOTEL);
            if (is_array($id)) {
                foreach ($id as $item) {
                    Application_Cache_Default::getInstance()->resetPromotionDetail($item);
                }
            } else {
                Application_Cache_Default::getInstance()->resetPromotionDetail($id);
            }
        }
        return $response;
    }

    /**
     * Get by Id
     * @param array|int $id
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getById($id)
    {
        $id = intval($id);
        return $this->_dao->find($id);
    }

}
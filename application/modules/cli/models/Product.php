<?php

class Cli_Model_Product extends Application_Singleton
{

    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Cli_Model_Dao_Product();
    }

    /**
     * @param $name
     * @param $image
     * @param $content
     * @param $description
     * @param $category
     * @param $component
     * @param null $thumbImage
     * @param $referLink
     * @param $phone
     * @param $area
     * @param $price
     * @param $identify
     * @param $address
     * @return int|null|string
     */
    public function insert($name, $image, $content, $description, $category, $component, $thumbImage = null, $referLink, $phone, $area, $price, $identify, $address, $district = null, $own = null, $fkProductOwner = null, $facebookAuthorId = null, $facebookAuthorName = null)
    {
        $name = trim($name);

        $category = $category ? intval($category) : null;

        $paidPrice = intval($price);
        //$thumbNail = $thumbImage ? trim($thumbImage) : null;
        $image = $image ? $image : null;
        $description = trim($description);
        $component = intval($component);
        $shortDescription = trim($description);
        $identify = trim($identify);
        $address = trim($address);
        $area = intval($area);
        $district = $district ? intval($district) : null;
        $customerId = null;
        $result = null;
        try {
            $params = array(
                DbTable_Product::COL_PRODUCT_NAME => $name,
                DbTable_Product::COL_PRODUCT_IDENTIFY => $identify,
                DbTable_Product::COL_PRODUCT_PHONE => $phone,
                DbTable_Product::COL_PRODUCT_PAID_PRICE => $paidPrice,
                DbTable_Product::COL_PRODUCT_REFER_LINK => $referLink,
                DbTable_Product::COL_PRODUCT_THUMB_NAIL => $image,
                DbTable_Product::COL_FK_PRODUCT_COMPONENT => $component,
                DbTable_Product::COL_PRODUCT_CATEGORY_ID => $category,
                DbTable_Product::COL_PRODUCT_DESCRIPTION => $content,
                DbTable_Product::COL_PRODUCT_SHORT_DESCRIPTION => $description,
                DbTable_Product::COL_PRODUCT_NOTE => 'import group facebook',
                DbTable_Product::COL_PRODUCT_SHORT_DESCRIPTION => $shortDescription,
                DbTable_Product::COL_PRODUCT_QUALITY => 1,
                DbTable_Product::COL_PRODUCT_ADDRESS => $address,
                DbTable_Product::COL_PRODUCT_AREA => $area,
                DbTable_Product::COL_FK_PROVINCE => 79,
                DbTable_Product::COL_FK_DISTRICT => $district,
                DbTable_Product::COL_FK_CONFIG_STATUS => Application_Constant_Db_Config_Active::PENDING,
                DbTable_Product::COL_PRODUCT_FLAG_UPLOAD_IMAGE => 1,
                DbTable_Product::COL_FK_CUSTOMER => $customerId,
                DbTable_Product::COL_PRODUCT_OWN => $own,
                DbTable_Product::COL_FK_PRODUCT_OWNER => $fkProductOwner,
                DbTable_Product::COL_PRODUCT_FACEBOOK_AUTHOR_ID => $facebookAuthorId,
                DbTable_Product::COL_PRODUCT_FACEBOOK_AUTHOR_NAME => $facebookAuthorName,
                DbTable_Product::COL_PRODUCT_CREATED_AT => $this->_dao->mysqlSysDate()
            );
            $result = $this->_dao->insertAndGetLastInsertId($params);

        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    public function duplicate()
    {
        return $this->_dao->duplicate();
    }

    public function deleteById($id)
    {
        return Admin_Model_Product::getInstance()->deleteById($id);
    }

    public function getPending()
    {
        $active = Application_Constant_Db_Config_Active::PENDING;
        return $this->_dao->fetchAll(Admin_Model_Product::getInstance()->searchQuery(null, null, null, $active, -1));
    }


    public function getActive()
    {
        $active = Application_Constant_Db_Config_Active::ACTIVE;
        return $this->_dao->fetchAll(Admin_Model_Product::getInstance()->searchQuery(null, null, null, $active, -1));
    }

    public function updateLatLng($id, $lat = 0, $lng = 0)
    {


        $lng = floatval($lng);
        $lat = floatval($lat);

        $result = null;
        try {
            $params = array(

                DbTable_Product::COL_PRODUCT_LAT => $lat,
                DbTable_Product::COL_PRODUCT_LONG => $lng,

            );
            $where = sprintf('%s IN (%s)', DbTable_Product::COL_PRODUCT_ID, $this->_dao->getAdapter()->quote($id));
            $this->_dao->update($params, $where);

        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    /**
     * @param $productIdentify
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function getDetail($productIdentify)
    {
        return $this->_dao->getDetail($productIdentify);
    }

}
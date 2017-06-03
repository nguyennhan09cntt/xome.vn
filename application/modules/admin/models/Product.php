<?php

class Admin_Model_Product extends Application_Singleton
{

    /**
     *
     * @var Admin_Model_Dao_Product
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
        $this->_dao = new Admin_Model_Dao_Product ();
    }


    /**
     *
     * @param string $name
     * @param string $code
     * @param string $category
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($name, $code, $category, $active, $priority)
    {
        $name = trim($name);
        $code = trim($code);
        return $this->_dao->searchQuery($name, $code, $category, $active, $priority);
    }

    /**
     * @param $name
     * @param $referCode
     * @param $category
     * @param $originalPrice
     * @param $paidPrice
     * @param $thumbNail
     * @param $description
     * @param int $component
     * @param string $note
     * @param string $shortDescription
     * @return null|string
     */
    public function insert($name, $referCode, $category, $originalPrice, $paidPrice, $thumbNail, $description, $component, $note, $shortDescription, $promotionPrice, $address, $area, $own = null, $phone = null, $object = null, $district = null, $customerId = null, $lat = 0, $lng = 0, $flagUpload = 1, $productOwnId = null, $cookie = null)
    {
        $name = trim($name);
        $referCode = trim($referCode);
        $category = $category ? intval($category) : null;
        $originalPrice = intval($originalPrice);
        $paidPrice = intval($paidPrice);
        $thumbNail = trim($thumbNail);
        $description = trim($description);
        $component = intval($component);
        $note = trim($note);
        $shortDescription = trim($shortDescription);
        $identify = Application_Function_String::getFormatUrl($name) . '-' . Application_Function_String::randomString(6) . '-' . Application_Function_String::getFormatUrl($referCode);
        $promotionPrice = intval($promotionPrice);
        $address = trim($address);
        $area = intval($area);
        $district = $district ? intval($district) : null;
        $customerId = $customerId ? intval($customerId) : null;
        $lng = floatval($lng);
        $lat = floatval($lat);
        $flagUpload = intval($flagUpload);
        $productOwnId = $productOwnId? intval($productOwnId) : null;
        $cookie = $cookie ? trim($cookie): null;
        $result = null;
        try {
            $params = array(
                DbTable_Product::COL_PRODUCT_NAME => $name,
                DbTable_Product::COL_PRODUCT_REFER_CODE => $referCode,
                DbTable_Product::COL_PRODUCT_IDENTIFY => $identify,
                DbTable_Product::COL_PRODUCT_ORIGINAL_PRICE => $originalPrice,
                DbTable_Product::COL_PRODUCT_PROMOTION_PRICE => $promotionPrice,
                DbTable_Product::COL_PRODUCT_OWN => $own,
                DbTable_Product::COL_PRODUCT_PHONE => $phone,
                DbTable_Product::COL_PRODUCT_PAID_PRICE => $paidPrice,
                DbTable_Product::COL_PRODUCT_THUMB_NAIL => $thumbNail,
                DbTable_Product::COL_FK_PRODUCT_COMPONENT => $component,
                DbTable_Product::COL_PRODUCT_CATEGORY_ID => $category,
                DbTable_Product::COL_PRODUCT_DESCRIPTION => $description,
                DbTable_Product::COL_PRODUCT_NOTE => $note,
                DbTable_Product::COL_PRODUCT_SHORT_DESCRIPTION => $shortDescription,
                DbTable_Product::COL_PRODUCT_QUALITY => 1,
                DbTable_Product::COL_PRODUCT_ADDRESS => $address,
                DbTable_Product::COL_PRODUCT_AREA => $area,
                DbTable_Product::COL_FK_DISTRICT => $district,
                DbTable_Product::COL_PRODUCT_OBJECT => $object,
                DbTable_Product::COL_FK_CUSTOMER => $customerId,
                DbTable_Product::COL_PRODUCT_LAT => $lat,
                DbTable_Product::COL_PRODUCT_LONG => $lng,
                DbTable_Product::COL_PRODUCT_FLAG_UPLOAD_IMAGE => $flagUpload,
                DbTable_Product::COL_FK_PRODUCT_OWNER => $productOwnId,
                DbTable_Product::COL_CUSTOMER_COOKIE => $cookie,
                DbTable_Product::COL_PRODUCT_CREATED_AT => $this->_dao->mysqlSysDate()
            );
            $result = $this->_dao->insertAndGetLastInsertId($params);
            Application_Cache_Default::getInstance()->resetHomeProduct();
            //Application_Cache_Default::getInstance()->resetProductListing($component, $category);
            Application_Cache_Default::getInstance()->cleanTags(array(Application_Constant_Global::KEY_COMPONENT_PRODUCT));
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    /**
     * @param $id
     * @param $name
     * @param $referCode
     * @param $category
     * @param $originalPrice
     * @param $paidPrice
     * @param $thumbNail
     * @param $description
     * @param int $component
     * @param string $note
     * @param string $shortDescription
     * @return null|string
     */
    public function update($id, $name, $referCode, $category, $originalPrice, $paidPrice, $thumbNail, $description, $component, $note, $shortDescription, $promotionPrice, $address, $area, $own = null, $phone = null, $object = null, $district = null, $lat = 0, $lng = 0, $flagUploadImage)
    {
        $name = trim($name);
        $name = trim($name);
        $referCode = trim($referCode);
        $category = $category ? intval($category) : null;
        $originalPrice = intval($originalPrice);
        $paidPrice = intval($paidPrice);
        $thumbNail = trim($thumbNail);
        $description = trim($description);
        $component = intval($component);
        $note = trim($note);
        $shortDescription = trim($shortDescription);
        //$identify = Application_Function_String::getFormatUrl($name);
        $promotionPrice = intval($promotionPrice);
        $address = trim($address);
        $area = intval($area);

        $object = $object ? intval($object) : null;
        $district = $district ? intval($district) : null;

        $lng = floatval($lng);
        $lat = floatval($lat);

        $flagUploadImage = intval($flagUploadImage);

        $result = null;
        try {
            $params = array(
                DbTable_Product::COL_PRODUCT_NAME => $name,
                DbTable_Product::COL_PRODUCT_REFER_CODE => $referCode,
                DbTable_Product::COL_PRODUCT_ORIGINAL_PRICE => $originalPrice,
                DbTable_Product::COL_PRODUCT_PAID_PRICE => $paidPrice,
                DbTable_Product::COL_PRODUCT_THUMB_NAIL => $thumbNail,
                DbTable_Product::COL_FK_PRODUCT_COMPONENT => $component,
                DbTable_Product::COL_PRODUCT_CATEGORY_ID => $category,
                DbTable_Product::COL_PRODUCT_DESCRIPTION => $description,
                DbTable_Product::COL_PRODUCT_NOTE => $note,
                DbTable_Product::COL_PRODUCT_SHORT_DESCRIPTION => $shortDescription,
                //DbTable_Product::COL_PRODUCT_IDENTIFY => $identify,
                DbTable_Product::COL_PRODUCT_PROMOTION_PRICE => $promotionPrice,
                DbTable_Product::COL_PRODUCT_ADDRESS => $address,
                DbTable_Product::COL_PRODUCT_QUALITY => 1,
                DbTable_Product::COL_PRODUCT_AREA => $area,
                DbTable_Product::COL_PRODUCT_OWN => $own,
                DbTable_Product::COL_PRODUCT_PHONE => $phone,
                DbTable_Product::COL_FK_DISTRICT => $district,
                DbTable_Product::COL_PRODUCT_OBJECT => $object,
                DbTable_Product::COL_PRODUCT_LAT => $lat,
                DbTable_Product::COL_PRODUCT_LONG => $lng,
                DbTable_Product::COL_PRODUCT_FLAG_UPLOAD_IMAGE => $flagUploadImage

            );
            $where = sprintf('%s IN (%s)', DbTable_Product::COL_PRODUCT_ID, $this->_dao->getAdapter()->quote($id));
            $this->_dao->update($params, $where);
            Application_Cache_Default::getInstance()->resetHomeProduct();
            //Application_Cache_Default::getInstance()->resetProductListing($component, $category);
            Application_Cache_Default::getInstance()->cleanTags(array(Application_Constant_Global::KEY_COMPONENT_PRODUCT));
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    /**
     * delete product by id
     * @param int|array $id
     * @return int
     */
    public function deleteById($id)
    {
        $id = is_array($id) ? $id : intval($id);
        Application_Cache_Default::getInstance()->resetHomeProduct();
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
            DbTable_Product::COL_PRODUCT_ID,
            $this->_dao->getAdapter()->quote($id)
        );
        $params = array(DbTable_Product::COL_FK_CONFIG_STATUS => intval($value));
        Application_Cache_Default::getInstance()->resetHomeProduct();
        Application_Cache_Default::getInstance()->cleanTags(array(Application_Constant_Global::KEY_COMPONENT_PRODUCT));
        return $this->_dao->update($params, $where);
    }

    /**
     * Manual update active by Array|Single ID
     * @param int $value
     * @param array|int $id
     * @return int
     */
    public function manualUpdatePriority($value, $id)
    {
        $where = sprintf(
            '%s IN (%s)',
            DbTable_Product::COL_PRODUCT_ID,
            $this->_dao->getAdapter()->quote($id)
        );
        $params = array(DbTable_Product::COL_PRODUCT_PRIORITY => intval($value));
        Application_Cache_Default::getInstance()->resetHomeProduct();
        Application_Cache_Default::getInstance()->cleanTags(array(Application_Constant_Global::KEY_COMPONENT_PRODUCT));
        return $this->_dao->update($params, $where);
    }

    /**
     * @param $id
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function searchCustomerByProductId($id)
    {
        $id = is_array($id) ? $id : intval($id);
        return $this->_dao->searchCustomerByProductId($id);
    }

    public function generateUrl($id)
    {
        echo $id;
        $dataInfo = $this->getById($id);
        $dataInfo = $dataInfo ? $dataInfo->current() : null;

        $districtID = $dataInfo->{DbTable_Product::COL_FK_DISTRICT};
        $districtCategory = '';
        $data = Model_ProductCategory::getInstance()->getAll();
        $categoryId = $dataInfo->{DbTable_Product::COL_PRODUCT_CATEGORY_ID};
        $categoryIdentify = isset($data[$categoryId]) ? $data[$categoryId][DbTable_Product_Category::COL_PRODUCT_CATEGORY_IDENTIFY] : null;
        $data = Model_District::getInstance()->getAll();
        if (isset($data[$districtID])) {
            $type = $data[$districtID][DbTable_District::COL_DISTRICT_TYPE] == 'Quận' ? 'quan' : 'huyen';
            $districtCategory = $type . '-' . $data[$districtID][DbTable_District::COL_DISTRICT_IDENTIFY];
        }
        $url = 'http://xome.vn/' . $categoryIdentify . '/ho-chi-minh/' . $districtCategory . '/' . $dataInfo->{DbTable_Product::COL_PRODUCT_IDENTIFY} . '-' . $this->encode($id);
        return $url;
    }

}

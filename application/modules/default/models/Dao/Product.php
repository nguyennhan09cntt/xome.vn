<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/19/2016
 * Time: 1:54 PM
 */
class Model_Dao_Product extends DbTable_Product
{
    /**
     * get product listing
     * @param int $page
     * @param int $limit
     * @param int $componentId
     * @param int $categoryId
     * @return array
     */
    public function getListing($page, $limit, $componentId, $categoryId)
    {
        $select = $this->select()->setIntegrityCheck(false)
            ->from(
                DbTable_Product::_tableName,
                array(
                    new Zend_Db_Expr('SQL_CALC_FOUND_ROWS product.' . DbTable_Product::COL_PRODUCT_ID),
                    DbTable_Product::COL_PRODUCT_NAME,
                    DbTable_Product::COL_PRODUCT_IDENTIFY,
                    DbTable_Product::COL_FK_PRODUCT_COMPONENT,
                    DbTable_Product::COL_PRODUCT_CATEGORY_ID,
                    DbTable_Product::COL_PRODUCT_THUMB_NAIL,
                    DbTable_Product::COL_PRODUCT_DESCRIPTION,
                    DbTable_Product::COL_PRODUCT_REFER_CODE,
                    DbTable_Product::COL_PRODUCT_ORIGINAL_PRICE,
                    DbTable_Product::COL_PRODUCT_PAID_PRICE,
                    DbTable_Product::COL_FK_PRODUCT_COMPONENT,
                    DbTable_Product::COL_PRODUCT_SHORT_DESCRIPTION,
                    DbTable_Product::COL_PRODUCT_PROMOTION_PRICE,
                    DbTable_Product::COL_PRODUCT_ADDRESS,
                    DbTable_Product::COL_PRODUCT_AREA,
                    DbTable_Product::COL_PRODUCT_PHONE,
                    DbTable_Product::COL_PRODUCT_CREATED_AT,
                    DbTable_Product::COL_PRODUCT_REFER_LINK,
                    DbTable_Product::COL_FK_DISTRICT,
                    DbTable_Product::COL_FK_PRODUCT_OWNER,
                    DbTable_Product::COL_PRODUCT_FLAG_UPLOAD_IMAGE,
                    DbTable_Product::COL_PRODUCT_PAGEVIEW
                )
            )
            ->joinLeft(
                DbTable_Product_Own::_tableName,
                sprintf(
                    '%s.%s = %s.%s',
                    DbTable_Product_Own::_tableName,
                    DbTable_Product_Own::COL_PRODUCT_OWN_ID,
                    DbTable_Product::_tableName,
                    DbTable_Product::COL_FK_PRODUCT_OWNER
                ),
                array(
                    DbTable_Product_Own::COL_PRODUCT_OWN_NAME,
                    DbTable_Product_Own::COL_PRODUCT_OWN_PHONE,
                    DbTable_Product_Own::COL_PRODUCT_OWN_FACEBOOK_ID,
                )
            )
            ->where(DbTable_Product::COL_FK_CONFIG_STATUS . '=?', Application_Constant_Db_Config_Active::ACTIVE)
            ->order(DbTable_Product::COL_PRODUCT_PRIORITY . ' desc')
            ->order(DbTable_Product::COL_PRODUCT_ID . ' desc')
            ->limitPage($page, $limit);
        if ($componentId) {
            $select->where(sprintf(
                    '%s.%s = %d',
                    DbTable_Product::_tableName,
                    DbTable_Product::COL_FK_PRODUCT_COMPONENT,
                    $componentId

                )
            );
        }
        if ($categoryId) {
            $select->where(
                sprintf(
                    '%s.%s = %d',
                    DbTable_Product::_tableName,
                    DbTable_Product::COL_PRODUCT_CATEGORY_ID,
                    $categoryId
                )
            );
        }
        $select->group(DbTable_Product::COL_PRODUCT_ID);
        return array(
            Application_Constant_Global::KEY_DATA => $this->fetchAll($select),
            Application_Constant_Global::KEY_TOTAL => $this->fetchOne($this->queryTotalRow())
        );
    }


    /**
     * get detail
     * @param string $productIdentify
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function getDetail($productIdentify)
    {
        $select = $this->select()->setIntegrityCheck(false)
            ->from(
                DbTable_Product::_tableName,
                array(
                    DbTable_Product::COL_PRODUCT_ID,
                    DbTable_Product::COL_PRODUCT_NAME,
                    DbTable_Product::COL_PRODUCT_IDENTIFY,
                    DbTable_Product::COL_FK_PRODUCT_COMPONENT,
                    DbTable_Product::COL_PRODUCT_CATEGORY_ID,
                    DbTable_Product::COL_PRODUCT_THUMB_NAIL,
                    DbTable_Product::COL_PRODUCT_SHORT_DESCRIPTION,
                    DbTable_Product::COL_PRODUCT_ADDITION_INFO,
                    DbTable_Product::COL_FK_PRODUCT_OWNER,
                    DbTable_Product::COL_PRODUCT_DESCRIPTION,
                    DbTable_Product::COL_PRODUCT_REFER_CODE,
                    DbTable_Product::COL_PRODUCT_PAID_PRICE,
                    DbTable_Product::COL_PRODUCT_PROMOTION_PRICE,
                    DbTable_Product::COL_PRODUCT_REFER_LINK,
                    DbTable_Product::COL_PRODUCT_QUALITY,
                    DbTable_Product::COL_PRODUCT_ADDRESS,
                    DbTable_Product::COL_PRODUCT_AREA,
                    DbTable_Product::COL_PRODUCT_PHONE,
                    DbTable_Product::COL_PRODUCT_CREATED_AT,
                    DbTable_Product::COL_FK_DISTRICT,
                    DbTable_Product::COL_FK_CONFIG_STATUS,
                    DbTable_Product::COL_PRODUCT_OBJECT,
                    DbTable_Product::COL_PRODUCT_LONG,
                    DbTable_Product::COL_PRODUCT_LAT,
                    DbTable_Product::COL_PRODUCT_OWN,
                    DbTable_Product::COL_PRODUCT_FLAG_UPLOAD_IMAGE,
                    DbTable_Product::COL_PRODUCT_PAGEVIEW,
                    'product_facility' => new Zend_Db_Expr(
                        sprintf(
                            'GROUP_CONCAT(%s SEPARATOR ", ")',
                            DbTable_Product_Facility::COL_FACILITY_ID
                        )
                    )
                )
            )
            ->joinLeft(
                DbTable_Product_Facility::_tableName,
                sprintf(
                    '%s.%s = %s.%s',
                    DbTable_Product_Facility::_tableName,
                    DbTable_Product_Facility::COL_PRODUCT_ID,
                    DbTable_Product::_tableName,
                    DbTable_Product::COL_PRODUCT_ID
                ),
                array(
                    DbTable_Product_Facility::COL_FACILITY_ID
                )
            )
            ->where(
                sprintf(
                    'CONCAT(%s.%s,"-LN3",HEX(%s.%s+5050)) = %s',
                    DbTable_Product::_tableName,
                    DbTable_Product::COL_PRODUCT_IDENTIFY,
                    DbTable_Product::_tableName,
                    DbTable_Product::COL_PRODUCT_ID,
                    $this->getAdapter()->quote($productIdentify)
                )
            )
            ->where(
                sprintf(
                    '%s IN(%d, %d, %d, %d)',
                    DbTable_Product::COL_FK_CONFIG_STATUS,
                    Application_Constant_Db_Config_Active::ACTIVE,
                    Application_Constant_Db_Config_Active::INACTIVE,
                    Application_Constant_Db_Config_Active::APPROVED,
                    Application_Constant_Db_Config_Active::PENDING
                )
            );
        $select->group(DbTable_Product::COL_PRODUCT_ID);
        return $this->fetchRow($select);

    }

    /**
     * @param $page
     * @param $limit
     * @param $keyWord
     * @param $categoryId
     * @param $facility
     * @param $priceBegin
     * @param $priceEnd
     * @param $province
     * @param $district
     * @param $object
     * @param int $beginArea
     * @param int $endArea
     * @param bool $flagMap
     * @return array
     */
    public function searchQuery($page, $limit, $keyWord, $categoryId, $facility, $priceBegin, $priceEnd, $province, $district, $object, $beginArea = 0, $endArea = 0, $flagMap = false, $lat = null, $lng=null)
    {
		
        $select = $this->select()->setIntegrityCheck(false)
            ->from(
                DbTable_Product::_tableName,
                array(
                    new Zend_Db_Expr('SQL_CALC_FOUND_ROWS product.' . DbTable_Product::COL_PRODUCT_ID),
                    DbTable_Product::COL_PRODUCT_NAME,
                    DbTable_Product::COL_FK_PRODUCT_COMPONENT,
                    DbTable_Product::COL_PRODUCT_IDENTIFY,
                    DbTable_Product::COL_PRODUCT_CATEGORY_ID,
                    DbTable_Product::COL_PRODUCT_THUMB_NAIL,
                    DbTable_Product::COL_PRODUCT_SHORT_DESCRIPTION,
                    DbTable_Product::COL_PRODUCT_DESCRIPTION,
                    DbTable_Product::COL_PRODUCT_REFER_CODE,
                    DbTable_Product::COL_PRODUCT_PAID_PRICE,
                    DbTable_Product::COL_PRODUCT_PROMOTION_PRICE,
                    DbTable_Product::COL_PRODUCT_ADDRESS,
                    DbTable_Product::COL_PRODUCT_AREA,
                    DbTable_Product::COL_PRODUCT_CREATED_AT,
                    DbTable_Product::COL_FK_DISTRICT,
                    DbTable_Product::COL_PRODUCT_LAT,
                    DbTable_Product::COL_PRODUCT_LONG,
                    DbTable_Product::COL_PRODUCT_PHONE,
                    DbTable_Product::COL_PRODUCT_REFER_LINK,
                    DbTable_Product::COL_FK_PRODUCT_OWNER,
                    DbTable_Product::COL_PRODUCT_FLAG_UPLOAD_IMAGE					
                )
            );
			if ($lat &&  $lng){
				 $select = $this->select()->setIntegrityCheck(false)
					->from(
						DbTable_Product::_tableName,
						array(
							new Zend_Db_Expr('SQL_CALC_FOUND_ROWS product.' . DbTable_Product::COL_PRODUCT_ID),
							DbTable_Product::COL_PRODUCT_NAME,
							DbTable_Product::COL_FK_PRODUCT_COMPONENT,
							DbTable_Product::COL_PRODUCT_IDENTIFY,
							DbTable_Product::COL_PRODUCT_CATEGORY_ID,
							DbTable_Product::COL_PRODUCT_THUMB_NAIL,
							DbTable_Product::COL_PRODUCT_SHORT_DESCRIPTION,
							DbTable_Product::COL_PRODUCT_DESCRIPTION,
							DbTable_Product::COL_PRODUCT_REFER_CODE,
							DbTable_Product::COL_PRODUCT_PAID_PRICE,
							DbTable_Product::COL_PRODUCT_PROMOTION_PRICE,
							DbTable_Product::COL_PRODUCT_ADDRESS,
							DbTable_Product::COL_PRODUCT_AREA,
							DbTable_Product::COL_PRODUCT_CREATED_AT,
							DbTable_Product::COL_FK_DISTRICT,
							DbTable_Product::COL_PRODUCT_LAT,
							DbTable_Product::COL_PRODUCT_LONG,
							DbTable_Product::COL_PRODUCT_PHONE,
							DbTable_Product::COL_PRODUCT_REFER_LINK,
							DbTable_Product::COL_FK_PRODUCT_OWNER,
							DbTable_Product::COL_PRODUCT_FLAG_UPLOAD_IMAGE,
							'distance' => new Zend_Db_Expr(
									'3959 * acos (
									cos ( radians(' . $lat . ') )
									* cos( radians( product_lat ) )
									* cos( radians( product_long ) - radians(' . $lng . ') )
									+ sin ( radians(' . $lat . ') )
									* sin( radians( product_lat ) )
									)'
							)
						)
					);
			}
			
            $select->where(DbTable_Product::COL_FK_CONFIG_STATUS . '=?', Application_Constant_Db_Config_Active::ACTIVE)
            ->where(DbTable_Product::COL_PRODUCT_PAID_PRICE . '>=?', $priceBegin)
            ->where(DbTable_Product::COL_PRODUCT_PAID_PRICE . '<=?', $priceEnd)
            ->order(DbTable_Product::COL_PRODUCT_ID . ' desc')
            ->limitPage($page, $limit);
        if ($facility) {
            $select->joinLeft(
                DbTable_Product_Facility::_tableName,
                sprintf(
                    '%s.%s = %s.%s',
                    DbTable_Product_Facility::_tableName,
                    DbTable_Product_Facility::COL_PRODUCT_ID,
                    DbTable_Product::_tableName,
                    DbTable_Product::COL_PRODUCT_ID
                ),
                array(
                    DbTable_Product_Facility::COL_FACILITY_ID
                )
            );
            $select->where(DbTable_Product_Facility::COL_FACILITY_ID . '=?', $facility);
        }

        if ($object) {
            $select->where(DbTable_Product::COL_PRODUCT_OBJECT . '=?', $object);
        }
		if ($lat && $lng) {
			 $select->having('distance' . '<?', 0.5);
		}else{
			if ($keyWord) {
            $select->where(
                sprintf(
                    '%s like %s ||  %s  like %s || %s like %s',
                    new Zend_Db_Expr (
                        'LOWER(product.' . DbTable_Product::COL_PRODUCT_NAME . ')'),
                    $this->getAdapter()->quote('%' . strtolower($keyWord) . '%'),
                    new Zend_Db_Expr (
                        'LOWER(CONCAT("LN3",HEX(product.' . DbTable_Product::COL_PRODUCT_ID . '+5050)))'),
                    $this->getAdapter()->quote('%' . strtolower($keyWord) . '%'),
					new Zend_Db_Expr (
                        'LOWER(product.' . DbTable_Product::COL_PRODUCT_ADDRESS . ')'),
                    $this->getAdapter()->quote('%' . strtolower($keyWord) . '%')
                )
            );
        }
		}
       

        if ($categoryId) {
            $select->where(
                sprintf(
                    '%s.%s = %d',
                    DbTable_Product::_tableName,
                    DbTable_Product::COL_PRODUCT_CATEGORY_ID,
                    $categoryId
                )
            );
        }
        if ($province) {
            $select->where(DbTable_Product::COL_FK_PROVINCE . '=?', $province);
        }

        if ($district) {
            $select->where(sprintf(
                    '%s IN (%s)',
                    DbTable_Product::COL_FK_DISTRICT,
                    $this->getAdapter()->quote($district)
                )
            );
        }

        if ($beginArea > 0) {
            $select->where(DbTable_Product::COL_PRODUCT_AREA . '>=?', $beginArea);
        }

        if ($endArea > 0) {
            $select->where(DbTable_Product::COL_PRODUCT_AREA . '<=?', $endArea);
        }

        if ($flagMap) {
            $select->where(DbTable_Product::COL_PRODUCT_LAT . '>?', 0);
            $select->where(DbTable_Product::COL_PRODUCT_LONG . '>?', 0);
        }
        //var_dump($select->assemble());
        return array(
            Application_Constant_Global::KEY_DATA => $this->fetchAll($select),
            Application_Constant_Global::KEY_TOTAL => $this->fetchOne($this->queryTotalRow())
        );
    }

    /**
     * @param $page
     * @param $limit
     * @param $provinceId
     * @param $districtId
     * @return array
     */
    public function getListingByProvince($page, $limit, $provinceId, $districtId)
    {

        $select = $this->select()->setIntegrityCheck(false)
            ->from(
                DbTable_Product::_tableName,
                array(
                    new Zend_Db_Expr('SQL_CALC_FOUND_ROWS product.' . DbTable_Product::COL_PRODUCT_ID),
                    DbTable_Product::COL_PRODUCT_NAME,
                    DbTable_Product::COL_PRODUCT_IDENTIFY,
                    DbTable_Product::COL_FK_PRODUCT_COMPONENT,
                    DbTable_Product::COL_PRODUCT_CATEGORY_ID,
                    DbTable_Product::COL_PRODUCT_THUMB_NAIL,
                    DbTable_Product::COL_PRODUCT_DESCRIPTION,
                    DbTable_Product::COL_PRODUCT_REFER_CODE,
                    DbTable_Product::COL_PRODUCT_ORIGINAL_PRICE,
                    DbTable_Product::COL_PRODUCT_PAID_PRICE,
                    DbTable_Product::COL_FK_PRODUCT_COMPONENT,
                    DbTable_Product::COL_PRODUCT_SHORT_DESCRIPTION,
                    DbTable_Product::COL_PRODUCT_PROMOTION_PRICE,
                    DbTable_Product::COL_PRODUCT_ADDRESS,
                    DbTable_Product::COL_PRODUCT_AREA,
                    DbTable_Product::COL_PRODUCT_PHONE,
                    DbTable_Product::COL_PRODUCT_CREATED_AT,
                    DbTable_Product::COL_PRODUCT_REFER_LINK,
                    DbTable_Product::COL_FK_DISTRICT,
                    DbTable_Product::COL_FK_PRODUCT_OWNER,
                    DbTable_Product::COL_PRODUCT_FLAG_UPLOAD_IMAGE
                )
            )
            ->where(DbTable_Product::COL_FK_CONFIG_STATUS . '=?', Application_Constant_Db_Config_Active::ACTIVE)
            ->order(DbTable_Product::COL_PRODUCT_PRIORITY . ' desc')
            ->order(DbTable_Product::COL_PRODUCT_ID . ' desc')
            ->limitPage($page, $limit);
        if ($provinceId) {
            $select->where(sprintf(
                    '%s.%s = %d',
                    DbTable_Product::_tableName,
                    DbTable_Product::COL_FK_PROVINCE,
                    $provinceId

                )
            );
        }
        if ($districtId) {
            $select->where(sprintf(
                    '%s IN (%s)',
                    DbTable_Product::COL_FK_DISTRICT,
                    $this->getAdapter()->quote($districtId)
                )
            );
        }

        return array(
            Application_Constant_Global::KEY_DATA => $this->fetchAll($select),
            Application_Constant_Global::KEY_TOTAL => $this->fetchOne($this->queryTotalRow())
        );

    }

    public function getProductByCustomer($page, $limit, $customerId)
    {
        $select = $this->select()->setIntegrityCheck(false)
            ->from(
                DbTable_Product::_tableName,
                array(
                    new Zend_Db_Expr('SQL_CALC_FOUND_ROWS product.' . DbTable_Product::COL_PRODUCT_ID),
                    DbTable_Product::COL_PRODUCT_NAME,
                    DbTable_Product::COL_FK_PRODUCT_COMPONENT,
                    DbTable_Product::COL_PRODUCT_IDENTIFY,
                    DbTable_Product::COL_PRODUCT_CATEGORY_ID,
                    DbTable_Product::COL_PRODUCT_THUMB_NAIL,
                    DbTable_Product::COL_PRODUCT_SHORT_DESCRIPTION,
                    DbTable_Product::COL_PRODUCT_ADDRESS,
                    DbTable_Product::COL_PRODUCT_AREA,
                    DbTable_Product::COL_PRODUCT_CREATED_AT,
                    DbTable_Product::COL_PRODUCT_UPDATED_AT,
                    DbTable_Product::COL_FK_DISTRICT,
                    DbTable_Product::COL_FK_CONFIG_STATUS,
                    DbTable_Product::COL_PRODUCT_REFER_LINK,
                    DbTable_Product::COL_FK_PRODUCT_OWNER,
                    DbTable_Product::COL_PRODUCT_FLAG_UPLOAD_IMAGE

                )
            )
            ->where(DbTable_Product::COL_FK_CUSTOMER . '=?', $customerId)
            ->where(DbTable_Product::COL_FK_CONFIG_STATUS . '!=?', Application_Constant_Db_Config_Active::DELETED)
            ->order(DbTable_Product::COL_PRODUCT_ID . ' desc')
            ->limitPage($page, $limit);

        return array(
            Application_Constant_Global::KEY_DATA => $this->fetchAll($select),
            Application_Constant_Global::KEY_TOTAL => $this->fetchOne($this->queryTotalRow())
        );
    }

    public function getProductByOwner($page, $limit, $ownerId)
    {
        $select = $this->select()->setIntegrityCheck(false)
            ->from(
                DbTable_Product::_tableName,
                array(
                    new Zend_Db_Expr('SQL_CALC_FOUND_ROWS product.' . DbTable_Product::COL_PRODUCT_ID),
                    DbTable_Product::COL_PRODUCT_NAME,
                    DbTable_Product::COL_FK_PRODUCT_COMPONENT,
                    DbTable_Product::COL_PRODUCT_IDENTIFY,
                    DbTable_Product::COL_PRODUCT_CATEGORY_ID,
                    DbTable_Product::COL_PRODUCT_THUMB_NAIL,
                    DbTable_Product::COL_PRODUCT_SHORT_DESCRIPTION,
                    DbTable_Product::COL_PRODUCT_ADDRESS,
                    DbTable_Product::COL_PRODUCT_AREA,
                    DbTable_Product::COL_PRODUCT_CREATED_AT,
                    DbTable_Product::COL_PRODUCT_UPDATED_AT,
                    DbTable_Product::COL_FK_DISTRICT,
                    DbTable_Product::COL_FK_CONFIG_STATUS,
                    DbTable_Product::COL_PRODUCT_REFER_LINK,
                    DbTable_Product::COL_FK_PRODUCT_OWNER,
                    DbTable_Product::COL_PRODUCT_FLAG_UPLOAD_IMAGE

                )
            )
            ->where(DbTable_Product::COL_FK_PRODUCT_OWNER . '=?', $ownerId)
            ->where(DbTable_Product::COL_FK_CONFIG_STATUS . '!=?', Application_Constant_Db_Config_Active::DELETED)
            ->order(DbTable_Product::COL_PRODUCT_ID . ' desc')
            ->limitPage($page, $limit);

        return array(
            Application_Constant_Global::KEY_DATA => $this->fetchAll($select),
            Application_Constant_Global::KEY_TOTAL => $this->fetchOne($this->queryTotalRow())
        );
    }

    /**
     * @param $lat
     * @param $lng
     * @param $radius
     * @param $limit
     * @return array
     */
    public function searchAround($lat, $lng, $radius, $limit)
    {
        $select = $this->select()->from(
            DbTable_Product::_tableName,
            array(
                new Zend_Db_Expr('SQL_CALC_FOUND_ROWS product.' . DbTable_Product::COL_PRODUCT_ID),
                DbTable_Product::COL_PRODUCT_NAME,
                DbTable_Product::COL_FK_PRODUCT_COMPONENT,
                DbTable_Product::COL_PRODUCT_IDENTIFY,
                DbTable_Product::COL_PRODUCT_CATEGORY_ID,
                DbTable_Product::COL_PRODUCT_THUMB_NAIL,
                DbTable_Product::COL_PRODUCT_SHORT_DESCRIPTION,
                DbTable_Product::COL_PRODUCT_DESCRIPTION,
                DbTable_Product::COL_PRODUCT_REFER_CODE,
                DbTable_Product::COL_PRODUCT_PAID_PRICE,
                DbTable_Product::COL_PRODUCT_PROMOTION_PRICE,
                DbTable_Product::COL_PRODUCT_ADDRESS,
                DbTable_Product::COL_PRODUCT_AREA,
                DbTable_Product::COL_PRODUCT_CREATED_AT,
                DbTable_Product::COL_FK_DISTRICT,
                DbTable_Product::COL_PRODUCT_LAT,
                DbTable_Product::COL_PRODUCT_LONG,
                DbTable_Product::COL_PRODUCT_PHONE,
                DbTable_Product::COL_PRODUCT_REFER_LINK,
                DbTable_Product::COL_FK_PRODUCT_OWNER,
                DbTable_Product::COL_PRODUCT_FLAG_UPLOAD_IMAGE,
                'distance' => new Zend_Db_Expr(
                    '3959 * acos (
                    cos ( radians(' . $lat . ') )
                    * cos( radians( product_lat ) )
                    * cos( radians( product_long ) - radians(' . $lng . ') )
                    + sin ( radians(' . $lat . ') )
                    * sin( radians( product_lat ) )
                    )'
                ),
            )
        )
            ->where(DbTable_Product::COL_FK_CONFIG_STATUS . '=?', Application_Constant_Db_Config_Active::ACTIVE)
            ->having('distance' . '<?', $radius)
            ->having('distance' . '>?', 0.1)
            ->order('distance')
            ->limit($limit);

        return array(
            Application_Constant_Global::KEY_DATA => $this->fetchAll($select),
            Application_Constant_Global::KEY_TOTAL => $this->fetchOne($this->queryTotalRow())
        );
    }
}
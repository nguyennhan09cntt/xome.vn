<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 8/9/2016
 * Time: 7:58 AM
 */
class Admin_Model_ProductFacility extends Application_Singleton
{

    /**
     *
     * @var Admin_Model_Dao_ProductFacility
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_ProductFacility ();
    }

    /**
     * Get facility  by product id
     * @param int $productId
     * @return array
     */
    public function searchByProductId($productId)
    {
        $result = array();

        if (!$result) {
            $facilityData = $this->_dao->searchByProductId(intval($productId));
            $result = $facilityData ? $facilityData->toArray() : array();
        }
        return $result;
    }

    /**
     * @param $facility
     * @param $product
     * @return null|string
     */
    public function insert($facility, $product)
    {
        $facility = intval($facility);
        $product = intval($product);
        $result = null;
        try {
            $params = array(
                DbTable_Product_Facility::COL_FACILITY_ID => $facility,
                DbTable_Product_Facility::COL_PRODUCT_ID => $product,
            );
            $this->_dao->insert($params);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    /**
     * Delete facility by product id
     * @param int $productId
     * @return int
     */
    public function deleteByProductId($productId)
    {
        $productId = intval($productId);
        return $this->_dao->deleteByProductId($productId);
    }




}
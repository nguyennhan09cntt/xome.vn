<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/19/2016
 * Time: 1:31 PM
 */
class Model_ProductCategory extends Application_Singleton
{


    protected function __construct()
    {

    }

    /**
     * get all
     * @return array|false|mixed
     */
    public function getAll()
    {
        return Admin_Model_ProductCategory::getInstance()->getAll();
    }

    /**
     * get category by identify
     * @param $identify
     * @return mixed|null
     */
    public function getByIdentify($identify){
        $identify = trim($identify);
        $data = $this->getAll();
        $result = null;
        foreach ($data as $productCategory){
            if($productCategory[DbTable_Product_Category::COL_PRODUCT_CATEGORY_IDENTIFY] == $identify){
                $result = $productCategory;
                break;
            }
        }
        return $result;
    }

    public function getDisplayHome(){
        $data = $this->getAll();
        $result = null;
        foreach ($data as $productCategory){
            if($productCategory[DbTable_Product_Category::COL_PRODUCT_CATEGORY_DISPLAY_HOME] == 1){
                $result[$productCategory[DbTable_Product_Category::COL_PRODUCT_CATEGORY_ID]] = $productCategory;
            }
        }
        return $result;
    }
}
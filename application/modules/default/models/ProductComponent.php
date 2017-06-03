<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 4/25/2016
 * Time: 12:49 PM
 */
class Model_ProductComponent extends Application_Singleton
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
        return Admin_Model_ProductComponent::getInstance()->getAll();
    }

    /**
     * get component by identify
     * @param $identify
     * @return mixed|null
     */
    public function getByIdentify($identify){
        $identify = trim($identify);
        $data = $this->getAll();
        $result = null;
        foreach ($data as $productComponent){
            if($productComponent[DbTable_Product_Component::COL_PRODUCT_COMPONENT_IDENTIFY] == $identify){
                $result = $productComponent;
                break;
            }
        }
        return $result;
    }

}
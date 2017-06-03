<?php
/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 4/23/2016
 * Time: 11:38 AM
 */

class View_Helper_ProductComponentIdentify extends Zend_View_Helper_Abstract
{
    public function productComponentIdentify($id)
    {
        $data = Model_ProductComponent::getInstance()->getAll();
        return isset($data[$id]) ? $data[$id][DbTable_Product_Component::COL_PRODUCT_COMPONENT_IDENTIFY] : null;
    }
}
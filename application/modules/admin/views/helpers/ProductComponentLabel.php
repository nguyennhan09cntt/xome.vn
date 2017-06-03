<?php
/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 4/23/2016
 * Time: 12:19 AM
 */

class Admin_View_Helper_ProductComponentLabel extends Zend_View_Helper_Abstract
{
    public function productComponentLabel($id)
    {
        $data = Admin_Model_ProductComponent::getInstance()->getAll();
        return isset($data[$id]) ? $data[$id][DbTable_Product_Component::COL_PRODUCT_COMPONENT_NAME] : null;
    }
}

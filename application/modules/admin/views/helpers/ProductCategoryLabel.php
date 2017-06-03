<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/19/2016
 * Time: 12:15 PM
 */
class Admin_View_Helper_ProductCategoryLabel extends Zend_View_Helper_Abstract
{
    public function productCategoryLabel($id)
    {
        $data = Admin_Model_ProductCategory::getInstance()->getAll();
        return isset($data[$id]) ? $data[$id][DbTable_Product_Category::COL_PRODUCT_CATEGORY_NAME] : null;
    }
}

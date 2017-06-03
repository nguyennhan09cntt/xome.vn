<?php
/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 4/23/2016
 * Time: 11:38 AM
 */

class View_Helper_ProductCategoryLabel extends Zend_View_Helper_Abstract
{
    public function productCategoryLabel($id)
    {
        $data = Model_ProductCategory::getInstance()->getAll();
        return isset($data[$id]) ? $data[$id][DbTable_Product_Category::COL_PRODUCT_CATEGORY_NAME] : null;
    }
}
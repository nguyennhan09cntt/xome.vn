<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/19/2016
 * Time: 11:35 AM
 */
class Admin_View_Helper_BlogCategoryLabel extends Zend_View_Helper_Abstract
{
    public function blogCategoryLabel($id)
    {
        $data = Admin_Model_BlogCategory::getInstance()->getAll();
        return isset($data[$id]) ? $data[$id][DbTable_Blog_Category::COL_BLOG_CATEGORY_NAME] : null;
    }
}
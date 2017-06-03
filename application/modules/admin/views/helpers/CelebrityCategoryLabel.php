<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/19/2016
 * Time: 12:15 PM
 */
class Admin_View_Helper_CelebrityCategoryLabel extends Zend_View_Helper_Abstract
{
    public function celebrityCategoryLabel($id)
    {
        $data = Admin_Model_CelebrityCategory::getInstance()->getAll();
        return isset($data[$id]) ? $data[$id][DbTable_Celebrity_Category::COL_CELEBRITY_CATEGORY_NAME] : null;
    }
}

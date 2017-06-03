<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 4/23/2016
 * Time: 1:48 PM
 */
class Model_BlogCategory extends Application_Singleton
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
        return Admin_Model_BlogCategory::getInstance()->getAll();
    }

    /**
     * @param string $identify
     * @return null
     */
    public function getByIdentify($identify){
        $identify = trim($identify);
        $data = $this->getAll();
        $result = null;
        foreach ($data as $category){
            if($category[DbTable_Blog_Category::COL_BLOG_CATEGORY_IDENTIFY] == $identify){
                $result = $category;
                break;
            }
        }
        return $result;
    }
}
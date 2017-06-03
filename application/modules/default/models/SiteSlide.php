<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/19/2016
 * Time: 1:38 PM
 */
class Model_SiteSlide extends Application_Singleton
{


    protected function __construct()
    {

    }

    /**
     * get all
     * @return array|false|mixed
     */
    public function getAll(){
        return Admin_Model_SiteSlide::getInstance()->getAll();
    }

}
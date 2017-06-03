<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 6/12/2016
 * Time: 10:32 AM
 */
class Model_Province extends Application_Singleton
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
        return Admin_Model_Province::getInstance()->getAll();
    }
}
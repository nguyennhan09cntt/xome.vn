<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/21/2016
 * Time: 3:59 PM
 */
class Model_District extends Application_Singleton
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
        return Admin_Model_District::getInstance()->getAll();
    }

    public function getByIdentify($districtIdentify)
    {

        return Admin_Model_District::getInstance()->getByIdentify($districtIdentify);
    }
}
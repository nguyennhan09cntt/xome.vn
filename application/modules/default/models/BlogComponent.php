<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 4/23/2016
 * Time: 11:41 AM
 */
class Model_BlogComponent extends Application_Singleton
{
    protected function __construct()
    {

    }

    /**
     * get all
     * @return array|false|mixed
     */
    public function getAll(){
        return Admin_Model_BlogComponent::getInstance()->getAll();
    }
}
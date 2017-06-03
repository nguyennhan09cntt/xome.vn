<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 12/18/2016
 * Time: 9:13 PM
 */
class Cli_Model_ProductImage extends Application_Singleton
{
    protected function __construct()
    {

    }

    /*
     * Delete by product id
     */
    public function deleteByProductId($id)
    {
        return Admin_Model_ProductImage::getInstance()->deleteByProductId($id);
    }
}
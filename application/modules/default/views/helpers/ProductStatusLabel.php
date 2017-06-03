<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/21/2016
 * Time: 10:11 PM
 */
class View_Helper_ProductStatusLabel extends Zend_View_Helper_Abstract
{
    public function productStatusLabel($status)
    {
        $data = array(
            0 => 'Đã thuê',
            1 => 'Còn trống',
            Application_Constant_Db_Config_Active::PENDING => 'Đang xử lý'
        );
        return isset($data[$status]) ? $data[$status] : '';
    }
}
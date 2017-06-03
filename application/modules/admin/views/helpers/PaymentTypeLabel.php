<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/21/2016
 * Time: 4:58 PM
 */
class Admin_View_Helper_PaymentTypeLabel extends Zend_View_Helper_Abstract
{
    public function paymentTypeLabel($id)
    {
        $data = Admin_Model_ConfigPayment::getInstance()->getById($id);
        return isset($data[DbTable_Config_Payment::COL_CONFIG_PAYMENT_NAME]) ? $data[DbTable_Config_Payment::COL_CONFIG_PAYMENT_NAME] : null;
    }
}

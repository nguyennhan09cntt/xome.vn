<?php
/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 4/23/2016
 * Time: 10:34 AM
 */

class Admin_View_Helper_ProductCPanel extends Zend_View_Helper_Abstract
{
    public function productCPanel($id)
    {
        $result = '';
        if ($id) {
            $companyInfo = Admin_Model_Product::getInstance()->getById($id);
            $this->view->assign('productInfo', $companyInfo->current());
            $result = $this->view->render('widgets/product-cpanel.phtml');
        }
        return $result;
    }
}
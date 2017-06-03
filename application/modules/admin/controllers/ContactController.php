<?php

class Admin_ContactController extends Application_Controller_BackEnd_Admin
{

    public function indexAction()
    {
        $fkActive = $this->getRequest()->getParam('a', -1);
        $name = $this->getRequest()->getParam('n');
        $this->loadGird(Admin_Model_Contact::getInstance()->searchQuery($name, $fkActive));

        $this->view->assign('name', $name);
        $this->view->assign('active', $fkActive);
    }

    public function manualUpdateAction()
    {
        $manualUpdateId = $this->getRequest()->getParam('manualUpdateId');
        $manualUpdateAction = $this->getRequest()->getParam('manualUpdateAction');
        $manualUpdateUrl = $this->getRequest()->getParam('manualUpdateUrl');

        $manualUpdateAction = strtolower(trim($manualUpdateAction));

        $idValue = explode(',', $manualUpdateId);
        if ($idValue) {
            if (in_array($manualUpdateAction, array(
                'finished',
                'pending'
            ))) {
                $valueActive = $manualUpdateAction == 'finished' ? Application_Constant_Db_Config_Active::FINISHED : Application_Constant_Db_Config_Active::PENDING;
                Admin_Model_Contact::getInstance()->manualUpdateActive($valueActive, $idValue);
            }
            if (in_array($manualUpdateAction, array(
                'deleted',
                'active'
            ))) {
                $valueActive = $manualUpdateAction == 'active' ? Application_Constant_Db_Config_Active::ACTIVE : Application_Constant_Db_Config_Active::DELETED;
                Admin_Model_Contact::getInstance()->manualUpdateActive($valueActive, $idValue);
            }
        }

        $this->gotoUrl($manualUpdateUrl);
        $this->noRender();
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('i');
        $categoryData = Admin_Model_ProductCategory::getInstance()->getAllProductCategory();
        $dataInfo = Admin_Model_Contact::getInstance()->getById($id);
        $dataInfo = $dataInfo ? $dataInfo->current() : null;
        $this->view->assign('categoryData', $this->_helper->buildArrayInKeyAttribute($categoryData, DbTable_Product_Category::COL_PRODUCT_CATEGORY_ID, DbTable_Product_Category::COL_PRODUCT_CATEGORY_NAME));
        $this->view->assign('dataInfo', $dataInfo);
    }

    public function submitEditAction()
    {
        $id = $this->getRequest()->getParam('id');

        $name = $this->getRequest()->getParam('name');
        $phone = $this->getRequest()->getParam('phone');
        $email = $this->getRequest()->getParam('email');
        $address = $this->getRequest()->getParam('address');
        $price = $this->getRequest()->getParam('price');
        $product = $this->getRequest()->getParam('product');
        $message = $this->getParam('message');
        $district = $this->getRequest()->getParam('district');
        $city = 1;

       
        $msgError = null;
        if ($id) {
            $msgError = Admin_Model_Contact::getInstance()->update($id, $name, $email, $phone, $message, $address, $price, $product, $city, $district);
        } else {
            if ($name & $phone) {
                $msgError = Admin_Model_Contact::getInstance()->insert($name, $email, $phone, $message, $address, $price, $product, $city, $district);
            } else {
                $msgError = 'Bạn cần điền đầy đủ thông tin';
            }
        }

        if ($msgError) {
            $this->alertSubmitError($msgError);
        } else {
            $this->redirectSubmit('contact');
        }


        $this->noRender();
    }
}


<?php

class Admin_ProductCategoryController extends Application_Controller_BackEnd_Admin
{
    public function indexAction()
    {
        $name = $this->getRequest()->getParam('n');
        $fkComponent = $this->getRequest()->getParam('fkComponent');
        $this->loadGird(Admin_Model_ProductCategory::getInstance()->searchQuery($name));
        $componentData = Admin_Model_ProductComponent::getInstance()->getAll();
        $this->view->assign('name', $name);
        $this->view->assign('fkComponent', $fkComponent);
        $this->view->assign('componentData', $this->_helper->buildArrayInKeyAttribute($componentData, DbTable_Product_Component::COL_PRODUCT_COMPONENT_ID, DbTable_Product_Component::COL_PRODUCT_COMPONENT_NAME));
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('i');
        $categoryData = Admin_Model_ProductCategory::getInstance()->getAllParentCategory();
        $dataInfo = Admin_Model_ProductCategory::getInstance()->getById($id);
        $dataInfo = $dataInfo ? $dataInfo->current() : null;
        $componentData = Admin_Model_ProductComponent::getInstance()->getAll();
        $this->view->assign('categoryData', $this->_helper->buildArrayInKeyAttribute($categoryData, DbTable_Product_Category::COL_PRODUCT_CATEGORY_ID, DbTable_Product_Category::COL_PRODUCT_CATEGORY_NAME));
        $this->view->assign('dataInfo', $dataInfo);
        $this->view->assign('componentData', $this->_helper->buildArrayInKeyAttribute($componentData, DbTable_Product_Component::COL_PRODUCT_COMPONENT_ID, DbTable_Product_Component::COL_PRODUCT_COMPONENT_NAME));
    }

    public function submitEditAction()
    {
        $id = $this->getRequest()->getParam('id');
        $name = $this->getRequest()->getParam('name');
        $identify = $this->getRequest()->getParam('identify');
        $category = $this->getRequest()->getParam('parentId');
        $componentId = $this->getRequest()->getParam('componentId');
        $display = $this->getRequest()->getParam('display', 0);
        $priority = $this->getRequest()->getParam('priority', 0);
        $message = null;
        if ($id) {
            $message = Admin_Model_ProductCategory::getInstance()->update($id, $name, $identify, $category, $componentId, $display, $priority);
        } else {
            $message = Admin_Model_ProductCategory::getInstance()->insert($name, $category, $componentId, $display, $priority);
        }

        if ($message) {
            $this->alertSubmitError($message);
        } else {
            $this->redirectSubmit('product-category');
        }

        $this->noRender();
    }

    public function manualUpdateAction()
    {
        $manualUpdateId = $this->getRequest()->getParam('manualUpdateId');
        $manualUpdateAction = $this->getRequest()->getParam('manualUpdateAction');
        $manualUpdateUrl = $this->getRequest()->getParam('manualUpdateUrl');

        $manualUpdateAction = strtolower(trim($manualUpdateAction));

        $idValue = explode(',', $manualUpdateId);
        if ($idValue) {
            if (in_array($manualUpdateAction, array('activate', 'inactivate'))) {
                $valueActive = $manualUpdateAction == 'activate' ? Application_Constant_Db_Config_Active::ACTIVE : Application_Constant_Db_Config_Active::INACTIVE;
                Admin_Model_ProductCategory::getInstance()->manualUpdateActive($valueActive, $idValue);
            }
        }

        $this->gotoUrl($manualUpdateUrl);
        $this->noRender();
    }
}


<?php

class Admin_CelebrityController extends Application_Controller_BackEnd_Admin
{
    public function indexAction()
    {
        $name = $this->getRequest()->getParam('n');
        $code = $this->getRequest()->getParam('e');
        $category = $this->getRequest()->getParam('c');
        $active = $this->getRequest()->getParam('a', -1);
        $priority = $this->getRequest()->getParam('p', -1);
        $this->loadGird(Admin_Model_Celebrity::getInstance()->searchQuery($name, $code, $category, $active, $priority));

        $this->view->assign('name', $name);
        $this->view->assign('code', $code);
        $this->view->assign('category', $category);
        $this->view->assign('priority', $priority);

    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('i');
        $categoryData = Admin_Model_CelebrityCategory::getInstance()->getAll();
        $dataInfo = Admin_Model_Celebrity::getInstance()->getById($id);
        $dataInfo = $dataInfo ? $dataInfo->current() : null;
        $this->view->assign('categoryData',
            $this->_helper->buildArrayInKeyAttribute(
                $categoryData,
                DbTable_Celebrity_Category::COL_CELEBRITY_CATEGORY_ID,
                DbTable_Celebrity_Category::COL_CELEBRITY_CATEGORY_NAME)
        );
        $provinceData = Admin_Model_Province::getInstance()->getAll();
        $this->view->assign('provinceData',
            $this->_helper->buildArrayInKeyAttribute(
                $provinceData,
                DbTable_Province::COL_PROVINCE_ID,
                DbTable_Province::COL_PROVINCE_NAME
            )
        );
        $this->view->assign('dataInfo', $dataInfo);
        // $componentData = Admin_Model_ProductComponent::getInstance()->getAll();
        //$this->view->assign('componentData', $this->_helper->buildArrayInKeyAttribute($componentData, DbTable_Product_Component::COL_PRODUCT_COMPONENT_ID, DbTable_Product_Component::COL_PRODUCT_COMPONENT_NAME));
    }

    public function submitEditAction()
    {
        $id = $this->getRequest()->getParam('id');
        $name = $this->getRequest()->getParam('name');
        $facebookLink = $this->getRequest()->getParam('faceBook');

        $componentId = $this->getRequest()->getParam('componentId');
        $category = $this->getRequest()->getParam('category');
        $description = $this->getRequest()->getParam('description');
        $shortDescription = $this->getRequest()->getParam('shortDescription');
        $note = $this->getRequest()->getParam('note');
        $province = $this->getRequest()->getParam('province');
        $district = $this->getRequest()->getParam('district');
        $gender = $this->getRequest()->getParam('gender');
        $tag = $this->getRequest()->getParam('tag');

        $image = $this->getRequest()->getParam('image');

        $elementName = 'file_image';

        if (isset($_FILES[$elementName]) && $_FILES[$elementName]['name']) {
            $image = $this->uploadImage('product', $elementName);
        }

        $message = null;
        if ($id) {
            $message = Admin_Model_Celebrity::getInstance()->update($id, $name, $facebookLink, $image, $category, $componentId, $description, $shortDescription, $note, $province, $district, $gender, $tag);
        } else {
            $message = Admin_Model_Celebrity::getInstance()->insert($name, $facebookLink, $image, $category, $componentId, $description, $shortDescription, $note,  $province, $district, $gender, $tag);
        }

        if ($message) {
            $this->alertSubmitError($message);
        } else {
            $this->redirectSubmit('celebrity');
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
                $valueActive = $manualUpdateAction == 'activate' ?
                    Application_Constant_Db_Config_Active::ACTIVE : Application_Constant_Db_Config_Active::INACTIVE;
                Admin_Model_Celebrity::getInstance()->manualUpdateActive($valueActive, $idValue);
            }
        }

        $this->gotoUrl($manualUpdateUrl);
        $this->noRender();
    }

    public function manualPriorityAction()
    {
        $manualUpdateId = $this->getRequest()->getParam('manualUpdateId');
        $manualUpdateAction = $this->getRequest()->getParam('manualUpdateAction');
        $manualUpdateUrl = $this->getRequest()->getParam('manualUpdateUrl');

        $valueActive = intval($manualUpdateAction);

        $idValue = explode(',', $manualUpdateId);
        if ($idValue) {
            Admin_Model_Product::getInstance()->manualUpdatePriority($valueActive, $idValue);
        }

        $this->gotoUrl($manualUpdateUrl);
        $this->noRender();
    }
}

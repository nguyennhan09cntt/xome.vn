<?php

class Admin_BlogCategoryController extends Application_Controller_BackEnd_Admin
{
    public function indexAction()
    {
        $name = $this->getRequest()->getParam('n');
        $fkComponent = null;// $this->getRequest()->getParam('c', Application_Constant_Db_Blog_Component::BLOG_ALL);
        $fkActive = $this->getRequest()->getParam('a');

        $this->loadGird(Admin_Model_BlogCategory::getInstance()->searchQuery($name, $fkComponent, $fkActive));

        $this->view->assign('name', $name);
        // $this->view->assign ( 'fkComponent', $fkComponent );
        $this->view->assign('fkActive', $fkActive);
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('i');
        $categoryData = Admin_Model_BlogCategory::getInstance()->getAllParentCategory();

        $dataInfo = Admin_Model_BlogCategory::getInstance()->getById($id);
        $dataInfo = $dataInfo ? $dataInfo->current() : null;
        $this->view->assign(
            'categoryData',
            $this->_helper->buildArrayInKeyAttribute(
                $categoryData,
                DbTable_Blog_Category::COL_BLOG_CATEGORY_ID,
                DbTable_Blog_Category::COL_BLOG_CATEGORY_NAME
            )
        );

        $this->view->assign('dataInfo', $dataInfo);
    }

    public function submitEditAction()
    {
        $id = $this->getRequest()->getParam('id');
        $name = $this->getRequest()->getParam('name');
        $identify = $this->getRequest()->getParam('identify');
        $category = $this->getRequest()->getParam('parentId');
        $component = $this->getRequest()->getParam('component', Application_Constant_Db_Blog_Component::BLOG_ALL);
        $position = $this->getRequest()->getParam('position');
        $message = null;
        if ($id) {
            $message = Admin_Model_BlogCategory::getInstance()->update($id, $name, $identify, $position);
        } else {
            $message = Admin_Model_BlogCategory::getInstance()->insert($name, $category, $component);
        }

        if ($message) {
            $this->alertSubmitError($message);
        } else {
            $this->redirectSubmit('blog-category');
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
                Admin_Model_BlogCategory::getInstance()->manualUpdateActive($valueActive, $idValue);
            }
        }

        $this->gotoUrl($manualUpdateUrl);
        $this->noRender();
    }
}
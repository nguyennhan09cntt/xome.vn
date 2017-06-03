<?php

class Admin_SiteNewsController extends Application_Controller_BackEnd_Admin
{

    public function indexAction()
    {
        $fkActive = $this->getRequest()->getParam('a', -1);
        $name = $this->getRequest()->getParam('n');
        $fkComponent = null;
        $fkCategory = $this->getRequest()->getParam('c');
        $this->loadGird(Admin_Model_Blog::getInstance()->searchQuery($name, $fkActive, $fkComponent, $fkCategory));

        $this->view->assign('name', $name);
        $this->view->assign('active', $fkActive);
        $this->view->assign('category', $fkCategory);
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('i');
        $dataInfo = Admin_Model_Blog::getInstance()->getById($id);
        $dataInfo = $dataInfo ? $dataInfo->current() : null;
        $this->view->assign('dataInfo', $dataInfo);
        $this->view->assign(
            'categoryData',
            $this->_helper->buildArrayInKeyAttribute(
                Admin_Model_BlogCategory::getInstance()->getAll(),
                DbTable_Blog_Category::COL_BLOG_CATEGORY_ID,
                DbTable_Blog_Category::COL_BLOG_CATEGORY_NAME
            )
        );


    }

    public function addVideoAction()
    {
        $id = $this->getRequest()->getParam('i');
        $dataInfo = Admin_Model_Blog::getInstance()->getById($id);
        $dataInfo = $dataInfo ? $dataInfo->current() : null;
        $this->view->assign('dataInfo', $dataInfo);
        $this->view->assign(
            'categoryData',
            $this->_helper->buildArrayInKeyAttribute(
                Admin_Model_BlogCategory::getInstance()->getAll(),
                DbTable_Blog_Category::COL_BLOG_CATEGORY_ID,
                DbTable_Blog_Category::COL_BLOG_CATEGORY_NAME
            )
        );


    }

    public function submitEditAction()
    {
        $id = $this->getRequest()->getParam('id');
        $name = $this->getRequest()->getParam('name');
        $image = $this->getRequest()->getParam('image');
        $category = $this->getRequest()->getParam('category');
        $description = $this->getRequest()->getParam('description');
        $content = $this->getRequest()->getParam('content');
        $component = Application_Constant_Db_Blog_Component::BLOG_ALL;
        $elementName = 'file_image';

        if (isset($_FILES[$elementName]) && $_FILES[$elementName]['name']) {
            $image = $this->uploadImage('site-slide', $elementName);
        }

        $message = null;
        if ($id) {
            $message = Admin_Model_Blog::getInstance()->update($id, $name, $image, $content, $description, $category, $component);
        } else {
            $message = Admin_Model_Blog::getInstance()->insert($name, $image, $content, $description, $category, $component);
        }

        if ($message) {
            $this->alertSubmitError($message);
        } else {
            $this->redirectSubmit('site-news/');
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
                Admin_Model_Blog::getInstance()->manualUpdateActive($valueActive, $idValue);
            }
        }

        $this->gotoUrl($manualUpdateUrl);
        $this->noRender();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/23/15
 * Time: 1:44 PM
 */
class Admin_AdminModuleController extends Application_Controller_BackEnd_Admin
{
    public function indexAction()
    {
        $componentId = $this->getRequest()->getParam('c');
        $this->loadGird(
            Admin_Model_AdminModule::getInstance()->searchQuery($componentId)
        );
        $this->view->assign('componentId', $componentId);
    }

    public function editAction()
    {}

    public function submitEditAction()
    {
        Admin_Model_AdminModule::getInstance()->insert(
            $this->getRequest()->getParam('moduleName'),
            $this->getRequest()->getParam('priority'),
            $this->getRequest()->getParam('componentId')
        );
        $this->redirectSubmit('admin-module');
        $this->noRender();
    }
}
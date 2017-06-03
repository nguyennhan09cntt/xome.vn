<?php

class Admin_SiteContentController extends Application_Controller_BackEnd_Admin
{

    public function indexAction()
    {
        $fkActive = $this->getRequest()->getParam('a', -1);
        $name = $this->getRequest()->getParam('n');
        $this->loadGird(Admin_Model_SiteContent::getInstance()->searchQuery($name, $fkActive));

        $this->view->assign('name', $name);
        $this->view->assign('active', $fkActive);
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('i');
        $dataInfo = Admin_Model_SiteContent::getInstance()->getById($id);
        $dataInfo = $dataInfo ? $dataInfo->current() : null;
        $this->view->assign('dataInfo', $dataInfo);

    }

    public function submitEditAction()
    {
        $id = $this->getRequest()->getParam('id');
        $name = $this->getRequest()->getParam('name');

        $identify = $this->getRequest()->getParam('identify');
        $content= $this->getRequest()->getParam('content');
        $message = null;
        if ($id) {
            $message = Admin_Model_SiteContent::getInstance()->update($id, $name, $identify, $content);
        } else {
            $message = Admin_Model_SiteContent::getInstance()->insert($name, $content);
        }

        if ($message) {
            $this->alertSubmitError($message);
        } else {
            $this->redirectSubmit('site-content/');
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
            if (in_array($manualUpdateAction, array(
                'activate',
                'inactivate'
            ))) {
                $valueActive = $manualUpdateAction == 'activate' ? Application_Constant_Db_Config_Active::ACTIVE : Application_Constant_Db_Config_Active::INACTIVE;
                Admin_Model_SiteSlide::getInstance()->manualUpdateActive($valueActive, $idValue);
            }
        }

        $this->gotoUrl($manualUpdateUrl);
        $this->noRender();
    }
}


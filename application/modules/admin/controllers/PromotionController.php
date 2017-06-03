<?php

/**
 * Created by PhpStorm.
 * User: nhannvt
 * Date: 10/21/2016
 * Time: 6:48 PM
 */
class Admin_PromotionController extends Application_Controller_BackEnd_Admin
{
    public function indexAction()
    {
        $fkConfigComponent = $this->getRequest()->getParam('fkComponent',-1);
        $title = $this->getRequest()->getParam('title');
        $active = $this->getRequest()->getParam('active',-1);
        $expiredDate =  $this->getRequest()->getParam('expiredDate');

        
        $this->loadGird(
            Admin_Model_Promotion::getInstance()->searchQuery($fkConfigComponent, $title, $active, $expiredDate)
        );

        $this->view->assign('fkComponent', $fkConfigComponent);
        $this->view->assign('title', $title);
        $this->view->assign('active',$active);
        $this->view->assign('expiredDate',$expiredDate);


    }
    public function editAction()
    {
        $id = $this->getRequest()->getParam('i');
        if ($id) {
            $data = Admin_Model_Promotion::getInstance()->getById($id);
            if ($data) {
                $this->view->assign('dataInfo', $data->current());
            }
        }

    }

    public function submitEditAction()
    {
        $id = $this->getRequest()->getParam('id');
        $fkComponent = $this->getRequest()->getParam('fkComponent',1);
        $title = $this->getRequest()->getParam('name');
        $subContent = $this->getRequest()->getParam('subContent');
        $content = $this->getRequest()->getParam('content');
        $expiredDate = $this->getRequest()->getParam('expiredDate');
        $image = $this->getRequest()->getParam('image');
        $imageSlider = $this->getRequest()->getParam('imageSlider');
        $elementName = 'file_image';
        $elementImageSlider = 'file_imageSlider';
        $validation = true;
        if ($validation) {
            if (isset($_FILES[$elementName]) && $_FILES[$elementName]['name']) {
                $image = $this->uploadImage('promotion', $elementName);
            }
            if (isset($_FILES[$elementImageSlider]) && $_FILES[$elementImageSlider]['name']) {
                $imageSlider = $this->uploadImage('promotion-slider', $elementImageSlider);
            }
            $message = null;
            if ($id) {
                $message = Admin_Model_Promotion::getInstance()->update($id, $fkComponent, $title, $subContent, $content, $image, $expiredDate, $imageSlider);
            } else {
                $message = Admin_Model_Promotion::getInstance()->insert($fkComponent, $title, $subContent, $content, $image, $expiredDate, $imageSlider);
            }
            if ($message) {
                $this->alertSubmitError($message);
            } else {
                $this->redirectSubmit('promotion');
            }
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
                $valueActive = $manualUpdateAction=='activate' ?
                    Application_Constant_Db_Config_Active::ACTIVE : Application_Constant_Db_Config_Active::INACTIVE;
                Admin_Model_Promotion::getInstance()->manualUpdateActive($valueActive, $idValue);
            }
        }

        $this->gotoUrl($manualUpdateUrl);
        $this->noRender();
    }
}
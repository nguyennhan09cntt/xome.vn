<?php
/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/23/15
 * Time: 2:29 PM
 */
class Admin_AdminResourceController extends Application_Controller_BackEnd_Admin
{
    public function indexAction()
    {
        $fkModule = $this->getRequest()->getParam('m');

        $this->loadGird(
            Admin_Model_AdminResource::getInstance()->searchQuery($fkModule)
        );

        $this->view->assign('fkModule', $fkModule);
        $this->view->assign(
            'moduleData',
            $this->_helper->buildArrayInKeyAttribute(
                Admin_Model_AdminModule::getInstance()->getAll(),
                DbTable_Admin_Module::COL_ADMIN_MODULE_ID,
                DbTable_Admin_Module::COL_ADMIN_MODULE_NAME
            )
        );
    }

    public function editAction()
    {
        $fkModule = $this->getRequest()->getParam('m');
        $id = $this->getRequest()->getParam('i');
        if ($id) {
            $data = Admin_Model_AdminResource::getInstance()->getById($id);
            if ($data) {
                $this->view->assign('dataInfo', $data->current());
                $fkModule = $data->current()->{DbTable_Admin_Resource::COL_FK_ADMIN_MODULE};
            }
        }

        $this->view->assign('fkModule', $fkModule);
        $this->view->assign(
            'moduleData',
            $this->_helper->buildArrayInKeyAttribute(
                Admin_Model_AdminModule::getInstance()->getAll(),
                DbTable_Admin_Module::COL_ADMIN_MODULE_ID,
                DbTable_Admin_Module::COL_ADMIN_MODULE_NAME
            )
        );
    }

    public function submitEditAction()
    {
        $id = $this->getRequest()->getParam('id');
        $resourceName = $this->getRequest()->getParam('resourceName');
        $controllerName = $this->getRequest()->getParam('controllerName');
        $priority = $this->getRequest()->getParam('priority');
        $fkModule = $this->getRequest()->getParam('fkModule');

        $message = null;
        if ($id) {
            $message = Admin_Model_AdminResource::getInstance()->update($id, $resourceName, $controllerName, $priority, $fkModule);
        } else {
            $message = Admin_Model_AdminResource::getInstance()->insert($resourceName, $controllerName, $priority, $fkModule);
        }

        if ($message) {
            $this->alertSubmitError($message);
        } else {
            $this->redirectSubmit('admin-resource/?m=' . $fkModule);
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
                Admin_Model_AdminResource::getInstance()->manualUpdateActive($valueActive, $idValue);
            } elseif (in_array($manualUpdateAction, array('display', 'non-display'))) {
                $valueDisplay = $manualUpdateAction=='display' ?
                    Application_Constant_Db_Admin_Resource::DISPLAY : Application_Constant_Db_Admin_Resource::NON_DISPLAY;
                Admin_Model_AdminResource::getInstance()->manualUpdateDisplay($valueDisplay, $idValue);
            }
        }

        $this->gotoUrl($manualUpdateUrl);
        $this->noRender();
    }
}
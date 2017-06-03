<?php
/**
 * Created by PhpStorm.
 * User: mjphong
 * Date: 24/01/2015
 * Time: 21:48
 */
class Admin_AdminPrivilegeController extends Application_Controller_BackEnd_Admin
{
    public function indexAction()
    {
        $fkResource = $this->getRequest()->getParam('r');

        $this->loadGird(
            Admin_Model_AdminPrivilege::getInstance()->searchQuery($fkResource)
        );

        $this->view->assign('fkResource', $fkResource);
        $this->view->assign(
            'resourceData',
            $this->_helper->buildArrayInKeyAttribute(
                Admin_Model_AdminResource::getInstance()->getAll(),
                DbTable_Admin_Resource::COL_ADMIN_RESOURCE_ID,
                DbTable_Admin_Resource::COL_ADMIN_RESOURCE_NAME
            )
        );
    }

    public function editAction()
    {
        $fkResource = $this->getRequest()->getParam('r');
        $id = $this->getRequest()->getParam('i');
        if ($id) {
            $data = Admin_Model_AdminPrivilege::getInstance()->getById($id);
            if ($data) {
                $this->view->assign('dataInfo', $data->current());
                $fkResource = $data->current()->{DbTable_Admin_Privilege::COL_FK_ADMIN_RESOURCE};
            }
        }

        $this->view->assign('fkResource', $fkResource);
        $this->view->assign(
            'resourceData',
            $this->_helper->buildArrayInKeyAttribute(
                Admin_Model_AdminResource::getInstance()->getAll(),
                DbTable_Admin_Resource::COL_ADMIN_RESOURCE_ID,
                DbTable_Admin_Resource::COL_ADMIN_RESOURCE_NAME
            )
        );
    }

    public function submitEditAction()
    {
        $id = $this->getRequest()->getParam('id');
        $privilegeName = $this->getRequest()->getParam('privilegeName');
        $actionName = $this->getRequest()->getParam('actionName');
        $priority = $this->getRequest()->getParam('priority');
        $fkResource = $this->getRequest()->getParam('fkResource');

        $message = null;
        if ($id) {
            $message = Admin_Model_AdminPrivilege::getInstance()->update($id, $privilegeName, $actionName, $priority, $fkResource);
        } else {
            $message = Admin_Model_AdminPrivilege::getInstance()->insert($privilegeName, $actionName, $priority, $fkResource);
        }

        if ($message) {
            $this->alertSubmitError($message);
        } else {
            $this->redirectSubmit('admin-privilege/?r=' . $fkResource);
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
                Admin_Model_AdminPrivilege::getInstance()->manualUpdateActive($valueActive, $idValue);
            } elseif (in_array($manualUpdateAction, array('display', 'non-display'))) {
                $valueDisplay = $manualUpdateAction=='display' ?
                    Application_Constant_Db_Admin_Resource::DISPLAY : Application_Constant_Db_Admin_Resource::NON_DISPLAY;
                Admin_Model_AdminPrivilege::getInstance()->manualUpdateDisplay($valueDisplay, $idValue);
            }
        }

        $this->gotoUrl($manualUpdateUrl);
        $this->noRender();
    }
}
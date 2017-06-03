<?php
/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/21/15
 * Time: 3:38 PM
 */
class Admin_AdminRoleController extends Application_Controller_BackEnd_Admin
{
    public function indexAction()
    {
        $this->loadGird(
            Admin_Model_AdminRole::getInstance()->searchQuery()
        );
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('i');
        $aclData = null;
        if ($id) {
            $data = Admin_Model_AdminRole::getInstance()->getById($id);
            if ($data) {
                $this->view->assign('dataInfo', $data->current());
                $aclData = Admin_Model_AdminAcl::getInstance()->searchByRoleId($id);
            }
        }
        $this->view->assign('privilegeData', Admin_Model_AdminModule::getInstance()->getAllPrivileges());
        $this->view->assign(
            'aclArr',
            $aclData ? $this->_helper->buildArrayByKey(
                $aclData,
                DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_ID
            ) : array()
        );
    }

    public function submitEditAction()
    {
        $id = $this->getRequest()->getParam('id');
        $roleName = $this->getRequest()->getParam('roleName');
        $privilegeArrId = $this->getRequest()->getParam('privilegeArrId');

        $message = null;
        if ($id) {
            $message = Admin_Model_AdminRole::getInstance()->update($id, $roleName);
        } else {
            $id = Admin_Model_AdminRole::getInstance()->insert($roleName);
        }

        if ($message) {
            $this->alertSubmitError($message);
        } else {
            Admin_Model_AdminAcl::getInstance()->deleteByRoleId($id);
            if ($privilegeArrId) {
                foreach($privilegeArrId as $privilegeId) {
                    Admin_Model_AdminAcl::getInstance()->insert($id, $privilegeId);
                }
            }
            $this->redirectSubmit('admin-role');
        }
        $this->noRender();
    }
}
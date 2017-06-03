<?php

/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/23/15
 * Time: 2:29 PM
 */
class Admin_AdminController extends Application_Controller_BackEnd_Admin
{
    public function indexAction()
    {
        $fkRole = $this->getRequest()->getParam('r');
        $email = $this->getRequest()->getParam('e');

        $this->loadGird(
            Admin_Model_Admin::getInstance()->searchQuery($email, $fkRole)
        );

        $this->view->assign('fkRole', $fkRole);
        $this->view->assign('email', $email);
        $this->view->assign(
            'roleData',
            $this->_helper->buildArrayInKeyAttribute(
                Admin_Model_AdminRole::getInstance()->getAll(),
                DbTable_Admin_Role::COL_ADMIN_ROLE_ID,
                DbTable_Admin_Role::COL_ADMIN_ROLE_NAME
            )
        );
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('i');
        $permissionData = array();

        if ($id) {
            $data = Admin_Model_Admin::getInstance()->getById($id);
            if ($data) {
                $dataInfo = $data->current();
                $this->view->assign('dataInfo', $dataInfo);
                $permissionData = Admin_Model_AdminPermission::getInstance()->searchByAdminId($data->current()->{DbTable_Admin::COL_ADMIN_ID});

                $this->view->assign(
                    'privilegeData',
                    Admin_Model_Admin::getInstance()->getAllPrivilegesByFkAdminRole(
                        $dataInfo->{DbTable_Admin::COL_FK_ADMIN_ROLE}
                    )
                );
            }
        }

        $this->view->assign(
            'roleData',
            $this->_helper->buildArrayInKeyAttribute(
                Admin_Model_AdminRole::getInstance()->getAll(),
                DbTable_Admin_Role::COL_ADMIN_ROLE_ID,
                DbTable_Admin_Role::COL_ADMIN_ROLE_NAME
            )
        );

        $this->view->assign(
            'permissionArr',
            $permissionData ? $this->_helper->buildArrayByKey(
                $permissionData,
                DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_ID
            ) : array()
        );

    }

    public function submitEditAction()
    {
        $id = $this->getRequest()->getParam('id');
        $email = $this->getRequest()->getParam('email');
        $password = $this->getRequest()->getParam('password');
        $fullName = $this->getRequest()->getParam('fullName');
        $fkRole = $this->getRequest()->getParam('fkRole');
        $privilegeArrId = $this->getRequest()->getParam('privilegeArrId');

        $message = null;
        if ($id) {
            $message = Admin_Model_Admin::getInstance()->update($id, $fullName, $fkRole);
        } else {
            if (Admin_Model_Admin::getInstance()->searchByEmail($email)) {
                $message = 'Email is duplicated';
            } else {
                $id = Admin_Model_Admin::getInstance()->insert($email, $password, $fullName, $fkRole);
                $this->_sendMailNewAdministrator($email, $password, $fullName);
            }
        }

        if ($message) {
            $this->alertSubmitError($message);
        } else {
            Admin_Model_AdminPermission::getInstance()->deleteByAdminId($id);
            if ($privilegeArrId) {
                foreach ($privilegeArrId as $privilegeId) {
                    Admin_Model_AdminPermission::getInstance()->insert($id, $privilegeId);
                }
            }
            $this->redirectSubmit('admin');
        }
        $this->noRender();
    }

    private function _sendMailNewAdministrator($email, $password, $fullName)
    {
        $this->view->assign('email', $email);
        $this->view->assign('password', $password);
        $this->view->assign('fullName', $fullName);
        $this->doSendMail(
            $email,
            $fullName,
            Application_Constant_Global_Email::SUBJECT_NEW_ADMINISTRATOR,
            $this->view->render('mail-templates/new-administrator.phtml')
        );
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
                Admin_Model_Admin::getInstance()->manualUpdateActive($valueActive, $idValue);
            }
        }

        $this->gotoUrl($manualUpdateUrl);
        $this->noRender();
    }

    public function validateEmailAction()
    {
        $email = $this->getRequest()->getParam('email');
        $id = $this->getRequest()->getParam('id');
        $result = 'true';
        if ($email && !$id) {
            if (Admin_Model_Admin::getInstance()->searchByEmail($email)) {
                $result = 'false';
            }
        }
        echo $result;
        $this->noRender();
    }

    public function infoAction()
    {
        $id = $this->getAdminId();
        if ($id) {
            $data = Admin_Model_Admin::getInstance()->getById($id);
            if ($data) {
                $dataInfo = $data->current();
                $this->view->assign('dataInfo', $dataInfo);
            }
        }
    }

    public function submitEditInfoAction()
    {
        $id = $this->getRequest()->getParam('id');
        $email = $this->getRequest()->getParam('email');
        $password = $this->getRequest()->getParam('password');
        $newPassword = $this->getRequest()->getParam('new-password');
        $reNewPassword = $this->getRequest()->getParam('re-new-password');
        $fullName = $this->getRequest()->getParam('fullName');
        $message = '';
        if ($email && $password && $newPassword && $reNewPassword && ($reNewPassword == $newPassword)) {

            $db = Zend_Db_Table_Abstract::getDefaultAdapter();
            $adapter = new Zend_Auth_Adapter_DbTable($db);
            $adapter->setTableName(DbTable_Admin::_tableName)
                ->setIdentityColumn(DbTable_Admin::COL_ADMIN_EMAIL)
                ->setCredentialColumn(DbTable_Admin::COL_ADMIN_PASSWORD)
                ->setCredentialTreatment('MD5(?)');
            $adapter->setIdentity($email);
            $adapter->setCredential($password);
            $result = Zend_Auth::getInstance()->authenticate($adapter);

            if ($result->isValid()) {
                $user = $adapter->getResultRowObject();
                if ($user->{DbTable_Admin::COL_ADMIN_ACTIVE} == 1 && $user->{DbTable_Admin::COL_ADMIN_ID} == $id) {
                    Admin_Model_Admin::getInstance()->updateInfo($id, $fullName, $newPassword);
                }else{
                    $message ='Dữ liệu không chính xác, xin vui lòng kiểm tra lại thông tin.';
                }
            }else{
                $message ='Dữ liệu không chính xác, xin vui lòng kiểm tra lại thông tin.';
            }
        }else{
            $message ='Dữ liệu không chính xác, xin vui lòng kiểm tra lại thông tin.';
        }
        if ($message) {
            $this->alertSubmitError($message);
        } else {
            $this->redirectSubmit('login/logout');
        }
        $this->noRender();

    }
}
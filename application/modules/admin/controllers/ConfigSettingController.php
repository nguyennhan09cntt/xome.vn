<?php
/**
 * Created by PhpStorm.
 * User: duyca
 * Date: 6/9/2015
 * Time: 9:20 AM
 */
class Admin_ConfigSettingController extends Application_Controller_BackEnd_Admin
{
    public function indexAction()
    {
        $note = $this->getRequest()->getParam('n');
        $value = $this->getRequest()->getParam('v');
        $type = $this->getRequest()->getParam('t');

        $this->loadGird(
            Admin_Model_ConfigSetting::getInstance()->searchQuery($note, $value, $type)
        );

        $this->view->assign('note', $note);
        $this->view->assign('value', $value);
        $this->view->assign('type', $type);
    }

    public function addAction()
    {
        $this->view->assign(
            'adminData',
            $this->_helper->buildArrayInKeyAttribute(
                Admin_Model_Admin::getInstance()->getAllInfo(),
                DbTable_Admin::COL_ADMIN_ID,
                DbTable_Admin::COL_ADMIN_FULLNAME
            )
        );
    }

    public function submitAddAction()
    {
        $fk_admin = $this->getRequest()->getParam('fk_admin');
        $note = $this->getRequest()->getParam('note');
        $value = $this->getRequest()->getParam('value');
        $type = $this->getRequest()->getParam('type');

        $message = null;
        $message = Admin_Model_ConfigSetting::getInstance()->insert($note, $value, $type, $fk_admin);

        if ($message) {
            $this->alertSubmitError($message);
        } else {
            $this->redirectSubmit('config-setting');
        }
        $this->noRender();
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('i');
        if ($id) {
            $data = Admin_Model_ConfigSetting::getInstance()->getById($id);
            if ($data) {
                $this->view->assign('dataInfo', $data->current());
            }
        }
        $this->view->assign(
            'adminData',
            $this->_helper->buildArrayInKeyAttribute(
                Admin_Model_Admin::getInstance()->getAllInfo(),
                DbTable_Admin::COL_ADMIN_ID,
                DbTable_Admin::COL_ADMIN_FULLNAME
            )
        );
    }

    public function submitEditAction()
    {
        $id = $this->getRequest()->getParam('id');
        $note = $this->getRequest()->getParam('note');
        $value = $this->getRequest()->getParam('value');
        $type = $this->getRequest()->getParam('type');
        $fk_admin = $this->getRequest()->getParam('fk_admin');

        $message = Admin_Model_ConfigSetting::getInstance()->update($id, $note, $value, $type, $fk_admin);
        if ($message) {
            $this->alertSubmitError($message);
        } else {
            $this->redirectSubmit('config-setting');
        }

        $this->noRender();
    }
}
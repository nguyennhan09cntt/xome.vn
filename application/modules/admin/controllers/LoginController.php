<?php
class Admin_LoginController extends Application_Controller
{
    protected $config;

    public function init()
    {
        $config = Zend_Registry::get('config');
        $this->config = $config;

        $this->view->assign('config', $config);
    }

    public function preDispatch()
    {
        $this->_helper->layout->setLayoutPath(APPLICATION_PATH.'/modules/admin/views/scripts/login');
    }

    public function indexAction()
    {
        $isError = $this->_request->getParam('error', 0);
        $this->view->assign('isError', $isError);
    }

    public function logoutAction()
    {
        Application_Session_Admin::getInstance()->reset();
        $this->gotoUrl('index');
        $this->noRender();
    }

    public function submitAction()
    {
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();

        $strEmail	= $this->getRequest()->getParam('email');
        $strPassword	= $this->getRequest()->getParam('password');

        if($strEmail && $strPassword)
        {
            $adapter = new Zend_Auth_Adapter_DbTable($db);
            $adapter->setTableName(DbTable_Admin::_tableName)
                ->setIdentityColumn(DbTable_Admin::COL_ADMIN_EMAIL)
                ->setCredentialColumn(DbTable_Admin::COL_ADMIN_PASSWORD)
                ->setCredentialTreatment('MD5(?)')
            ;
            $adapter->setIdentity($strEmail);
            $adapter->setCredential($strPassword);
            $result = Zend_Auth::getInstance()->authenticate($adapter);

            if ($result->isValid())
            {
                $user = $adapter->getResultRowObject();
                if($user->{DbTable_Admin::COL_ADMIN_ACTIVE}==1)
                {
                    Admin_Model_Admin::getInstance()->updateLastLogin($user->{DbTable_Admin::COL_ADMIN_ID});
                    Application_Session_Admin::getInstance()->save($user);
                    $this->gotoUrl('index');
                }
            }
        }
        $this->gotoUrl('login?error=1');
        $this->noRender();
    }

    public function forgotPasswordAction()
    {
        $isError = $this->getRequest()->getParam('error', 0);
        $this->view->assign('isError', $isError);
    }

    public function submitForgotPasswordAction()
    {
        $errorCode = Application_Constant_Module_Admin_Login_ForgotPassword::ERROR_CODE_SUCCESSFUL;
        $email = $this->getRequest()->getParam('email');
        if ($email) {
            $adminInfo = Admin_Model_Admin::getInstance()->searchByEmail($email);
            if ($adminInfo) {
                $password = Application_Constant_Module_Admin_Login_ForgotPassword::DEFAULT_PASSWORD;//$this->_helper->randomString();
                Admin_Model_Admin::getInstance()->updatePasswordById(
                    $adminInfo->{DbTable_Admin::COL_ADMIN_ID},
                    $password
                );

                $this->view->assign('password', $password);
                $this->view->assign('adminInfo', $adminInfo);

                $this->doSendMail(
                    $adminInfo->{DbTable_Admin::COL_ADMIN_EMAIL},
                    $adminInfo->{DbTable_Admin::COL_ADMIN_FULLNAME},
                    Application_Constant_Global_Email::SUBJECT_FORGOT_PASSWORD,
                    $this->view->render('mail-templates/forgot-password.phtml')
                );

            } else {
                $errorCode = Application_Constant_Module_Admin_Login_ForgotPassword::ERROR_CODE_EMAIL_INVALID;
            }
        } else {
            $errorCode = Application_Constant_Module_Admin_Login_ForgotPassword::ERROR_CODE_EMAIL_NULL;
        }
        $this->gotoUrl('login/forgot-password/?error=' . $errorCode);
        $this->noRender();
    }

}
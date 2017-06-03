<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 6/11/2016
 * Time: 9:19 AM
 */
use Facebook\Facebook;
use Facebook\Exceptions;

class Mobile_CustomerController extends Application_Controller_FrontEnd_Default
{

    public function init()
    {
        parent::init();
        $this->setNoCachePage();
    }

    public function preDispatch()
    {
        parent::preDispatch();
        $actionName = $this->getRequest()->getActionName();


        if ($actionName != 'logout') {
            if ($actionName != 'info') {
                if ($this->getCustomerLoginId()) {
                    if ($actionName != 'submit-profile' && $actionName != 'course-register' && $actionName != 'home-info') {
                        $this->gotoUrl('/tai-khoan/thong-tin.html');
                    }

                }

            } else {
                if (!$this->getCustomerLoginId()) {
                    $this->gotoUrl('/tai-khoan/dang-nhap.html');
                }
            }
        }

    }

    public function logoutAction()
    {
        Model_Customer::getInstance()->updateSessionById($this->customerInfo->{DbTable_Customer::COL_CUSTOMER_ID}, null);
        $this->removeSessionCustomerInfo();
        $this->cleanUpSessionId();
        $this->cleanUpCookie(Application_Constant_Global::COOKIE_CUSTOMER);
        $this->gotoUrl($this->getRequest()->getParam('backUrl', '/'));
        $this->noRender();
    }

    public function loginAction()
    {
        $pBackUrl = $this->getRequest()->getParam('u');
        #$pBackUrl = $pBackUrl ? base64_decode($pBackUrl) : '';
        $fb = new Facebook([
            'app_id' => '1428898624081256', // Replace {app-id} with your app id
            'app_secret' => '4b4867ee98462e2de15e65f51ee57c09',
            'default_graph_version' => 'v2.3',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        $permissions = ['email', 'user_likes','user_birthday']; // optional
        $loginUrl = $helper->getLoginUrl('http://m.xome.vn/customer/fb-callback', $permissions);
        $this->view->assign('pBackUrl', $pBackUrl);
        $this->view->assign('loginUrl', $loginUrl);
    }

    public function registerAction()
    {
        /*$pBackUrl = $this->getRequest()->getParam('referrer');
        var_dump($pBackUrl);
        #$pBackUrl = $pBackUrl ? base64_decode($pBackUrl) : '';
        $this->view->assign('pBackUrl', $pBackUrl);*/
    }

    public function submitRegisterAction()
    {
        $email = $this->getRequest()->getParam('email');
        $password = $this->getRequest()->getParam('password');
        $rePassword = $this->getRequest()->getParam('confirm_pass');
        $backUrl = $this->getRequest()->getParam('backUrl');

        $captcha = $this->getRequest()->getParam('captcha');
        $lastName = $this->getRequest()->getParam('last-name');
        $firstName = $this->getRequest()->getParam('first-name');
        $name = $lastName . ' ' . $firstName;
        $phone = '';
        $address = null;
        $province = '79';
        $district = '778';
        $country = null;
        if ($this->validateSessionCaptcha($captcha)) {
            $pBackUrl = $backUrl ? base64_decode($backUrl) : '';
            if ($email && $password && $password == $rePassword) {
                $id = Model_Customer::getInstance()->insert($email, $password, $name, $phone, $address, $province, $district, $country, $lastName, $firstName);
                $user = Model_Customer::getInstance()->getById($id);
                $this->saveSessionCustomerInfo($user);
                $this->gotoUrl($pBackUrl);
            } else {
                $this->view->assign('pBackUrl', $backUrl);
                $this->gotoUrl('/tai-khoan/dang-ky.html');
            }
        } else {
            $this->view->assign('pBackUrl', $backUrl);
            $this->gotoUrl('/tai-khoan/dang-ky.html');
        }

        $this->noRender();
    }

    public function submitLoginAction()
    {
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $email = $this->getRequest()->getParam('email');
        $password = $this->getRequest()->getParam('password');
        $remember = $this->getRequest()->getParam('remember');
        $backUrl = $this->getRequest()->getParam('backUrl');
        $error = 1;
        if ($email && $password) {
            $email = strtolower($email);
            $adapter = new Zend_Auth_Adapter_DbTable($db);
            $adapter->setTableName(DbTable_Customer::_tableName)
                ->setIdentityColumn(DbTable_Customer::COL_CUSTOMER_EMAIL)
                ->setCredentialColumn(DbTable_Customer::COL_CUSTOMER_PASSWORD)
                ->setCredentialTreatment('MD5(?)');
            $adapter->setIdentity($email);
            $adapter->setCredential($password);
            $result = Zend_Auth::getInstance()->authenticate($adapter);

            if ($result->isValid()) {
                $user = $adapter->getResultRowObject();
                if ($user->{DbTable_Customer::COL_FK_CONFIG_ACTIVE} == Application_Constant_Db_Config_Active::ACTIVE) {
                    $this->saveSessionCustomerInfo($user);
                    $time = time();
                    $session = md5($time . $email);
                    if ($remember == 'on') {
                        $this->setCookie(
                            Application_Constant_Global::COOKIE_CUSTOMER,
                            $session
                        );
                        Model_Customer::getInstance()->updateSessionById($user->{DbTable_Customer::COL_CUSTOMER_ID}, $session);
                    }
                    $error = 0;
                }
            }
        }
        if ($error == 1) {
            /*echo $this->callScriptParent(
                'CustomerLogin.displayError',
                array('show')
            );*/
            $this->gotoUrl('/tai-khoan/dang-nhap.html');
        } else {
            /*echo $this->callScriptParent(
                'DefaultCommon.goTo',
                array(base64_decode($backUrl))
            );*/
            $this->gotoUrl(base64_decode($backUrl));
        }
        $this->noRender();
    }

    public function infoAction()
    {
        $districtData = array();
        $this->view->assign(
            'provinceData',
            $this->_helper->buildArrayInKeyAttribute(
                Model_Province::getInstance()->getAll(),
                DbTable_Province::COL_PROVINCE_ID,
                DbTable_Province::COL_PROVINCE_NAME
            )
        );
        $districtData = Admin_Model_District::getInstance()->getAll();


        $districtData = $this->_helper->buildArrayInKeyAttributeWithCondition(
            $districtData,
            DbTable_District::COL_DISTRICT_ID,
            DbTable_District::COL_DISTRICT_NAME,
            DbTable_District::COL_DISTRICT_PROVINCE,
            $this->customerInfo->{DbTable_Customer::COL_FK_PROVINCE}
        );


        $this->view->assign('districtData', $districtData);

    }

    public function submitProfileAction()
    {

        $id = $this->getCustomerLoginId();// $this->getRequest()->getParam('id');
        $backUrl = $this->getRequest()->getParam('backUrl');

        $captcha = $this->getRequest()->getParam('captcha');
        $lastName = $this->getRequest()->getParam('last-name');
        $firstName = $this->getRequest()->getParam('first-name');
        $name = $lastName . ' ' . $firstName;


        $phone = $this->getRequest()->getParam('phone');
        $address = $this->getRequest()->getParam('address');;
        $province = $this->getRequest()->getParam('province');;
        $district = $this->getRequest()->getParam('district');;
        $country = null;
        if ($this->validateSessionCaptcha($captcha)) {
            $pBackUrl = $backUrl ? base64_decode($backUrl) : '';
            Model_Customer::getInstance()->update($id, $name, $phone, $address, $province, $district, null, $lastName, $firstName);
            $user = Model_Customer::getInstance()->getById($id);
            $this->saveSessionCustomerInfo($user);
            $this->gotoUrl($pBackUrl);
        } else {
            $this->view->assign('pBackUrl', $backUrl);
            //$this->gotoUrl('/tai-khoan/thong-tin.html');
        }

        $this->noRender();
    }



    public function forgotPasswordAction()
    {

    }

    public function submitForgotPasswordAction()
    {
        $phone = $this->getRequest()->getParam('phone');
        $captcha = $this->getRequest()->getParam('captcha');
        if (!$this->validateSessionCaptcha($captcha)) {
            echo $this->callScriptParent(
                'CustomerForgotPassword.displayError',
                array('Captcha')
            );
        } else {
            $error = 1;
            if ($phone) {
                $customerInfo = Model_Customer::getInstance()->searchByPhone($phone);
                if ($customerInfo) {
                    $password = $this->_helper->randomString(4);
                    $password = strtolower($password);
                    Model_Customer::getInstance()->updatePasswordById(
                        $customerInfo->{DbTable_Customer::COL_CUSTOMER_ID},
                        $password
                    );

                    $this->sendCustomerNotification(
                        Application_Constant_Db_Site_Email::ACCOUNT_CUSTOMER_RESET_PASSWORD,
                        $customerInfo->{DbTable_Customer::COL_CUSTOMER_ID},
                        $password
                    );
                    $error = 0;
                }
            }

            if ($error == 1) {
                echo $this->callScriptParent(
                    'CustomerLogin.displayError',
                    array('Phone')
                );
            } else {
                echo $this->callScriptParent(
                    'DefaultCommon.goTo',
                    array(
                        sprintf(
                            '/%s', Application_Function_Common::formatRouteConfig(
                            $this->getConfigRoute('customer_forgot_password_done')
                        )
                        )
                    )
                );
            }
        }
        $this->noRender();
    }

    public function forgotPasswordDoneAction()
    {

    }



    public function homeInfoAction()
    {
        $page = $this->getRequest()->getParam('page');
        $limit = 32;
        $customerId = $this->getCustomerLoginId();
        $data = Model_Product::getInstance()->getProductByCustomer($page, $limit, $customerId);
        $productData = $data ? $data[Application_Constant_Global::KEY_DATA] : array();
        $total = $data ? $data[Application_Constant_Global::KEY_TOTAL] : 0;
        $totalPage = ($total - 1) / $limit + 1;
        Application_Function_Pagination_Default::getInstance()->initialize($totalPage, $page);

        $this->view->assign('productData', $productData);

        $this->view->assign('pagination', Application_Function_Pagination_Default::getInstance()->show());
    }

    public function fbCallbackAction()
    {
        $fb = new Facebook([
            'app_id' => '1428898624081256', // Replace {app-id} with your app id
            'app_secret' => '4b4867ee98462e2de15e65f51ee57c09',
            'default_graph_version' => 'v2.3',
        ]);

        $helper = $fb->getRedirectLoginHelper();
        try {
            $accessToken = $helper->getAccessToken();
        } catch(FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (isset($accessToken)) {
            // Logged in!
            $_SESSION['facebook_access_token'] = (string) $accessToken;
            $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
            try {
                $response = $fb->get('/me');
                $userNode = $response->getGraphUser();
            } catch(FacebookResponseException $e) {
                // When Graph returns an error
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch(FacebookSDKException $e) {
                // When validation fails or other local issues
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }
            // Now you can redirect to another page and use the
            // access token from $_SESSION['facebook_access_token']

            $facebookId = $userNode->getId();
            $email = $userNode->getEmail();
            $firstName = $userNode->getFirstName();
            $lastName = $userNode->getLastName();
            $birthDay = $userNode->getBirthday();
            $name = $userNode->getName();
            $gender = $userNode->getGender();
            $link = $userNode->getLink();
            $phone ='';
            $date = $birthDay->format('Y-m-d H:i:s');
            $user = Model_Customer::getInstance()->searchByFacebookId($facebookId);
            if(!$user){
                $id = Model_Customer::getInstance()->insertFacebook($facebookId,$email,$firstName, $lastName, $name, $gender, $date, $phone, $link);
                $user = Model_Customer::getInstance()->getById($id);
            }

            $this->saveSessionCustomerInfo($user);
            $this->gotoUrl('/tai-khoan/danh-sach-tin-nha-tro.html');

        }
        $this->noRender();
    }


}
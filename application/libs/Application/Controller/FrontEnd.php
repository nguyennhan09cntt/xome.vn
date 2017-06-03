<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/22/15
 * Time: 2:03 PM
 */
class Application_Controller_FrontEnd extends Application_Controller
{
    protected $customerInfo;

    /**
     * @var Zend_Translate
     */
    protected $translate;

    /**
     * @var STDClass
     */
    protected $session;

    public function init()
    {
        $this->session = Application_Session_FrontEnd::getInstance()->load();
        $this->customerInfo = $this->getSessionCustomerInfo();
        #Cookie Customer
        if (!$this->customerInfo) {
            $cookieValue = $this->getCookie(Application_Constant_Global::COOKIE_CUSTOMER);
            if ($cookieValue) {
                $this->saveSessionCustomerInfo(
                    Model_Customer::getInstance()->searchBySession($cookieValue)
                );
                $this->customerInfo = $this->getSessionCustomerInfo();
            }
        }
        #Cookie Customer
    }

    public function postDispatch()
    {
        $this->view->assign('translate', $this->getTranslate());
        $this->view->assign('session', $this->getSession());
        $this->view->assign('customerInfo', $this->customerInfo);
        $this->view->assign('config', $this->getConfig());

        $backUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
        $this->view->assign('backUrl', base64_encode($backUrl));
    }

    /**
     * Prevent search engine from this page
     */
    protected function setNoIndex()
    {
        $this->view->assign('noIndex', 1);
    }

    /**
     * @param string $title
     * @param string $keyword
     * @param string $description
     */
    protected function setMetaData($title, $keyword, $description)
    {
        if ($title) {
            $this->view->assign('metaTitle', $title);
        }
        if ($keyword) {
            $this->view->assign('metaKeyword', $keyword);
        }
        if ($description){
            $this->view->assign('metaDescription', $description);
        }
    }

    /**
     * Append keyword for SEO
     * @param string $keyword
     */
    protected function appendMetaDataKeyword($keyword)
    {
        $currentKeyword = $this->view->metaKeyword;
        if ($currentKeyword) {
            $keyword = sprintf('%s, %s', $currentKeyword, $keyword);
        }
        $this->view->assign('metaKeyword', $keyword);
    }

    /**
     * Get translate object
     * @return Zend_Translate
     */
    protected function getTranslate()
    {
        if (is_null($this->translate)) {
            $this->translate = new Zend_Translate(
                'tmx',
                SYS_PATH . '/data/locales/',
                $this->getCurrentLocale()
            );
        }
        return $this->translate;
    }

    /**
     * Get value translation by key
     * @param string $key
     * @return string
     */
    protected function getTranslateValue($key)
    {
        return $this->getTranslate()->_($key);
    }

    /**
     * @return array|mixed|null|STDClass
     */
    protected function getSession()
    {
        if (is_null($this->session)) {
            $this->session = new STDClass();
            $this->session->locale = Application_Constant_Global::LOCALE_VI;
            $this->session->userInfo = null;
            $this->session->seatHoldingTemp = array();
            $this->session->captcha = null;
            $this->session->captchaPos = 0;
            $this->session->customerInfo = null;
            $this->session->refCode = null;
        }
        return $this->session;
    }

    /**
     * Save session information
     */
    protected function saveSession()
    {
        Application_Session_FrontEnd::getInstance()->save($this->session);
    }

    /**
     * Save ref code to session
     * @param string $refCode
     */
    protected function saveSessionRefCode($refCode)
    {
       // $refCode = View_Filter_Db_Customer_RefCode::getInstance()->filter($refCode);
        $this->getSession()->refCode = $refCode;
        $this->saveSession();
    }

    /**
     * Get session ref code
     * @return string
     */
    protected function getSessionRefCode()
    {
        $session = $this->getSession();
        return $session->refCode;
    }

    /**
     * Remove session ref code
     */
    protected function removeSessionRefCode()
    {
        $this->getSession()->refCode = null;
        $this->saveSession();
    }

    /**
     * Save customer information to session
     * @param $customerInfo
     */
    protected function saveSessionCustomerInfo($customerInfo)
    {
        $this->getSession()->customerInfo = $customerInfo;
        $this->saveSession();
    }

    /**
     * @return mixed
     */
    protected function getSessionCustomerInfo()
    {
        $session = $this->getSession();
        return $session->customerInfo;
    }

    /**
     * Remove session customer info
     */
    protected function removeSessionCustomerInfo()
    {
        $this->getSession()->customerInfo = null;
        $this->saveSession();
    }

    /**
     * Set captcha to session
     * @param string $value
     */
    protected function saveSessionCaptcha($value)
    {
        $this->getSession()->captcha = trim($value);
        $this->saveSession();
    }

    /**
     * Save captcha position to session
     * @param int $position
     */
    protected function saveSessionCaptchaPos($position)
    {
        $this->getSession()->captchaPos = intval($position);
        $this->saveSession();
    }

    /**
     * Get captcha position from session
     * @return int
     */
    protected function getSessionCaptchaPos()
    {
        $session = $this->getSession();
        return $session->captchaPos;
    }

    /**
     * Validate captcha
     * @param string $input
     * @param boolean $textDecoration
     * @return bool
     */
    protected function validateSessionCaptcha($input, $textDecoration=true)
    {
        return $textDecoration ? ($input===$this->getSession()->captcha) : (strtolower($input)==strtolower($this->getSession()->captcha));
    }

    /**
     * Validate news letter registering time
     * @return bool
     */
    protected function validateNewsLetter()
    {
        $result = true;
        $validation = intval($this->getSession()->newsLetterValidation);
        $time = time();
        if ($validation && $time-$validation<=Application_Constant_Module_Default::NEWSLETTER_VALIDATION_TIME) {
            $result = false;
        } else {
            $this->getSession()->newsLetterValidation = $time;
            $this->saveSession();
        }
        return $result;
    }

    /**
     * Get current locale
     * @return string
     */
    protected function getCurrentLocale()
    {
        $session = $this->getSession();
        return isset($session->locale) ? $session->locale : 'vi';
    }

    /**
     * Set current locale
     * @param string $code
     */
    protected function setCurrentLocale($code)
    {
        $this->getSession()->locale = trim($code);
        $this->saveSession();
    }

    

    protected function renderCaptcha($position=-1, $onlyUpperCase=false)
    {
        $config = Zend_Registry::get('config');
        $captchaCode = strtolower($this->_helper->randomString(4));
        $value = $position == -1 ? $captchaCode : $captchaCode[$position] ;
        if ($onlyUpperCase) {
            $value = strtoupper($value);
            $captchaCode = strtoupper($captchaCode);
        }

        $this->saveSessionCaptcha($value);
        Application_Function_Image::renderCaptcha($captchaCode, $config->data->font, $position, 190, 40);
    }

    /**
     * Redirect to 404 page
     */
    protected function goto404()
    {
        $this->gotoUrl('404.html');
    }

    /**
     * Get current customer login
     * @return int
     */
    protected function getCustomerLoginId()
    {
        return $this->customerInfo ? $this->customerInfo->{DbTable_Customer::COL_CUSTOMER_ID} : 0;
    }

    /**
     * Validate password
     * @param string $pwd
     * @return bool
     */
    protected function validateCustomerLoginPassword($pwd)
    {
        $pwd = md5(trim($pwd));
        return $this->customerInfo ? $this->customerInfo->{DbTable_Customer::COL_CUSTOMER_PASSWORD}==$pwd : false;
    }

    /**
     * Set page without caching
     */
    protected function setNoCachePage()
    {
        setcookie('NO_CACHE','false');
    }

    /**
     * Get ID of email confirmation
     * @return int
     */
    protected function getIdEmailConfirmation()
    {
        return (date('H') >= 8 && date('H') <= 17) ? Application_Constant_Db_Site_Email::CONFIRMATION_IN_TIME : Application_Constant_Db_Site_Email::CONFIRMATION_OVER_TIME;
    }


}
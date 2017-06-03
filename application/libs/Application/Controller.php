<?php

/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/22/15
 * Time: 9:22 AM
 */
class Application_Controller extends Zend_Controller_Action
{
    /**
     * Get config object
     * @return Zend_Config
     */
    protected function getConfig()
    {
        return Zend_Registry::get('config');
    }

    /**
     * Redirect method
     * @param string $url
     * @param array $option
     */
    protected function gotoUrl($url, $option = array())
    {
        $this->_redirect($url, $option);
        $this->_helper->redirector->gotoUrl($url);
    }

    /**
     * Auto load resource Css & Js
     * @param array $resourceArr
     * @param string $type
     */
    protected function autoLoadResource($resourceArr, $type = 'js')
    {
        $time = time();
        $base_path = SYS_PATH . '/public/statics/asset/' . $this->getRequest()->getModuleName() . '/';

        $resourceArr[] = sprintf(
            'autoload/%s/%s.%s?m=%s',
            $type,
            $this->getRequest()->getControllerName(),
            $type,
            $time
        );
        $resourceArr[] = sprintf(
            'autoload/%s/%s/%s.%s?m=%s',
            $type,
            $this->getRequest()->getControllerName(),
            $this->getRequest()->getActionName(),
            $type,
            $time
        );

        foreach ($resourceArr as $resource) {
            $resourceInfo = explode('?', $resource);
            $resourceFile = $resourceInfo[0];
            if (file_exists($base_path . $resourceFile)) {
                if ($type == 'js') {
                    $this->view->headScript()->appendFile($this->generatePathStatic($resource));
                } else {
                    $this->view->headLink()->appendStylesheet($this->generatePathStatic($resource));
                }
            }
        }
    }

    /**
     * Generate static path
     * @param string $resource
     * @return string
     */
    protected function generatePathStatic($resource)
    {
        $path = '';
        switch (MODULE_NAME) {
            case 'mobile':
                $path = HOST_STATIC_MOBILE;
                break;
            case 'default':
                $path = HOST_STATIC_DEFAULT;
                break;
            default:
                break;
        }
        return $path . $resource;
    }

    /**
     * Disable layout & stop rendering
     */
    protected function noRender()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->noLayout();
    }

    /**
     * Disable layout
     */
    protected function noLayout()
    {
        $this->_helper->layout->disableLayout();
    }

    /**
     * Load gird data with pagination
     * @param Zend_Db_Select $select
     * @param int $limit
     */
    protected function loadGird($select, $limit = Application_Constant_Module_Admin::LIMIT)
    {
        $page = $this->getRequest()->getParam('page');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');
        $pagination = Zend_Paginator::factory($select);
        $pagination->setCurrentPageNumber($page);
        $pagination->setDefaultItemCountPerPage($limit);

        $this->view->assign('pagination', $pagination);
    }


    /**
     * Return upload path
     * @return string
     */
    protected function getUploadPath()
    {
        return SYS_PATH . '/public/upload';
    }

    /**
     * Upload file and return new file name
     * @param string $component
     * @param string $elementName
     * @return mixed|null
     */
    protected function uploadImage($component, $elementName)
    {
        $image = null;
        if (isset($_FILES[$elementName]) && $_FILES[$elementName]['name']) {
            $folder = $this->getUploadPath() . '/' . $component;
            if (!is_dir($folder)) {
                mkdir($folder);
            }
            $folder = $folder . '/' . date('Y');
            if (!is_dir($folder)) {
                mkdir($folder);
            }
            $folder = $folder . '/' . date('m');
            if (!is_dir($folder)) {
                mkdir($folder);
            }
            $folder = $folder . '/' . date('d');
            if (!is_dir($folder)) {
                mkdir($folder);
            }

            $file = $_FILES[$elementName];
            $imagePath = sprintf('%s/%s', $folder, $this->_helper->generateImageName($file['name']));
            if (move_uploaded_file($file['tmp_name'], $imagePath)) {
                $image = str_replace($this->getUploadPath(), '', $imagePath);
            }

        }
        return $image;
    }

    /**
     * Upload multi image
     * @param string $component
     * @param string $elementName
     * @return array
     */
    public function uploadMultiImage($component, $elementName)
    {
        $image = array();
        if (isset($_FILES[$elementName]) && $_FILES[$elementName]['name']) {
            foreach ($_FILES[$elementName]['name'] as $index => $element) {
                $folder = $this->getUploadPath() . '/' . $component;
                if (!is_dir($folder)) {
                    mkdir($folder);
                }
                $folder = $folder . '/' . date('Y');
                if (!is_dir($folder)) {
                    mkdir($folder);
                }
                $folder = $folder . '/' . date('m');
                if (!is_dir($folder)) {
                    mkdir($folder);
                }
                $folder = $folder . '/' . date('d');
                if (!is_dir($folder)) {
                    mkdir($folder);
                }

                $file = $_FILES[$elementName];
                $imagePath = sprintf('%s/%s', $folder, $this->_helper->generateImageName($element));
                if (move_uploaded_file($file['tmp_name'][$index], $imagePath)) {
                    $image[] = str_replace($this->getUploadPath(), '', $imagePath);
                }
            }


        }
        return $image;

    }

    /**
     * Get session Id
     * @return string
     */
    protected function getSessionId()
    {
        if (!Zend_Session::isStarted()) {
            Zend_Session::start();
        }
        return Zend_Session::getId();
    }

    protected function cleanUpSessionId()
    {
        Zend_Session::regenerateId();
    }


    /**
     * Generate customer information
     * @param int $customerId
     * @param null $password
     * @param array $data
     * @return array
     */
    protected function generateCustomerInfo($customerId, $password = null, $data = array())
    {
        $result = array();
        $customerInfo = Model_Customer::getInstance()->getById($customerId);
        if ($customerInfo) {
            $provinceInfo = Model_RegionProvince::getInstance()->getById($customerInfo->{DbTable_Customer::COL_CUSTOMER_PROVINCE});
            $districtInfo = Model_RegionDistrict::getInstance()->getById($customerInfo->{DbTable_Customer::COL_CUSTOMER_DISTRICT});
            $result[Application_Constant_Global_Variable_Email::CUSTOMER_NAME] = $customerInfo->{DbTable_Customer::COL_CUSTOMER_NAME};
            $result[Application_Constant_Global_Variable_Email::CUSTOMER_EMAIL] = $customerInfo->{DbTable_Customer::COL_CUSTOMER_EMAIL};
            $result[Application_Constant_Global_Variable_Email::CUSTOMER_PHONE] = $customerInfo->{DbTable_Customer::COL_CUSTOMER_PHONE};
            $result[Application_Constant_Global_Variable_Email::CUSTOMER_ADDRESS] = sprintf(
                '%s %s,%s',
                $customerInfo->{DbTable_Customer::COL_CUSTOMER_ADDRESS},
                $provinceInfo[DbTable_Region_Province::COL_REGION_PROVINCE_REAL_NAME],
                $districtInfo[DbTable_Region_District::COL_REGION_DISTRICT_NAME]
            );
            $result[Application_Constant_Global_Variable_Email::CUSTOMER_PASSWORD] = trim($password);
            if ($data) {
                foreach ($data as $key => $value) {
                    $result[$key] = $value;
                }
            }
        }
        return $result;
    }


    /**
     * Do send email
     * @param string $email
     * @param string $fullName
     * @param string $subject
     * @param string $body
     */
    protected function doSendMail($email, $fullName, $subject, $body)
    {
        $mail = new Zend_Mail('UTF-8');
        $mail->setBodyHtml($body);
        $mail->setFrom(
            Application_Constant_Global_Email::EMAIL,
            Application_Constant_Global_Email::SENDER
        );
        $mail->addTo($email, $fullName);
        $mail->setSubject(
            sprintf('[Xome] %s', $subject)
        );

        $config = $this->getConfig();
        if ($config->env->name == 'live') {
            $transport = new Zend_Mail_Transport_Smtp($config->smtp->host, $config->smtp->config->toArray());
            $mail->send($transport);
        } else {
            $mail->send();
        }

    }

    /**
     * Send SMS
     * @param string $phone
     * @param string $message
     * @param int|string $requestId
     * @return mixed
     */
    protected function doSendSms($phone, $message, $requestId)
    {
        $config = Zend_Registry::get('config');
        $response = '';
        if ($config->env->name != 'dev') {
            $configSettingInfo = Model_ConfigSetting::getInstance()->getById(Application_Constant_Db_Config_Setting::SMS_PROVIDER);
            if ($configSettingInfo) {
                if ($configSettingInfo[DbTable_Config_Setting::COL_CONFIG_SETTING_VALUE] == Application_Constant_Global_SmsProvider::GOMOBI) {
                    $client = new Zend_Soap_Client(
                        'http://sms.gateway.gomobi.vn:7777/SMS_API_Outside/WS_Send_MT_Spam?WSDL',
                        array(
                            'soap_version' => SOAP_1_1,
                            'encoding' => 'UTF-8'
                        )
                    );

                    $request = new stdClass();
                    $request->Phone = $this->_helper->formatPhoneNumber($phone);
                    $request->WAPTitle = $config->sms->gomobi->WAPTitle;
                    $request->Message = trim($message);
                    $request->MsgType = intval($config->sms->gomobi->MsgType);
                    $request->SendingTime = '';
                    $request->PartnerID = intval($config->soap->id);
                    $request->RequestID = $requestId;
                    $request->TokenKey = md5($request->Phone . $request->WAPTitle . $request->Message . $request->MsgType . $request->SendingTime . $request->PartnerID . $request->RequestID . $config->soap->key);
                    $response = $client->Send_MT_Spam_V2($request);

                } elseif ($configSettingInfo[DbTable_Config_Setting::COL_CONFIG_SETTING_VALUE] == Application_Constant_Global_SmsProvider::VIETGUYS) {
                    $client = new Zend_Soap_Client(
                        'http://cloudsms.vietguys.biz:8088/webservices/sendsmsw.php?wsdl',
                        array(
                            'soap_version' => SOAP_1_1,
                            'encoding' => 'UTF-8'
                        )
                    );

                    $request = new stdClass();
                    $request->phone = $this->_helper->formatPhoneNumber($phone);
                    $request->passcode = $config->sms->vietguys->passcode;
                    $request->sms = trim($message);
                    $request->account = $config->sms->vietguys->account;
                    $request->password = '';
                    $request->contenttype = '';
                    $request->messagetype = '';
                    $request->messageid = '';
                    $request->transactionid = '';
                    $request->service_id = $config->sms->vietguys->service_id;
                    $request->json = '';
                    $response = $client->send($request);
                }
            }
        }
        return $response;
    }

    /**
     * Generate output excel file
     * @param array $data
     * @param string $fileName
     * @param boolean $heading
     */
    protected function generateExcelResponse($data, $fileName = 'excel', $heading = true)
    {
        if ($data) {
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getActiveSheet()->setTitle('Xomtro.com');

            if ($heading) {
                $headings = array_keys(current($data));
                $rowNumber = 1;
                $col = 'A';
                foreach ($headings as $heading) {
                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $heading);
                    $col++;
                }
            }

            $rowNumber = 2;
            foreach ($data as $item) {
                $col = 'A';
                foreach ($item as $value) {
                    $objPHPExcel->getActiveSheet()->setCellValue($col++ . $rowNumber, $value);
                }
                $rowNumber++;
            }
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            header('Content-Type: application/vnd.ms-excel');
            header(
                sprintf('Content-Disposition: attachment;filename="%s.%s.xls"', $fileName, date('YmdHis'))
            );
            header('Cache-Control: max-age=0');
            $objWriter->save('php://output');
        }
    }

    /**
     * Set cookie value
     * @param string $key
     * @param mixed $value
     */
    protected function setCookie($key, $value)
    {
        setcookie($key, $value, time() + (30 * 24 * 3600), '/', $_SERVER['HTTP_HOST']);
    }

    /**
     * Retrieve cookie value
     * @param string $key
     * @return mixed
     */
    protected function getCookie($key)
    {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
    }

    /**
     * Clean up cookie value
     * @param string $key
     */
    protected function cleanUpCookie($key)
    {
        unset($_COOKIE[$key]);
        setcookie($key, '', time() - 3600, '/', $_SERVER['HTTP_HOST']);
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: duyca
 * Date: 8/12/2015
 * Time: 7:13 PM
 */
class Application_Controller_Ws extends Application_Controller
{
    /**
     * @var array
     */
    private $_paramInfo;

    protected $wsInfo;

    /**
     * @var Zend_Config_Ini
     */
    protected $config;

    public function init()
    {
        $this->config = Zend_Registry::get('config');
    }

    public function preDispatch()
    {
        $controller = $this->getRequest()->getControllerName();
        $action = $this->getRequest()->getActionName();
        $key = $this->getRequest()->getParam('key');
        $param = $this->getRequest()->getParam('data');
        $code = $this->getRequest()->getParam('code');
        $partnerData = Ws_Model_Partner::getInstance()->searchByKey($key);
        if ($partnerData) {
            #Validate secret key
            $codeString = '';
            if ($param) {
                $paramData = json_decode(trim($param), true);
                if ($paramData && is_array($paramData)) {
                    ksort($paramData);
                    foreach ($paramData as $value) {
                        $codeString = $codeString . $value;
                    }
                }
                $this->setWsParamInfo($paramData);
            }
            $codeString = md5($codeString . $partnerData[DbTable_Partner::COL_PARTNER_SECRET_KEY]);
            #Validate secret key

            if ($codeString == $code) {
                #White list IP
                $whiteListIP = Ws_Model_PartnerWhitelist::getInstance()->getByPartnerId(
                    $partnerData[DbTable_Partner::COL_PARTNER_ID]
                );
                $ip = $_SERVER['REMOTE_ADDR'];
                #White list IP

                if ($whiteListIP && !in_array($ip, $whiteListIP)) {
                    $this->_responseAccessDenied(Application_Constant_Db_Webservice_Error::WHITE_LIST_IP_INVALID);
                } else {
                    $partnerWebserviceData = Ws_Model_PartnerWebservice::getInstance()->searchByPartnerId($partnerData[DbTable_Partner::COL_PARTNER_ID]);
                    if ($partnerWebserviceData) {
                        $webserviceData = Ws_Model_PartnerWebservice::getInstance()->isIncluded($partnerWebserviceData, $controller, $action);
                        if ($webserviceData) {
                            Ws_Model_WebserviceLog::getInstance()->insert(
                                $webserviceData[DbTable_Webservice::COL_WEBSERVICE_ID],
                                $partnerData[DbTable_Partner::COL_PARTNER_ID],
                                $param
                            );
                        } else {
                            $this->_responseAccessDenied(Application_Constant_Db_Webservice_Error::PARTNER_PRIVILEGE_INVALID);
                        }
                    } else {
                        $this->_responseAccessDenied(Application_Constant_Db_Webservice_Error::PARTNER_PRIVILEGE_INVALID);
                    }
                }
            } else {
                $this->_responseAccessDenied(Application_Constant_Db_Webservice_Error::SECRET_KEY_INVALID);
            }
        } else {
            $this->_responseAccessDenied(Application_Constant_Db_Webservice_Error::API_KEY_INVALID);
        }
    }

    public function postDispatch()
    {
        $this->noRender();
    }

    private function _responseAccessDenied($errorCode)
    {
        $this->responseWs($errorCode, null);
    }

    protected function setWsParamInfo($data)
    {
        $this->_paramInfo = $data;
    }

    /**
     * Get Ws parameter
     * @param string $key
     * @param null $default
     * @return null|string|int|float
     */
    protected function getWsParamInfo($key, $default=null)
    {
        return isset($this->_paramInfo[$key]) ? $this->_paramInfo[$key] : $default;
    }

    /**
     * Response API result
     * @param int $errorCode
     * @param array|null $data
     */
    protected function responseWs($errorCode, $data)
    {
        $errorData = Ws_Model_WebserviceError::getInstance()->getInfoById($errorCode);
        $this->_helper->json(
            array(
                Application_Constant_Module_Ws::RESPONSE_KEY => $errorCode,
                Application_Constant_Module_Ws::RESPONSE_MESSAGE_KEY => $errorData[DbTable_Webservice_Error::COL_WEBSERVICE_ERROR_MESSAGE],
                Application_Constant_Module_Ws::RESPONSE_DATA => $data
            )
        );
    }

    /**
     * Validate voucher information
     * @param Zend_Db_Table_Rowset_Abstract $voucherInfo
     * @param $seat_qty
     * @param $agency_id
     * @return int
     */
    protected function validateVoucherInfo($voucherInfo, $seat_qty, $agency_id)
    {
        if (!$voucherInfo) {
            $errorCode = Application_Constant_Db_Webservice_Error::VOUCHER_CODE_INVALID;
        } else {
            $errorCode = 0;
            $seatQtyMin = (int)$voucherInfo->{DbTable_Voucher::COL_VOUCHER_SEAT_QTY_MIN};
            if ($seatQtyMin > 0 && $seat_qty < $seatQtyMin) {
                $errorCode = Application_Constant_Db_Webservice_Error::AMOUNT_TRIP_SEAT_INVALID;
            } else {
                $seatQtyMax = (int)$voucherInfo->{DbTable_Voucher::COL_VOUCHER_SEAT_QTY_MAX};
                if ($seatQtyMax > 0 && $seat_qty > $seatQtyMax) {
                    $errorCode = Application_Constant_Db_Webservice_Error::AMOUNT_TRIP_SEAT_INVALID;
                } else {
                    $qty = (int)$voucherInfo->{DbTable_Voucher::COL_VOUCHER_QTY};
                    $timeUsed = Ws_Model_Voucher::getInstance()->countTimesUsed($voucherInfo->{DbTable_Voucher::COL_VOUCHER_CODE});
                    if ($timeUsed < $qty) {
                        $voucherAgency = Ws_Model_VoucherAgency::getInstance()->searchQuery(
                            $voucherInfo->{DbTable_Voucher::COL_VOUCHER_ID},
                            $agency_id
                        );
                        if (!$voucherAgency->toArray()) {
                            $errorCode = Application_Constant_Db_Webservice_Error::VOUCHER_NOT_AVAILABLE_AGENCY;
                        }
                    } else {
                        $errorCode = Application_Constant_Db_Webservice_Error::VOUCHER_USE_OVER;
                    }
                }
            }
        }
        return $errorCode;
    }
}
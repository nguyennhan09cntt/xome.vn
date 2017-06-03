<?php
/**
 * Created by PhpStorm.
 * User: duyca
 * Date: 8/12/2015
 * Time: 9:01 PM
 */
class Application_Cache_Ws extends Application_Cache
{
    public function partnerInfo($key)
    {
        return Application_Constant_Cache::PARTNER_INFO . $key;
    }

    public function resetPartnerInfo($partnerKey)
    {
        $this->remove($this->partnerInfo($partnerKey));
    }

    public function partnerServiceInfo($fk_partner)
    {
        return Application_Constant_Cache::PARTNER_SERVICE_INFO . $fk_partner;
    }

    public function resetPartnerServiceInfo($fk_partner)
    {
        $this->remove($this->partnerServiceInfo($fk_partner));
    }

    public function webserviceError()
    {
        return Application_Constant_Cache::WEBSERVICE_ERROR;
    }

    public function partnerWhiteList($partnerId)
    {
        return Application_Constant_Cache::PARTNER_WHITE_LIST . $partnerId;
    }

    public function resetPartnerWhiteList($partnerId)
    {
        $this->remove($this->partnerWhiteList($partnerId));
    }
}
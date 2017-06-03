<?php
/**
 * Created by PhpStorm.
 * User: duyca
 * Date: 12/5/2015
 * Time: 3:02 PM
 */
class Application_Function_Notify123pay
{
    static public function validateNotify123Pay($mTransactionID, $bankCode, $transactionStatus, $ts, $checksum)
    {
        $sMySecretkey = 'MIKEY';//key use to hash checksum that will be provided by 123Pay
        $sRawMyCheckSum = $mTransactionID.$bankCode.$transactionStatus.$ts.$sMySecretkey;
        $sMyCheckSum = sha1($sRawMyCheckSum);
        $result = false;
        if($sMyCheckSum == $checksum)
        {
            $result = true;
        }
        return $result;
    }

    static public function response($mTransactionID, $returnCode, $key)
    {
        $ts = time();
        $sRawMyCheckSum = $mTransactionID.$returnCode.$ts.$key;
        $checksum = sha1($sRawMyCheckSum);
        $aData = array(
            'mTransactionID' => $mTransactionID,
            'returnCode' => $returnCode,
            'ts' => time(),
            'checksum' => $checksum
        );
        echo json_encode($aData);
        exit;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: duyca
 * Date: 7/19/2015
 * Time: 11:26 AM
 */
interface Application_Constant_Db_Config_Setting
{
    /**
     * @var : int
     * Agency xac nhan ve
     */
    const CONFIRM_AGENCY = 1;

    /**
     * @var : int
     * Sms provider
     */
    const SMS_PROVIDER = 2;

    /**
     * @var : int
     * Time to release holding ticket ( seconds )
     */
    const TIME_RELEASE_HOLDING_TICKET = 3;

    /**
     * @var : int
     * Time for pickup preparation for next day
     */
    const PICKUP_ESTIMATION = 4;

    /**
     * @var : int
     */
    const REF_BONUS = 5;

    /**
     * @var : int
     * Ref value ( percent )
     */
    const REF_VALUE = 6;

    /**
     * @var : int
     * Voucher co duoc su dung chung voi Ve Gia Re ( 1=yes; 0=no )
     */
    const VOUCHER_PROMOTION = 7;

    /**
     * @var : int
     * Chi phi hoan tra ve ( % )
     */
    const REFUND_COST = 8;

    /**
     * @var : int
     * thời gian tạm giữ vé thu hộ ( seconds )
     */
    const TIME_RELEASE_COLLECT_ON_BEHALF = 9;

    /**
     * @var : int
     * Thoi gian cho lan binh luan
     */
    const TIME_COMMENT = 10;

    /**
     * @var : int
     * Thoi gian cho lan danh gia tiep theo
     */
    const TIME_RATE = 11;

    /**
     * @var : int
     * Thoi gian cho lan goi y tiep theo
     */
    const TIME_SUGGEST = 12;

    /**
     * @var : int
     * Thoi gian cho lan binh luan chuyen xe tiep
     */
    const TIME_COMMENT_COMPANY_TRIP = 13;
}
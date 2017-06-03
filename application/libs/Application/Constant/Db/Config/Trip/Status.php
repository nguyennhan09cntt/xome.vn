<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/5/15
 * Time: 3:44 PM
 */
interface Application_Constant_Db_Config_Trip_Status
{
    /**
     * @var : string
     * Khoi tao
     */
    const INIT = 1;

    /**
     * @var string
     * Chua ban ve
     */
    const HAVE_NOT_SOLD = 2;

    /**
     * @var string
     * Dang ban ve
     */
    const SELLING = 3;

    /**
     * @var string
     * Tam dung ban ve
     */
    const PAUSE = 4;

    /**
     * @var string
     * Ngung ban ve
     */
    const STOP_SELLING = 5;

    /**
     * @var string
     * Chuan bi khoi hanh
     */
    const READY = 6;

    /**
     * @var string
     * Dang di chuyen
     */
    const MOVING = 7;

    /**
     * @var string
     * Gap su co
     */
    const ISSUE = 8;

    /**
     * @var string
     * Cap nhat thong tin
     */
    const UPDATING = 9;

    /**
     * @var string
     * Ve ben
     */
    const COMEBACK = 10;

    /**
     * @var string
     * Ket thuc chuyen di
     */
    const CLOSED = 11;
}
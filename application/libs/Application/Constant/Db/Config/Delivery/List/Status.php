<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 11/2/15
 * Time: 12:41 PM
 */
interface Application_Constant_Db_Config_Delivery_List_Status
{
    /**
     * Khoi tao
     * @var int
     */
    const INIT = 1;

    /**
     * Da in
     * @var int
     */
    const PRINTED = 2;

    /**
     * Huy
     * @var int
     */
    const CANCELLED = 3;
}
<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 1/30/15
 * Time: 11:19 AM
 */
interface Application_Constant_Db_Config_Active
{
    /**
     * @var int
     */
    const INACTIVE = 0;

    /**
     * @var int
     */
    const ACTIVE = 1;

    /**
     * @var int
     */
    const DELETED = 2;

    /**
     * @var int
     */
    const EXPIRED = 3;

    /**
     * @var int
     */
    const REPLACED = 4;

    /**
     * @var int
     */
    const PENDING = 5;

    /**
     * @var int
     */
    const FINISHED = 6;

    /**
     * @var int
     */
    const APPROVED = 7;

    /**
     * @var int
     */
    const DISAPPROVE = 8;

    /**
     * @var int
     */
    const FAILED = 9;

    /**
     * @var int
     */
    const SUCCESSFUL = 10;

    /**
     * @var int
     */
    const IMPORT = 11;
}
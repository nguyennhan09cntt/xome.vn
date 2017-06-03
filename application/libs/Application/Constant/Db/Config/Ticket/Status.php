<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/5/15
 * Time: 3:55 PM
 */
interface Application_Constant_Db_Config_Ticket_Status
{
    /**
     * @var int
     * Khoi tao
     */
    const INIT = 1;

    /**
     * @var int
     * Chua ban
     */
    const HAVE_NOT_SOLD = 2;

    /**
     * @var int
     * Khong ban
     */
    const UNSOLD = 3;

    /**
     * @var int
     * Tam giu
     */
    const HOLDING = 4;

    /**
     * @var int
     * Da duoc dat
     */
    const ORDERED = 5;

    /**
     * @var int
     * Da duoc ban ( da thanh toan )
     */
    const SOLD = 6;

    /**
     * @var int
     * Len xe
     */
    const ON_BOARD = 7;

    /**
     * @var int
     * Xuong xe
     */
    const ARRIVED = 8;

    /**
     * @var int
     * Ket thuc
     */
    const FINISHED = 9;

    /**
     * @var int
     * Tra ve
     */
    const REFUND = 10;

    /**
     * @var int
     * Huy
     */
    const CANCELLED = 11;

    /**
     * Da xac nhan voi khach hang
     * @var int
     */
    const CONFIRMED_CUSTOMER = 12;

    /**
     * Da xac nhan voi nha xe
     * @var int
     */
    const CONFIRMED_COMPANY = 13;

    /**
     * Da nhan ve ve Pasoto
     * @var int
     */
    const INBOUNDED = 14;

    /**
     * Pasoto da kiem tra & chuan bi giao cho khach
     * @var int
     */
    const WAITING_FOR_DELIVERY = 15;

    /**
     * Ve da duoc giao cho nhan vien giao nhan
     * @var int
     */
    const IN_DELIVERED = 16;

    /**
     * Da giao ve thanh cong
     * @var int
     */
    const DELIVERY_SUCCESSFUL = 17;

    /**
     * Giao ve that bai
     * @var int
     */
    const DELIVERY_FAILED = 18;

    /**
     * Huy ve - truong hop ve da inbound
     * @var int
     */
    const CANCELLED_HAVING_TICKET = 19;

    /**
     * Huy ve - truong hop ve chua inbound
     * @var int
     */
    const CANCELLED_NO_TICKET = 20;

    /**
     * Ve khong the pickup - Nha xe het ve
     * @var int
     */
    const UNABLE_INBOUND = 21;

    /**
     * Ve khong the giao cho khach hang
     * @var int
     */
    const UNABLE_DELIVER = 22;

    /**
     * Ve huy, da tra lai cho nha xe
     * @var int
     */
    const PAID_TO_COMPANY = 23;

    /**
     * Ve chuyen giao cho khach hang khac
     * @var int
     */
    const TRANSFERRED = 24;

    /**
     * Ve cho pickup - theo thoi gian bat dau ban ve cua nha xe
     * @var int
     */
    const WAITING_FOR_PICKUP = 25;

    /**
     * Ve dang lay
     * @var int
     */
    const IN_PICKING = 27;

    /**
     * Ve duoc giao viec - giao ve
     * @var int
     */
    const ASSIGNED_FOR_DELIVERY = 26;

    /**
     * Cho thu ho
     * @var int
     */
    const WAITING_COLLECT_ON_BEHALF = 28;

    /**
     * Cho ngan hang xu ly
     * @var int
     */
    const WAITING_PROCESS_BANKING = 29;

    /**
     * Giao dich khong thanh cong
     * @var int
     */
    const TRANSACTION_FAILED = 30;
}
<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/11/15
 * Time: 4:12 PM
 */
interface Application_MassUpload_Excel_Constant_AdminCompanyTrip
{
    /**
     * @var string
     */
    const COL_IS_POUNDAGE = 'isPoundage';
    /**
     * @var string
     */
    const MSG_VEHICLE_NULL = 'Vui lòng nhập biển số xe';

    /**
     * @var string
     */
    const MSG_VEHICLE_INVALID = 'Biển số xe không hợp lệ - không tìm thấy trong dữ liệu nhà xe';

    /**
     * @var string
     */
    const MSG_DRIVER_ID_NUMBER_NULL = 'Vui lòng nhập CMND tài xế';

    /**
     * @var string
     */
    const MSG_DRIVER_ID_NUMBER_INVALID = 'CMND tài xế không tồn tại';

    /**
     * @var string
     */
    const MSG_DRIVER_NOT_WORKING_COMPANY = 'Tài xế này không làm việc tại nhà xe';

    /**
     * @var string
     */
    const MSG_ROUTE_CODE_NULL = 'Vui lòng nhập mã hành trình';

    /**
     * @var string
     */
    const MSG_ROUTE_CODE_INVALID = 'Mã hành trình không tồn tại';

    /**
     * @var string
     */
    const MSG_ROUTE_NOT_BELONG_COMPANY = 'Mã hành trình này không thuộc nhà xe';

    /**
     * @var string
     */
    const MSG_ORIGINAL_PRICE_NULL = 'Vui lòng nhập giá chính thức';

    /**
     * @var string
     */
    const MSG_UNIT_PRICE_NULL = 'Vui lòng nhập giá mua';

    /**
     * @var string
     */
    const MSG_START_TIME_NULL = 'Vui lòng nhập thời điểm khởi hành';

    /**
     * @var string
     */
    const MSG_DATE_NULL = 'Vui lòng nhập ngày khởi hành';

    /**
     * @var string
     */
    const MSG_ESTIMATION_NULL = 'Vui lòng nhập thời gian chạy';

    /**
     * @var string
     */
    const MSG_END_DATE_NULL = 'Vui lòng nhập ngày kết thúc';


}
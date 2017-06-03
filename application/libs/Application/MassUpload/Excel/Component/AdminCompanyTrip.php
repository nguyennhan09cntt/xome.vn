<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/11/15
 * Time: 3:58 PM
 */
class Application_MassUpload_Excel_Component_AdminCompanyTrip extends Application_MassUpload_Excel_Abstract
{
    /**
     * @var int
     */
    private $_companyId;

    /**
     * Set company ID
     * @param int $value
     */
    public function setCompanyId($value)
    {
        $this->_companyId = $value;
    }

    /**
     * Get company ID
     * @return int
     */
    public function getCompanyId()
    {
        return $this->_companyId;
    }

    public function getHeader()
    {
        return array(
            DbTable_Company_Vehicle::COL_COMPANY_VEHICLE_NAME,
            DbTable_Driver::COL_DRIVER_ID_NUMBER,
            DbTable_Company_Route::COL_COMPANY_ROUTE_ID,
            DbTable_Company_Trip::COL_COMPANY_TRIP_ORIGINAL_PRICE,
            DbTable_Company_Trip::COL_COMPANY_TRIP_START_TIME,
            DbTable_Company_Trip::COL_COMPANY_TRIP_ESTIMATION,
            DbTable_Company_Trip::COL_COMPANY_TRIP_DATE,
            DbTable_Company_Trip::COL_COMPANY_TRIP_PROMOTION_RANGE,
            DbTable_Company_Trip::COL_COMPANY_TRIP_PROMOTION_PRICE,
            DbTable_Company_Trip::COL_COMPANY_TRIP_PROMOTION_STARTED_AT,
            Application_MassUpload_Excel_Constant_AdminCompanyTrip::COL_IS_POUNDAGE,
        );
    }

    public function getFileId()
    {
        return 'excel_file';
    }

    public function validateRow($row)
    {
        $message = array();
        if (empty($row[DbTable_Company_Vehicle::COL_COMPANY_VEHICLE_NAME])) {
            $message[] = Application_MassUpload_Excel_Constant_AdminCompanyTrip::MSG_VEHICLE_NULL;
        } else {
            $data = Admin_Model_CompanyVehicle::getInstance()->search(
                0,
                $this->getCompanyId(),
                $row[DbTable_Company_Vehicle::COL_COMPANY_VEHICLE_NAME],
                Application_Constant_Db_Config_Active::ACTIVE
            );
            if (!$data) {
                $message[] = Application_MassUpload_Excel_Constant_AdminCompanyTrip::MSG_VEHICLE_INVALID;
            }
        }
        if (empty($row[DbTable_Driver::COL_DRIVER_ID_NUMBER])) {
            $message[] = Application_MassUpload_Excel_Constant_AdminCompanyTrip::MSG_DRIVER_ID_NUMBER_NULL;
        } else {
            $data = Admin_Model_Driver::getInstance()->searchByIdNumber(
                $row[DbTable_Driver::COL_DRIVER_ID_NUMBER]
            );
            if (!$data) {
                $message[] = Application_MassUpload_Excel_Constant_AdminCompanyTrip::MSG_DRIVER_ID_NUMBER_INVALID;
            } else {
                $driverData = Admin_Model_CompanyDriver::getInstance()->search(
                    $this->getCompanyId(),
                    $data->{DbTable_Driver::COL_DRIVER_ID},
                    Application_Constant_Db_Config_Active::ACTIVE
                );
                if (!$driverData) {
                    $message[] = Application_MassUpload_Excel_Constant_AdminCompanyTrip::MSG_DRIVER_NOT_WORKING_COMPANY;
                }
            }
        }
        if (empty($row[DbTable_Company_Route::COL_COMPANY_ROUTE_ID])) {
            $message[] = Application_MassUpload_Excel_Constant_AdminCompanyTrip::MSG_ROUTE_CODE_NULL;
        } else {
            $id = Admin_Model_CompanyRoute::getInstance()->decode($row[DbTable_Company_Route::COL_COMPANY_ROUTE_ID]);
            if (!$id) {
                $message[] = Application_MassUpload_Excel_Constant_AdminCompanyTrip::MSG_ROUTE_CODE_INVALID;
            } else {
                $data = Admin_Model_CompanyRoute::getInstance()->getById($id);
                if (!$data) {
                    $message[] = Application_MassUpload_Excel_Constant_AdminCompanyTrip::MSG_ROUTE_CODE_INVALID;
                } elseif ($data->current()->{DbTable_Company_Route::COL_FK_COMPANY}!=$this->getCompanyId()) {
                    $message[] = Application_MassUpload_Excel_Constant_AdminCompanyTrip::MSG_ROUTE_NOT_BELONG_COMPANY;
                }
            }
        }
        if (empty($row[DbTable_Company_Trip::COL_COMPANY_TRIP_ORIGINAL_PRICE])) {
            $message[] = Application_MassUpload_Excel_Constant_AdminCompanyTrip::MSG_ORIGINAL_PRICE_NULL;
        }
        if (empty($row[DbTable_Company_Trip::COL_COMPANY_TRIP_START_TIME])) {
            $message[] = Application_MassUpload_Excel_Constant_AdminCompanyTrip::MSG_START_TIME_NULL;
        }
        if (empty($row[DbTable_Company_Trip::COL_COMPANY_TRIP_ESTIMATION])) {
            $message[] = Application_MassUpload_Excel_Constant_AdminCompanyTrip::MSG_ESTIMATION_NULL;
        }
        if (empty($row[DbTable_Company_Trip::COL_COMPANY_TRIP_DATE])) {
            $message[] = Application_MassUpload_Excel_Constant_AdminCompanyTrip::MSG_DATE_NULL;
        }
        return count($message) ? implode(', ', $message) : null;
    }

    public function processRow($row)
    {
        $vehicleInfo = Admin_Model_CompanyVehicle::getInstance()->search(
            0,
            $this->getCompanyId(),
            $row[DbTable_Company_Vehicle::COL_COMPANY_VEHICLE_NAME],
            Application_Constant_Db_Config_Active::ACTIVE
        );

        $driverInfo = Admin_Model_Driver::getInstance()->searchByIdNumber(
            $row[DbTable_Driver::COL_DRIVER_ID_NUMBER]
        );

        $routeInfo = Admin_Model_CompanyRoute::getInstance()->getById(
            Admin_Model_CompanyRoute::getInstance()->decode($row[DbTable_Company_Route::COL_COMPANY_ROUTE_ID])
        );

        $message = Admin_Model_CompanyTrip::getInstance()->insert(
            $this->getCompanyId(),
            $vehicleInfo->current()->{DbTable_Company_Vehicle::COL_COMPANY_VEHICLE_ID},
            $driverInfo->{DbTable_Driver::COL_DRIVER_ID},
            $routeInfo->current()->{DbTable_Company_Route::COL_COMPANY_ROUTE_ID},
            $row[DbTable_Company_Trip::COL_COMPANY_TRIP_START_TIME],
            $row[DbTable_Company_Trip::COL_COMPANY_TRIP_ESTIMATION],
            $row[DbTable_Company_Trip::COL_COMPANY_TRIP_DATE],
            Application_Constant_Db_Company_Trip::SEAT_BOOKING,
            $row[DbTable_Company_Trip::COL_COMPANY_TRIP_ORIGINAL_PRICE],
            $row[DbTable_Company_Trip::COL_COMPANY_TRIP_PROMOTION_RANGE],
            $row[DbTable_Company_Trip::COL_COMPANY_TRIP_PROMOTION_PRICE],
            $row[DbTable_Company_Trip::COL_COMPANY_TRIP_PROMOTION_STARTED_AT],
            $row[Application_MassUpload_Excel_Constant_AdminCompanyTrip::COL_IS_POUNDAGE]
        );
        return $message;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: duyca
 * Date: 7/18/2015
 * Time: 1:25 PM
 */
class Application_MassUpload_Excel_Component_AdminCompanyTripSeatCode extends Application_MassUpload_Excel_Abstract
{
    /**
     * @var int
     */
    private $_companyTripId;

    /**
     * Set Company Trip ID
     * @param int $value
     */
    public function setCompanyTripId($value)
    {
        $this->_companyTripId = $value;
    }

    /**
     * Get Company Trip Id
     * @return int
     */
    public function getCompanyTripId()
    {
        return $this->_companyTripId;
    }

    public function getHeader()
    {
        return array(
            DbTable_Company_Vehicle_Model_Seat::COL_COMPANY_VEHICLE_MODEL_SEAT_LABEL,
            DbTable_Company_Trip_Seat::COL_COMPANY_TRIP_SEAT_CODE
        );
    }

    public function getFileId()
    {
        return 'excel_file';
    }

    public function validateRow($row)
    {
        $message = array();
        if (empty($row[DbTable_Company_Vehicle_Model_Seat::COL_COMPANY_VEHICLE_MODEL_SEAT_LABEL])) {
            $message[] = Application_MassUpload_Excel_Constant_AdminCompanyTripSeatCode::MSG_LABLE_NULL;
        } else {
            $data = Admin_Model_CompanyVehicleModelSeat::getInstance()->search(
                $this->getCompanyTripId(),
                $row[DbTable_Company_Vehicle_Model_Seat::COL_COMPANY_VEHICLE_MODEL_SEAT_LABEL],
                Application_Constant_Db_Config_Active::ACTIVE
            );
            if (!$data) {
                $message[] = Application_MassUpload_Excel_Constant_AdminCompanyTripSeatCode::MSG_LABEL_INVALID;
            }
        }
        if (empty($row[DbTable_Company_Trip_Seat::COL_COMPANY_TRIP_SEAT_CODE])) {
            $message[] = Application_MassUpload_Excel_Constant_AdminCompanyTripSeatCode::MSG_CODE_NULL;
        }
        return count($message) ? implode(', ', $message) : null;
    }

    public function processRow($row)
    {
        $vehicleModelSeatInfo = Admin_Model_CompanyVehicleModelSeat::getInstance()->search(
            $this->getCompanyTripId(),
            $row[DbTable_Company_Vehicle_Model_Seat::COL_COMPANY_VEHICLE_MODEL_SEAT_LABEL],
            Application_Constant_Db_Config_Active::ACTIVE
        );

        $message = Admin_Model_CompanyTripSeat::getInstance()->updateCode(
            $vehicleModelSeatInfo->{DbTable_Company_Trip_Seat::COL_COMPANY_TRIP_SEAT_ID},
            $row[DbTable_Company_Trip_Seat::COL_COMPANY_TRIP_SEAT_CODE]
        );
        return $message;
    }

}
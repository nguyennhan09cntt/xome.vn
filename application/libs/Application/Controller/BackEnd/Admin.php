<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 3/7/15
 * Time: 11:37 AM
 */
class Application_Controller_BackEnd_Admin extends Application_Controller_BackEnd
{
    public function init()
    {
        $this->adminInfo = Application_Session_Admin::getInstance()->load();
    }

    /**
     * Standardize model seat
     * @param array $excelData
     * @return array
     */
    protected function standardizeModelSeatByExcel($excelData)
    {
        $data = array();
        $floor_qty = $this->_helper->getArrayValueByRowCol(
            $excelData,
            Application_Constant_Global_Excel_CompanyVehicleModelSeat::EXCEL_FLOOR_QTY_ROW,
            Application_Constant_Global_Excel_CompanyVehicleModelSeat::EXCEL_FLOOR_QTY_COL
        );
        $col_qty = $this->_helper->getArrayValueByRowCol(
            $excelData,
            Application_Constant_Global_Excel_CompanyVehicleModelSeat::EXCEL_COL_QTY_ROW,
            Application_Constant_Global_Excel_CompanyVehicleModelSeat::EXCEL_COL_QTY_COL
        );
        $row_qty = $this->_helper->getArrayValueByRowCol(
            $excelData,
            Application_Constant_Global_Excel_CompanyVehicleModelSeat::EXCEL_ROW_QTY_ROW,
            Application_Constant_Global_Excel_CompanyVehicleModelSeat::EXCEL_ROW_QTY_COL
        );
        $seat_qty = 0;
        if ($floor_qty && $row_qty && $col_qty) {
            $r = 2; //skip first row for model properties ( floor, row, col )
            for ($f=1; $f<=$floor_qty; $f++) {
                $r++;
                $end = $row_qty + $r;
                while ($r < $end) {
                    for ($c=1; $c<=$col_qty; $c++) {
                        $cell = $this->_helper->getArrayValueByRowCol($excelData, $r, $c);
                        $type = Application_Constant_Db_Config_Seat_Type::GANGWAY_CODE;
                        $label = null;
                        if ($cell) {
                            $cell = View_Filter_Db_Company_Model_Seat_Label::getInstance()->filter($cell);
                            $cellArr = explode('.', $cell);
                            $type = isset($cellArr[0]) ? $cellArr[0] : null;
                            $label = isset($cellArr[1]) ? $cellArr[1] : null;
                            $seat_qty++;
                        }
                        $data[] = array(
                            DbTable_Company_Vehicle_Model_Seat::COL_COMPANY_VEHICLE_MODEL_SEAT_LABEL => View_Filter_Db_Company_Model_Seat_Label::getInstance()->filter($label),
                            DbTable_Company_Vehicle_Model_Seat::COL_COMPANY_VEHICLE_MODEL_SEAT_FLOOR => $f,
                            DbTable_Company_Vehicle_Model_Seat::COL_COMPANY_VEHICLE_MODEL_SEAT_COL => $c,
                            DbTable_Company_Vehicle_Model_Seat::COL_COMPANY_VEHICLE_MODEL_SEAT_ROW => $r,
                            DbTable_Company_Vehicle_Model_Seat::COL_FK_CONFIG_SEAT_TYPE => Admin_Model_ConfigSeatType::getInstance()->getIdByCode($type)
                        );
                    }
                    $r++;
                }
            }
        }
        return array(
            Application_Constant_Global_Excel_CompanyVehicleModelSeat::KEY_FLOOR_QTY => $floor_qty,
            Application_Constant_Global_Excel_CompanyVehicleModelSeat::KEY_COL_QTY => $col_qty,
            Application_Constant_Global_Excel_CompanyVehicleModelSeat::KEY_ROW_QTY => $row_qty,
            Application_Constant_Global_Excel_CompanyVehicleModelSeat::KEY_SEAT_QTY => $seat_qty,
            Application_Constant_Global_Excel_CompanyVehicleModelSeat::KEY_SEAT => $data
        );
    }

    /**
     * Validate model seat which are updated by Excel
     * @param array $seatData
     * @return array
     */
    protected function validateModelSeat($seatData)
    {
        $message = array();
        $dataArr = $seatData[Application_Constant_Global_Excel_CompanyVehicleModelSeat::KEY_SEAT];
        $floor_qty = $seatData[Application_Constant_Global_Excel_CompanyVehicleModelSeat::KEY_FLOOR_QTY];
        $col_qty = $seatData[Application_Constant_Global_Excel_CompanyVehicleModelSeat::KEY_COL_QTY];
        $row_qty = $seatData[Application_Constant_Global_Excel_CompanyVehicleModelSeat::KEY_ROW_QTY];

        if (!$floor_qty) {
            $message[] = sprintf(
                Application_Constant_Module_Admin_CompanyVehicleModel_SubmitEdit::MSG_EXCEL_FLOOR_QTY_UNDEFINED,
                $this->_helper->convertExcelLabel(
                    Application_Constant_Global_Excel_CompanyVehicleModelSeat::EXCEL_FLOOR_QTY_ROW,
                    Application_Constant_Global_Excel_CompanyVehicleModelSeat::EXCEL_FLOOR_QTY_COL
                )

            );
        }
        if (!$col_qty) {
            $message[] = sprintf(
                Application_Constant_Module_Admin_CompanyVehicleModel_SubmitEdit::MSG_EXCEL_COL_QTY_UNDEFINED,
                $this->_helper->convertExcelLabel(
                    Application_Constant_Global_Excel_CompanyVehicleModelSeat::EXCEL_COL_QTY_ROW,
                    Application_Constant_Global_Excel_CompanyVehicleModelSeat::EXCEL_COL_QTY_COL
                )
            );
        }
        if (!$row_qty) {
            $message[] = sprintf(
                Application_Constant_Module_Admin_CompanyVehicleModel_SubmitEdit::MSG_EXCEL_ROW_QTY_UNDEFINED,
                $this->_helper->convertExcelLabel(
                    Application_Constant_Global_Excel_CompanyVehicleModelSeat::EXCEL_ROW_QTY_ROW,
                    Application_Constant_Global_Excel_CompanyVehicleModelSeat::EXCEL_ROW_QTY_COL
                )
            );
        }

        if ($floor_qty && $row_qty && $col_qty) {
            $labelDefined = array();
            foreach ($dataArr as $data) {
                $type = $data[DbTable_Company_Vehicle_Model_Seat::COL_FK_CONFIG_SEAT_TYPE];
                $label = $data[DbTable_Company_Vehicle_Model_Seat::COL_COMPANY_VEHICLE_MODEL_SEAT_LABEL];
                $col = $data[DbTable_Company_Vehicle_Model_Seat::COL_COMPANY_VEHICLE_MODEL_SEAT_COL];
                $row = $data[DbTable_Company_Vehicle_Model_Seat::COL_COMPANY_VEHICLE_MODEL_SEAT_ROW];

                if ($label) {
                    if (!$type) {
                        $message[] = sprintf(
                            Application_Constant_Module_Admin_CompanyVehicleModel_SubmitEdit::MSG_EXCEL_SEAT_TYPE_UNDEFINED,
                            $this->_helper->convertExcelLabel($row, $col)
                        );
                    }
                    if (isset($labelDefined[$label])) {
                        $message[] = sprintf(
                            Application_Constant_Module_Admin_CompanyVehicleModel_SubmitEdit::MSG_EXCEL_SEAT_DUPLICATED,
                            $this->_helper->convertExcelLabel($row, $col),
                            $this->_helper->convertExcelLabel(
                                $labelDefined[$label][Application_Constant_Global_Excel::KEY_ROW],
                                $labelDefined[$label][Application_Constant_Global_Excel::KEY_COL]
                            )
                        );
                    } else {
                        $labelDefined[$label] = array(
                            Application_Constant_Global_Excel::KEY_ROW => $row,
                            Application_Constant_Global_Excel::KEY_COL => $col
                        );
                    }
                }
            }
        }
        return $message;
    }
}
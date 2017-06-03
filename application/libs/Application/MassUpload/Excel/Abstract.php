<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/11/15
 * Time: 3:18 PM
 */
abstract class Application_MassUpload_Excel_Abstract
{
    /**
     * @var array
     */
    protected $data = array();

    /**
     * Get header of uploaded file
     * @return array
     */
    abstract protected function getHeader();

    /**
     * Get uploaded file ID
     * @return string
     */
    abstract protected function getFileId();

    /**
     * Validate each row
     * @param array $row
     * @return string
     */
    abstract protected function validateRow($row);

    /**
     * Process each row
     * * @param array $row
     * @return string
     */
    abstract protected function processRow($row);

    /**
     * Process uploaded file
     * @return array
     */
    final public function run()
    {
        $errMessage = array();
        $message = $this->_transformToArray();
        if (!$message) {
            foreach ($this->data as $row) {
                $response = $this->validateRow($row);
                if ($response) {
                    array_push($errMessage, $response);
                }
            }
            if ($this->validateErrorMessage($errMessage)) {
                foreach ($this->data as $row) {
                    $response = $this->processRow($row);
                    if ($response) {
                        array_push($errMessage, $response);
                    }
                }
            }
        } else {
            $errMessage[] = $message;
        }
        return $errMessage;
    }

    /**
     * Validate array of error message
     * @param array $errMessage
     * @return bool
     */
    public function validateErrorMessage($errMessage)
    {
        $result = true;
        foreach ($errMessage as $message) {
            if ($message) {
                $result = false;
                break;
            }
        }
        return $result;
    }

    /**
     * Transform excel data to Array
     * @return null|string
     */
    private function _transformToArray()
    {
        $file = isset($_FILES[$this->getFileId()]) ? $_FILES[$this->getFileId()] : null;
        $message = null;
        if ($file) {
            $inputFileName = $file['tmp_name'];
            $objPHPExcel = null;
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                $message = $e->getMessage();
            }
            if (!$message) {
                $objWorksheet 	= $objPHPExcel->getActiveSheet();
                $arrKey			= $this->getHeader();
                foreach ($objWorksheet->getRowIterator() as $k=>$row) {
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false);
                    if ($k>1) {
                        $i			= 0;
                        $arrTemp	= array();
                        foreach ($cellIterator as $cell) {
                            if ( isset($arrKey[$i]) ) {
                                $arrTemp[$arrKey[$i]]	= trim($cell->getFormattedValue());
                            }
                            $i++;
                        }
                        if ($this->_isRowValidate($arrTemp)) {
                            array_push($this->data, $arrTemp);
                        }
                    }
                }
            }
        }
        return $message;
    }

    /**
     * Check if row null / not
     * @param array $row
     * @return bool
     */
    private function _isRowValidate($row)
    {
        $result = false;
        if ($row) {
            foreach ($row as $value) {
                if (!empty($value)) {
                    $result = true;
                    break;
                }
            }
        }
        return $result;
    }

}
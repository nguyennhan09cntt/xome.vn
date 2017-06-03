<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 2/16/2017
 * Time: 11:25 AM
 */
class Cli_FacebookController extends Application_Controller_Cli
{
    /**
     * Method return district id
     * @param $identify
     * @return null| array
     */
    private function getDistrictId($identify)
    {
        $districtData = array(
            "1" => 760,
            "12" => 761,
            "thu-duc" => 762,
            "9" => 763,
            "go-vap" => 764,
            "binh-thanh" => 765,
            "tan-binh" => 766,
            "tan-phu-2" => 767,
            "phu-nhuan" => 768,
            "2" => 769,
            "3" => 770,
            "10" => 771,
            "11" => 772,
            "4" => 773,
            "5" => 774,
            "6" => 775,
            "8" => 776,
            "binh-tan" => 777,
            "7" => 778,
            "cu-chi" => 783,
            "hoc-mon" => 784,
            "binh-chanh" => 785,
            "nha-be" => 786,
            "can-gio" => 787,
        );
        return isset($districtData[$identify]) ? $districtData[$identify] : null;
    }

    private function generateImageName($link, $fileName)
    {
        $fileInfo = explode('.', $link);
        $extension = $fileInfo[count($fileInfo) - 1];
        return sprintf('%s_%s.%s', $fileName, time() . rand(1, 100), $extension);
    }

    private function downloadImage($linkImage, $component, $fileName)
    {
        $image = null;
        $folder = $this->getUploadPath() . '/' . $component;
        if (!is_dir($folder)) {
            mkdir($folder);
        }
        $folder = $folder . '/' . date('Y');
        if (!is_dir($folder)) {
            mkdir($folder);
        }
        $folder = $folder . '/' . date('m');
        if (!is_dir($folder)) {
            mkdir($folder);
        }
        $folder = $folder . '/' . date('d');
        if (!is_dir($folder)) {
            mkdir($folder);
        }

        $pathImage = strtok($linkImage, '?');
        $imagePath = sprintf('%s/%s', $folder, $this->generateImageName($pathImage, $fileName));

        $imageFile = file_get_contents($linkImage);

        if ($imageFile) {
            try {
                file_put_contents($imagePath, $imageFile);
                $image = str_replace($this->getUploadPath(), '', $imagePath);

            } catch (Exception $ex) {
                $image = null;
            }

        }

        return $image;

    }


    public function importAction()
    {
        $data = array();
        $inputFileName = SYS_PATH . '/data/import.xlsx';

        $objPHPExcel = null;
        $message = '';
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
        if (!$message) {
            $objWorksheet = $objPHPExcel->getActiveSheet();
            foreach ($objWorksheet->getRowIterator() as $k => $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
                if ($k >= 4) {
                    $i = 0;
                    $arrTemp = array();
                    foreach ($cellIterator as $cell) {
                        $value = trim($cell->getFormattedValue());
                        if ($value) {
                            $i++;
                        }
                        array_push($arrTemp, $value);
                    }
                    if ($i == 0) {
                        break;
                    }
                    array_push($data, $arrTemp);
                }

            }

            if ($data) {

                foreach ($data as $index => $item) {
                    $ownerId = null;
                    $owner = Cli_Model_ProductOwner::getInstance()->getByFacebookId($item[15]);
                    $owner = $owner ? $owner->toArray() : null;
                    if ($owner) {
                        $ownerId = $owner[DbTable_Product_Own::COL_PRODUCT_OWN_ID];
                    } else {
                        $ownerId = Cli_Model_ProductOwner::getInstance()->insert($item[14], null, null, $item[15], 0);
                    }

                    $ownerId = intval($ownerId) > 0 ? intval($ownerId) : null;
                    $identify = Application_Function_String::getFormatUrl($item [0]);
                    $districtIdentify = str_replace("Q.", "", trim($item[6]));
                    $districtIdentify = str_replace("H.", "", $districtIdentify);
                    $districtIdentify = Application_Function_String::getFormatUrl($districtIdentify);
                    $districtId = $this->getDistrictId($districtIdentify);
                    $imageThumb = null;
                    if ($item[10]) {
                        $imageThumb = $this->downloadImage($item[10], 'product', $identify);
                    }
                    $item[1] = $this->formatNumber($item[1]);
                    $productId = Cli_Model_Product::getInstance()->insert($item[0], $imageThumb, $item[9], $item[8], 2, 1, $item[10], $item[16], $item[4], $item[2], $item[1], $identify, $item[5], $districtId, $item[3], $ownerId, $item[15], $item[14]);
                    if (intval($productId)) {
                        for ($i = 10; $i < 14; $i++) {
                            $url = $item[$i];
                            if ($url) {
                                $image = $this->downloadImage($url, 'product-image', $identify);
                                Admin_Model_ProductImage::getInstance()->insert($image, $item[0], $productId, false);
                            }
                        }
                    }
                    var_dump($productId);
                    echo PHP_EOL;
                }
            }
        }
    }

    private function formatNumber($string)
    {
        $string = preg_replace('/[^0-9\,]/', '', $string); // Removes special chars.
        return $string;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 5/13/15
 * Time: 9:59 AM
 */
class Cli_DistrictController extends Application_Controller_Cli
{

    /**
     * Usage: php cli.php -m cli -c district -a identify
     */
    public function identifyAction(){
        $districtData = Admin_Model_District::getInstance()->getAll();
        foreach($districtData as $data){
            $identify = Application_Function_String::getFormatUrl($data[DbTable_District::COL_DISTRICT_NAME]);
            Admin_Model_District::getInstance()->updateIdentify($data[DbTable_District::COL_DISTRICT_ID], $identify);

        }
    }


}
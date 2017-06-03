<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:43
* Class DbTable_Config_Product_Facility
*/

class DbTable_Config_Product_Facility extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'config_product_facility';

    
    /**
    * @type <int(10) unsigned>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_CONFIG_PRODUCT_FACILITY_ID = 'config_product_facility_id';
    
    /**
    * @type <varchar(256)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CONFIG_PRODUCT_FACILITY_NAME = 'config_product_facility_name';
    
    /**
    * @var DbTable_Config_Product_Facility
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Config_Product_Facility
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Config_Product_Facility();
        }
        return self::$_instance;
    }

}
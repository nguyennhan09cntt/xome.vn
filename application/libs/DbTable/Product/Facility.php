<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:44
* Class DbTable_Product_Facility
*/

class DbTable_Product_Facility extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'product_facility';

    
    /**
    * @type <int(10) unsigned>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_PRODUCT_FACILITY_ID = 'product_facility_id';
    
    /**
    * @type <int(10) unsigned>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_FACILITY_ID = 'facility_id';
    
    /**
    * @type <int(10) unsigned>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_ID = 'product_id';
    
    /**
    * @var DbTable_Product_Facility
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Product_Facility
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Product_Facility();
        }
        return self::$_instance;
    }

}
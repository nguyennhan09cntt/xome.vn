<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:44
* Class DbTable_Province_Area
*/

class DbTable_Province_Area extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'province_area';

    
    /**
    * @type <int(10) unsigned>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_PROVINCE_AREA_ID = 'province_area_id';
    
    /**
    * @type <varchar(256)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PROVINCE_AREA_NAME = 'province_area_name';
    
    /**
    * @type <varchar(256)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PROVINCE_AREA_IDENTIFY = 'province_area_identify';
    
    /**
    * @type <int(10) unsigned>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_FK_PROVINCE = 'fk_province';
    
    /**
    * @type <decimal(9,6)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PROVINCE_AREA_LAT = 'province_area_lat';
    
    /**
    * @type <decimal(9,6)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_ PROVINCE_AREA_LNG = ' province_area_lng';
    
    /**
    * @var DbTable_Province_Area
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Province_Area
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Province_Area();
        }
        return self::$_instance;
    }

}
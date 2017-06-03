<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:43
* Class DbTable_District
*/

class DbTable_District extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'district';

    
    /**
    * @type <int(11)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_DISTRICT_ID = 'district_id';
    
    /**
    * @type <varchar(128)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_DISTRICT_IDENTIFY = 'district_identify';
    
    /**
    * @type <varchar(100)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_DISTRICT_NAME = 'district_name';
    
    /**
    * @type <varchar(30)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_DISTRICT_TYPE = 'district_type';
    
    /**
    * @type <varchar(30)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_DISTRICT_LOCATION = 'district_location';
    
    /**
    * @type <int(11)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_DISTRICT_PROVINCE = 'district_province';
    
    /**
    * @var DbTable_District
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_District
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_District();
        }
        return self::$_instance;
    }

}
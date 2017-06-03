<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:44
* Class DbTable_Province
*/

class DbTable_Province extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'province';

    
    /**
    * @type <int(11)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_PROVINCE_ID = 'province_id';
    
    /**
    * @type <varchar(128)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PROVINCE_IDENTIFY = 'province_identify';
    
    /**
    * @type <varchar(100)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_PROVINCE_NAME = 'province_name';
    
    /**
    * @type <varchar(30)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_PROVINCE_TYPE = 'province_type';
    
    /**
    * @var DbTable_Province
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Province
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Province();
        }
        return self::$_instance;
    }

}
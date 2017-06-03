<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:44
* Class DbTable_Street
*/

class DbTable_Street extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'street';

    
    /**
    * @type <int(11)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_STREET_ID = 'street_id';
    
    /**
    * @type <varchar(128)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_STREET_NAME = 'street_name';
    
    /**
    * @type <varchar(128)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_STREET_IDENTIFY = 'street_identify';
    
    /**
    * @type <tinyint(4)>
    * @null <YES>
    * @default <3>
    * @extra <>
    */
    const COL_STREET_LEVEL = 'street_level';
    
    /**
    * @type <int(11)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_FK_DISTRICT = 'fk_district';
    
    /**
    * @type <int(11)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_FK_PROVINCE = 'fk_province';
    
    /**
    * @type <datetime>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_STREET_CREATED_AT = 'street_created_at';
    
    /**
    * @type <timestamp>
    * @null <YES>
    * @default <>
    * @extra <on update CURRENT_TIMESTAMP>
    */
    const COL_STREET_UPDATED_AT = 'street_updated_at';
    
    /**
    * @var DbTable_Street
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Street
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Street();
        }
        return self::$_instance;
    }

}
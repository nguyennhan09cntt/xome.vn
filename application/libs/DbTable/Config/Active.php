<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:43
* Class DbTable_Config_Active
*/

class DbTable_Config_Active extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'config_active';

    
    /**
    * @type <tinyint(4)>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_CONFIG_ACTIVE_ID = 'config_active_id';
    
    /**
    * @type <varchar(20)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_CONFIG_ACTIVE_NAME = 'config_active_name';
    
    /**
    * @type <timestamp>
    * @null <NO>
    * @default <CURRENT_TIMESTAMP>
    * @extra <>
    */
    const COL_CONFIG_SEAT_TYPE_CREATED_AT = 'config_seat_type_created_at';
    
    /**
    * @var DbTable_Config_Active
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Config_Active
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Config_Active();
        }
        return self::$_instance;
    }

}
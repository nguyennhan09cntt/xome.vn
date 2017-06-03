<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:43
* Class DbTable_Config_Gender
*/

class DbTable_Config_Gender extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'config_gender';

    
    /**
    * @type <int(11) unsigned>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_CONFIG_GENDER_ID = 'config_gender_id';
    
    /**
    * @type <varchar(50)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_CONFIG_GENDER_NAME = 'config_gender_name';
    
    /**
    * @type <timestamp>
    * @null <NO>
    * @default <CURRENT_TIMESTAMP>
    * @extra <>
    */
    const COL_CONFIG_GENDER_CREATED_AT = 'config_gender_created_at';
    
    /**
    * @var DbTable_Config_Gender
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Config_Gender
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Config_Gender();
        }
        return self::$_instance;
    }

}
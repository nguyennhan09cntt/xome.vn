<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:43
* Class DbTable_Config_Setting
*/

class DbTable_Config_Setting extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'config_setting';

    
    /**
    * @type <int(11) unsigned>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_CONFIG_SETTING_ID = 'config_setting_id';
    
    /**
    * @type <varchar(200)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CONFIG_SETTING_NOTE = 'config_setting_note';
    
    /**
    * @type <varchar(200)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CONFIG_SETTING_VALUE = 'config_setting_value';
    
    /**
    * @type <text>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CONFIG_SETTING_TYPE = 'config_setting_type';
    
    /**
    * @type <datetime>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_CONFIG_SETTING_CREATED_AT = 'config_setting_created_at';
    
    /**
    * @type <timestamp>
    * @null <NO>
    * @default <0000-00-00 00:00:00>
    * @extra <on update CURRENT_TIMESTAMP>
    */
    const COL_CONFIG_SETTING_UPDATED_AT = 'config_setting_updated_at';
    
    /**
    * @type <int(11) unsigned>
    * @null <YES>
    * @default <1>
    * @extra <>
    */
    const COL_FK_ADMIN = 'fk_admin';
    
    /**
    * @var DbTable_Config_Setting
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Config_Setting
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Config_Setting();
        }
        return self::$_instance;
    }

}
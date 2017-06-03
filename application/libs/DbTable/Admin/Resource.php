<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:43
* Class DbTable_Admin_Resource
*/

class DbTable_Admin_Resource extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'admin_resource';

    
    /**
    * @type <int(11) unsigned>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_ADMIN_RESOURCE_ID = 'admin_resource_id';
    
    /**
    * @type <varchar(100)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_ADMIN_RESOURCE_NAME = 'admin_resource_name';
    
    /**
    * @type <varchar(50)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_ADMIN_RESOURCE_CONTROLLER = 'admin_resource_controller';
    
    /**
    * @type <tinyint(4)>
    * @null <YES>
    * @default <0>
    * @extra <>
    */
    const COL_ADMIN_RESOURCE_PRIORITY = 'admin_resource_priority';
    
    /**
    * @type <tinyint(1)>
    * @null <YES>
    * @default <1>
    * @extra <>
    */
    const COL_ADMIN_RESOURCE_ACTIVE = 'admin_resource_active';
    
    /**
    * @type <tinyint(1)>
    * @null <YES>
    * @default <1>
    * @extra <>
    */
    const COL_ADMIN_RESOURCE_DISPLAY = 'admin_resource_display';
    
    /**
    * @type <tinyint(4)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_FK_ADMIN_MODULE = 'fk_admin_module';
    
    /**
    * @type <timestamp>
    * @null <NO>
    * @default <CURRENT_TIMESTAMP>
    * @extra <>
    */
    const COL_ADMIN_RESOURCE_CREATED_AT = 'admin_resource_created_at';
    
    /**
    * @var DbTable_Admin_Resource
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Admin_Resource
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Admin_Resource();
        }
        return self::$_instance;
    }

}
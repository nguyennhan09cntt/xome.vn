<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:42
* Class DbTable_Admin_Module
*/

class DbTable_Admin_Module extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'admin_module';

    
    /**
    * @type <tinyint(4)>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_ADMIN_MODULE_ID = 'admin_module_id';
    
    /**
    * @type <varchar(50)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_ADMIN_MODULE_NAME = 'admin_module_name';
    
    /**
    * @type <timestamp>
    * @null <NO>
    * @default <CURRENT_TIMESTAMP>
    * @extra <>
    */
    const COL_ADMIN_MODULE_NAME_CREATED_AT = 'admin_module_name_created_at';
    
    /**
    * @type <tinyint(4) unsigned>
    * @null <NO>
    * @default <1>
    * @extra <>
    */
    const COL_FK_ADMIN_COMPONENT = 'fk_admin_component';
    
    /**
    * @type <tinyint(4)>
    * @null <YES>
    * @default <0>
    * @extra <>
    */
    const COL_ADMIN_MODULE_PRIORITY = 'admin_module_priority';
    
    /**
    * @var DbTable_Admin_Module
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Admin_Module
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Admin_Module();
        }
        return self::$_instance;
    }

}
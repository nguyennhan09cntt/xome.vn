<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:42
* Class DbTable_Admin_Component
*/

class DbTable_Admin_Component extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'admin_component';

    
    /**
    * @type <tinyint(4) unsigned>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_ADMIN_COMPONENT_ID = 'admin_component_id';
    
    /**
    * @type <varchar(30)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_ADMIN_COMPONENT_NAME = 'admin_component_name';
    
    /**
    * @type <timestamp>
    * @null <NO>
    * @default <CURRENT_TIMESTAMP>
    * @extra <>
    */
    const COL_ADMIN_COMPONENT_CREATED_AT = 'admin_component_created_at';
    
    /**
    * @var DbTable_Admin_Component
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Admin_Component
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Admin_Component();
        }
        return self::$_instance;
    }

}
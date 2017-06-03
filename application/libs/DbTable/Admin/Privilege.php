<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:42
* Class DbTable_Admin_Privilege
*/

class DbTable_Admin_Privilege extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'admin_privilege';

    
    /**
    * @type <int(11)>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_ADMIN_PRIVILEGE_ID = 'admin_privilege_id';
    
    /**
    * @type <varchar(100)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_ADMIN_PRIVILEGE_NAME = 'admin_privilege_name';
    
    /**
    * @type <varchar(50)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_ADMIN_PRIVILEGE_ACTION = 'admin_privilege_action';
    
    /**
    * @type <tinyint(1)>
    * @null <YES>
    * @default <1>
    * @extra <>
    */
    const COL_ADMIN_PRIVILEGE_ACTIVE = 'admin_privilege_active';
    
    /**
    * @type <int(11)>
    * @null <YES>
    * @default <0>
    * @extra <>
    */
    const COL_ADMIN_PRIVILEGE_PRIORITY = 'admin_privilege_priority';
    
    /**
    * @type <timestamp>
    * @null <NO>
    * @default <CURRENT_TIMESTAMP>
    * @extra <>
    */
    const COL_ADMIN_PRIVILEGE_CREATED_AT = 'admin_privilege_created_at';
    
    /**
    * @type <int(11) unsigned>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_FK_ADMIN_RESOURCE = 'fk_admin_resource';
    
    /**
    * @type <tinyint(1)>
    * @null <YES>
    * @default <1>
    * @extra <>
    */
    const COL_ADMIN_PRIVILEGE_DISPLAY = 'admin_privilege_display';
    
    /**
    * @var DbTable_Admin_Privilege
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Admin_Privilege
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Admin_Privilege();
        }
        return self::$_instance;
    }

}
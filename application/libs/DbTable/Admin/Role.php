<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:43
* Class DbTable_Admin_Role
*/

class DbTable_Admin_Role extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'admin_role';

    
    /**
    * @type <tinyint(4)>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_ADMIN_ROLE_ID = 'admin_role_id';
    
    /**
    * @type <varchar(200)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_ADMIN_ROLE_NAME = 'admin_role_name';
    
    /**
    * @type <timestamp>
    * @null <NO>
    * @default <CURRENT_TIMESTAMP>
    * @extra <>
    */
    const COL_ADMIN_ROLE_CREATED_AT = 'admin_role_created_at';
    
    /**
    * @var DbTable_Admin_Role
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Admin_Role
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Admin_Role();
        }
        return self::$_instance;
    }

}
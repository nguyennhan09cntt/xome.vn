<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:42
* Class DbTable_Admin_Permission
*/

class DbTable_Admin_Permission extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'admin_permission';

    
    /**
    * @type <int(11) unsigned>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_ADMIN_PERMISSION_ID = 'admin_permission_id';
    
    /**
    * @type <int(11) unsigned>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_FK_ADMIN = 'fk_admin';
    
    /**
    * @type <int(11)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_FK_ADMIN_PRIVILEGE = 'fk_admin_privilege';
    
    /**
    * @type <datetime>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_ADMIN_PERMISSION_CREATED_AT = 'admin_permission_created_at';
    
    /**
    * @var DbTable_Admin_Permission
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Admin_Permission
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Admin_Permission();
        }
        return self::$_instance;
    }

}
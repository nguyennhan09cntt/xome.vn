<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:42
* Class DbTable_Admin_Acl
*/

class DbTable_Admin_Acl extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'admin_acl';

    
    /**
    * @type <int(11)>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_ADMIN_ACL_ID = 'admin_acl_id';
    
    /**
    * @type <timestamp>
    * @null <NO>
    * @default <CURRENT_TIMESTAMP>
    * @extra <>
    */
    const COL_ADMIN_ACL_CREATED_AT = 'admin_acl_created_at';
    
    /**
    * @type <tinyint(4)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_FK_ADMIN_ROLE = 'fk_admin_role';
    
    /**
    * @type <int(11)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_FK_ADMIN_PRIVILEGE = 'fk_admin_privilege';
    
    /**
    * @var DbTable_Admin_Acl
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Admin_Acl
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Admin_Acl();
        }
        return self::$_instance;
    }

}
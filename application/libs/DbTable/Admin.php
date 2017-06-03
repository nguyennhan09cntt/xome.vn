<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:42
* Class DbTable_Admin
*/

class DbTable_Admin extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'admin';

    
    /**
    * @type <int(11) unsigned>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_ADMIN_ID = 'admin_id';
    
    /**
    * @type <varchar(100)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_ADMIN_EMAIL = 'admin_email';
    
    /**
    * @type <varchar(64)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_ADMIN_PASSWORD = 'admin_password';
    
    /**
    * @type <varchar(100)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_ADMIN_FULLNAME = 'admin_fullname';
    
    /**
    * @type <timestamp>
    * @null <NO>
    * @default <CURRENT_TIMESTAMP>
    * @extra <>
    */
    const COL_ADMIN_CREATED_AT = 'admin_created_at';
    
    /**
    * @type <datetime>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_ADMIN_LAST_LOGIN = 'admin_last_login';
    
    /**
    * @type <varchar(15)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_ADMIN_LAST_LOGIN_IP = 'admin_last_login_ip';
    
    /**
    * @type <tinyint(1)>
    * @null <YES>
    * @default <1>
    * @extra <>
    */
    const COL_ADMIN_ACTIVE = 'admin_active';
    
    /**
    * @type <tinyint(4)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_FK_ADMIN_ROLE = 'fk_admin_role';
    
    /**
    * @type <date>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_ADMIN_START_DATE = 'admin_start_date';
    
    /**
    * @type <date>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_ADMIN_BIRTHDAY = 'admin_birthday';
    
    /**
    * @type <varchar(400)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_ADMIN_NOTE = 'admin_note';
    
    /**
    * @type <varchar(20)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_ADMIN_PHONE = 'admin_phone';
    
    /**
    * @type <varchar(150)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_ADMIN_ADDRESS = 'admin_address';
    
    /**
    * @type <int(11) unsigned>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_FK_CONFIG_GENDER = 'fk_config_gender';
    
    /**
    * @var DbTable_Admin
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Admin
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Admin();
        }
        return self::$_instance;
    }

}
<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:43
* Class DbTable_Customer
*/

class DbTable_Customer extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'customer';

    
    /**
    * @type <int(11)>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_CUSTOMER_ID = 'customer_id';
    
    /**
    * @type <varchar(128)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CUSTOMER_FACEBOOK_ID = 'customer_facebook_id';
    
    /**
    * @type <varchar(256)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CUSTOMER_FACEBOOK_LINK = 'customer_facebook_link';
    
    /**
    * @type <varchar(128)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_CUSTOMER_EMAIL = 'customer_email';
    
    /**
    * @type <varchar(128)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CUSTOMER_PASSWORD = 'customer_password';
    
    /**
    * @type <varchar(256)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CUSTOMER_THUMB_IMAGE = 'customer_thumb_image';
    
    /**
    * @type <varchar(128)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CUSTOMER_PHONE = 'customer_phone';
    
    /**
    * @type <varchar(128)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CUSTOMER_LAST_NAME = 'customer_last_name';
    
    /**
    * @type <varchar(128)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CUSTOMER_FIST_NAME = 'customer_fist_name';
    
    /**
    * @type <varchar(16)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CUSTOMER_BIRTH_DAY = 'customer_birth_day';
    
    /**
    * @type <varchar(256)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CUSTOMER_NAME = 'customer_name';
    
    /**
    * @type <varchar(512)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CUSTOMER_ADDRESS = 'customer_address';
    
    /**
    * @type <text>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CUSTOMER_DESCRIPTION = 'customer_description';
    
    /**
    * @type <int(1)>
    * @null <YES>
    * @default <1>
    * @extra <>
    */
    const COL_CUSTOMER_TYPE = 'customer_type';
    
    /**
    * @type <varchar(16)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CUSTOMER_GENDER = 'customer_gender';
    
    /**
    * @type <int(11)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_FK_COUNTRY = 'fk_country';
    
    /**
    * @type <varchar(5)>
    * @null <YES>
    * @default <79>
    * @extra <>
    */
    const COL_FK_PROVINCE = 'fk_province';
    
    /**
    * @type <varchar(5)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_FK_DISTRICT = 'fk_district';
    
    /**
    * @type <int(11)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_FK_CONFIG_ACTIVE = 'fk_config_active';
    
    /**
    * @type <varchar(128)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CUSTOMER_SESSION = 'customer_session';
    
    /**
    * @type <datetime>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CUSTOMER_CREATED_AT = 'customer_created_at';
    
    /**
    * @type <timestamp>
    * @null <YES>
    * @default <>
    * @extra <on update CURRENT_TIMESTAMP>
    */
    const COL_CUSTOMER_UPDATE_AT = 'customer_update_at';
    
    /**
    * @var DbTable_Customer
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Customer
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Customer();
        }
        return self::$_instance;
    }

}
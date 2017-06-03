<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:43
* Class DbTable_Contact
*/

class DbTable_Contact extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'contact';

    
    /**
    * @type <int(10) unsigned>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_CONTACT_ID = 'contact_id';
    
    /**
    * @type <varchar(256)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CONTACT_NAME = 'contact_name';
    
    /**
    * @type <varchar(256)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CONTACT_EMAIL = 'contact_email';
    
    /**
    * @type <varchar(256)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CONTACT_PHONE = 'contact_phone';
    
    /**
    * @type <varchar(256)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CONTACT_PRICE = 'contact_price';
    
    /**
    * @type <varchar(1024)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CONTACT_PRODUCT = 'contact_product';
    
    /**
    * @type <varchar(1024)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CONTACT_MESSAGE = 'contact_message';
    
    /**
    * @type <varchar(256)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CONTACT_ADDRESS = 'contact_address';
    
    /**
    * @type <varchar(256)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CONTACT_IMAGE = 'contact_image';
    
    /**
    * @type <int(11)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CONTACT_STATUS = 'contact_status';
    
    /**
    * @type <int(11)>
    * @null <YES>
    * @default <79>
    * @extra <>
    */
    const COL_CONTACT_CITY = 'contact_city';
    
    /**
    * @type <int(11)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CONTACT_DISTRICT = 'contact_district';
    
    /**
    * @type <decimal(9,6)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CONTACT_LAT = 'contact_lat';
    
    /**
    * @type <decimal(9,6)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CONTACT_LNG = 'contact_lng';
    
    /**
    * @type <decimal(8,0)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CONTACT_RADIUS = 'contact_radius';
    
    /**
    * @type <varchar(16)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CONTACT_COLOR = 'contact_color';
    
    /**
    * @type <varchar(512)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CONTACT_URL_STATIC_MAP = 'contact_url_static_map';
    
    /**
    * @type <int(10) unsigned>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_FK_CUSTOMER = 'fk_customer';
    
    /**
    * @type <datetime>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CONTACT_CREATED_AT = 'contact_created_at';
    
    /**
    * @type <timestamp>
    * @null <YES>
    * @default <>
    * @extra <on update CURRENT_TIMESTAMP>
    */
    const COL_CONTACT_UPDATED_AT = 'contact_updated_at';
    
    /**
    * @var DbTable_Contact
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Contact
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Contact();
        }
        return self::$_instance;
    }

}
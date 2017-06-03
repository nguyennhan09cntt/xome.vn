<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:43
* Class DbTable_Product
*/

class DbTable_Product extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'product';

    
    /**
    * @type <int(11)>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_PRODUCT_ID = 'product_id';
    
    /**
    * @type <varchar(128)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_REFER_CODE = 'product_refer_code';
    
    /**
    * @type <varchar(256)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_IDENTIFY = 'product_identify';
    
    /**
    * @type <varchar(128)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_NAME = 'product_name';
    
    /**
    * @type <varchar(512)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_ADDRESS = 'product_address';
    
    /**
    * @type <varchar(256)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_THUMB_NAIL = 'product_thumb_nail';
    
    /**
    * @type <tinyint(4)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_FLAG_UPLOAD_IMAGE = 'product_flag_upload_image';
    
    /**
    * @type <int(10) unsigned>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_ORIGINAL_PRICE = 'product_original_price';
    
    /**
    * @type <int(10) unsigned>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_PAID_PRICE = 'product_paid_price';
    
    /**
    * @type <decimal(8,2)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_AREA = 'product_area';
    
    /**
    * @type <int(11) unsigned>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_FK_PRODUCT_COMPONENT = 'fk_product_component';
    
    /**
    * @type <int(11)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_CATEGORY_ID = 'product_category_id';
    
    /**
    * @type <tinyint(4)>
    * @null <YES>
    * @default <0>
    * @extra <>
    */
    const COL_PRODUCT_PRIORITY = 'product_priority';
    
    /**
    * @type <int(11)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_OBJECT = 'product_object';
    
    /**
    * @type <decimal(9,6)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_LAT = 'product_lat';
    
    /**
    * @type <decimal(9,6)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_LONG = 'product_long';
    
    /**
    * @type <int(11)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_FK_STREET = 'fk_street';
    
    /**
    * @type <int(11)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_FK_DISTRICT = 'fk_district';
    
    /**
    * @type <int(11)>
    * @null <YES>
    * @default <79>
    * @extra <>
    */
    const COL_FK_PROVINCE = 'fk_province';
    
    /**
    * @type <int(11)>
    * @null <YES>
    * @default <5>
    * @extra <>
    */
    const COL_FK_CONFIG_STATUS = 'fk_config_status';
    
    /**
    * @type <int(11)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_FK_CUSTOMER = 'fk_customer';
    
    /**
    * @type <varchar(512)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_QUALITY = 'product_quality';
    
    /**
    * @type <text>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_SHORT_DESCRIPTION = 'product_short_description';
    
    /**
    * @type <text>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_DESCRIPTION = 'product_description';
    
    /**
    * @type <text>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_ADDITION_INFO = 'product_addition_info';
    
    /**
    * @type <varchar(512)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_NOTE = 'product_note';
    
    /**
    * @type <varchar(64)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_PHONE = 'product_phone';
    
    /**
    * @type <varchar(512)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_OWN = 'product_own';
    
    /**
    * @type <varchar(256)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_REFER_LINK = 'product_refer_link';
    
    /**
    * @type <int(10) unsigned>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_FK_PRODUCT_OWNER = 'fk_product_owner';
    
    /**
    * @type <varchar(32)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_FACEBOOK_AUTHOR_ID = 'product_facebook_author_id';
    
    /**
    * @type <varchar(128)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_FACEBOOK_AUTHOR_NAME = 'product_facebook_author_name';
    
    /**
    * @type <int(11)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_PROMOTION_PRICE = 'product_promotion_price';
    
    /**
    * @type <int(11)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_PAGEVIEW = 'product_pageview';
    
    /**
    * @type <varchar(128)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_CUSTOMER_COOKIE = 'customer_cookie';
    
    /**
    * @type <datetime>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_CREATED_AT = 'product_created_at';
    
    /**
    * @type <timestamp>
    * @null <NO>
    * @default <CURRENT_TIMESTAMP>
    * @extra <on update CURRENT_TIMESTAMP>
    */
    const COL_PRODUCT_UPDATED_AT = 'product_updated_at';
    
    /**
    * @var DbTable_Product
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Product
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Product();
        }
        return self::$_instance;
    }

}
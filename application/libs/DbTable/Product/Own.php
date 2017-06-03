<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:44
* Class DbTable_Product_Own
*/

class DbTable_Product_Own extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'product_own';

    
    /**
    * @type <int(11)>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_PRODUCT_OWN_ID = 'product_own_id';
    
    /**
    * @type <varchar(256)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_OWN_NAME = 'product_own_name';
    
    /**
    * @type <varchar(256)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_OWN_PHONE = 'product_own_phone';
    
    /**
    * @type <varchar(256)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_OWN_EMAIL = 'product_own_email';
    
    /**
    * @type <varchar(256)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_OWN_FACEBOOK_ID = 'product_own_facebook_id';
    
    /**
    * @type <tinyint(4)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_OWN_TYPE = 'product_own_type';
    
    /**
    * @type <datetime>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_OWN_CREATED_AT = 'product_own_created_at';
    
    /**
    * @var DbTable_Product_Own
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Product_Own
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Product_Own();
        }
        return self::$_instance;
    }

}
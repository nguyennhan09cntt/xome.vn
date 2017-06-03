<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:43
* Class DbTable_Product_Category
*/

class DbTable_Product_Category extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'product_category';

    
    /**
    * @type <int(11)>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_PRODUCT_CATEGORY_ID = 'product_category_id';
    
    /**
    * @type <varchar(128)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_CATEGORY_NAME = 'product_category_name';
    
    /**
    * @type <varchar(128)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_CATEGORY_IDENTIFY = 'product_category_identify';
    
    /**
    * @type <int(11)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_CATEGORY_PARENT_ID = 'product_category_parent_id';
    
    /**
    * @type <int(10) unsigned>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_FK_PRODUCT_COMPONENT = 'fk_product_component';
    
    /**
    * @type <int(11)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_CATEGORY_DISPLAY_HOME = 'product_category_display_home';
    
    /**
    * @type <int(11)>
    * @null <NO>
    * @default <0>
    * @extra <>
    */
    const COL_PRODUCT_CATEGORY_POSITION = 'product_category_position';
    
    /**
    * @type <datetime>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_CATEGORY_CREATED_AT = 'product_category_created_at';
    
    /**
    * @type <timestamp>
    * @null <NO>
    * @default <CURRENT_TIMESTAMP>
    * @extra <on update CURRENT_TIMESTAMP>
    */
    const COL_PRODUCT_CATEGORY_UPDATED_AT = 'product_category_updated_at';
    
    /**
    * @type <tinyint(4)>
    * @null <NO>
    * @default <1>
    * @extra <>
    */
    const COL_PRODUCT_CATEGORY_STATUS = 'product_category_status';
    
    /**
    * @type <tinyint(4)>
    * @null <YES>
    * @default <0>
    * @extra <>
    */
    const COL_PRODUCT_CATEGORY_PRIORITY = 'product_category_priority';
    
    /**
    * @var DbTable_Product_Category
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Product_Category
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Product_Category();
        }
        return self::$_instance;
    }

}
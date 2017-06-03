<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:43
* Class DbTable_Config_Product_Tag
*/

class DbTable_Config_Product_Tag extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'config_product_tag';

    
    /**
    * @type <int(11)>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_CONFIG_PRODUCT_TAG_ID = 'config_product_tag_id';
    
    /**
    * @type <int(11)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_CONFIG_PRODUCT_TAG_NAME = 'config_product_tag_name';
    
    /**
    * @type <tinyint(4)>
    * @null <NO>
    * @default <1>
    * @extra <>
    */
    const COL_CONFIG_PRODUCT_TAG_ACTIVE = 'config_product_tag_active';
    
    /**
    * @type <datetime>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_CONFIG_PRODUCT_TAG_CREATED_AT = 'config_product_tag_created_at';
    
    /**
    * @type <timestamp>
    * @null <NO>
    * @default <0000-00-00 00:00:00>
    * @extra <on update CURRENT_TIMESTAMP>
    */
    const COL_CONFIG_PRODUCT_TAG_UPDATED_AT = 'config_product_tag_updated_at';
    
    /**
    * @var DbTable_Config_Product_Tag
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Config_Product_Tag
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Config_Product_Tag();
        }
        return self::$_instance;
    }

}
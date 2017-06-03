<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:43
* Class DbTable_Product_Component
*/

class DbTable_Product_Component extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'product_component';

    
    /**
    * @type <int(10) unsigned>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_PRODUCT_COMPONENT_ID = 'product_component_id';
    
    /**
    * @type <varchar(256)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_COMPONENT_NAME = 'product_component_name';
    
    /**
    * @type <int(11)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_COMPONENT_PARENT_ID = 'product_component_parent_id';
    
    /**
    * @type <datetime>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_COMPONENT_CREATED_AT = 'product_component_created_at';
    
    /**
    * @type <timestamp>
    * @null <NO>
    * @default <CURRENT_TIMESTAMP>
    * @extra <on update CURRENT_TIMESTAMP>
    */
    const COL_PRODUCT_COMPONENT_UPDATED_AT = 'product_component_updated_at';
    
    /**
    * @type <tinyint(3)>
    * @null <YES>
    * @default <1>
    * @extra <>
    */
    const COL_PRODUCT_COMPONENT_STATUS = 'product_component_status';
    
    /**
    * @type <int(11)>
    * @null <YES>
    * @default <0>
    * @extra <>
    */
    const COL_PRODUCT_COMPONENT_POSITION = 'product_component_position';
    
    /**
    * @type <varchar(45)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_COMPONENT_IDENTIFY = 'product_component_identify';
    
    /**
    * @var DbTable_Product_Component
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Product_Component
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Product_Component();
        }
        return self::$_instance;
    }

}
<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:44
* Class DbTable_Product_Tag
*/

class DbTable_Product_Tag extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'product_tag';

    
    /**
    * @type <int(11)>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_PRODUCT_TAG_ID = 'product_tag_id';
    
    /**
    * @type <int(11)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_FK_PRODUCT = 'fk_product';
    
    /**
    * @type <int(11)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_FK_CONFIG_PRODUCT_TAG = 'fk_config_product_tag';
    
    /**
    * @type <datetime>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_TAG_ID_CREATED_AT = 'product_tag_id_created_at';
    
    /**
    * @var DbTable_Product_Tag
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Product_Tag
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Product_Tag();
        }
        return self::$_instance;
    }

}
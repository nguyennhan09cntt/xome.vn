<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:44
* Class DbTable_Product_Image
*/

class DbTable_Product_Image extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'product_image';

    
    /**
    * @type <int(11)>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_PRODUCT_IMAGE_ID = 'product_image_id';
    
    /**
    * @type <varchar(128)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_IMAGE_NAME = 'product_image_name';
    
    /**
    * @type <varchar(512)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_IMAGE_NOTE = 'product_image_note';
    
    /**
    * @type <tinyint(4)>
    * @null <YES>
    * @default <0>
    * @extra <>
    */
    const COL_PRODUCT_IMAGE_IMPORT = 'product_image_import';
    
    /**
    * @type <int(11)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_FK_PRODUCT = 'fk_product';
    
    /**
    * @type <tinyint(4)>
    * @null <NO>
    * @default <1>
    * @extra <>
    */
    const COL_FK_ACTIVE = 'fk_active';
    
    /**
    * @type <datetime>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PRODUCT_IMAGE_CREATED_AT = 'product_image_created_at';
    
    /**
    * @type <timestamp>
    * @null <NO>
    * @default <CURRENT_TIMESTAMP>
    * @extra <on update CURRENT_TIMESTAMP>
    */
    const COL_PRODUCT_IMAGE_UPDATED_AT = 'product_image_updated_at';
    
    /**
    * @var DbTable_Product_Image
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Product_Image
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Product_Image();
        }
        return self::$_instance;
    }

}
<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:44
* Class DbTable_Promotion
*/

class DbTable_Promotion extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'promotion';

    
    /**
    * @type <int(11) unsigned>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_PROMOTION_ID = 'promotion_id';
    
    /**
    * @type <varchar(256)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PROMOTION_IDENTIFY = 'promotion_identify';
    
    /**
    * @type <varchar(200)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_PROMOTION_TITLE = 'promotion_title';
    
    /**
    * @type <text>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PROMOTION_SUB_CONTENT = 'promotion_sub_content';
    
    /**
    * @type <text>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PROMOTION_CONTENT = 'promotion_content';
    
    /**
    * @type <varchar(100)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_PROMOTION_IMAGE = 'promotion_image';
    
    /**
    * @type <datetime>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_PROMOTION_EXPIRED_DATE = 'promotion_expired_date';
    
    /**
    * @type <datetime>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_PROMOTION_CREATED_AT = 'promotion_created_at';
    
    /**
    * @type <timestamp>
    * @null <NO>
    * @default <0000-00-00 00:00:00>
    * @extra <on update CURRENT_TIMESTAMP>
    */
    const COL_PROMOTION_UPDATED_AT = 'promotion_updated_at';
    
    /**
    * @type <tinyint(1)>
    * @null <YES>
    * @default <1>
    * @extra <>
    */
    const COL_PROMOTION_ACTIVE = 'promotion_active';
    
    /**
    * @type <int(11) unsigned>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_FK_CONFIG_COMPONENT = 'fk_config_component';
    
    /**
    * @type <varchar(100)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_PROMOTION_IMAGE_SLIDER = 'promotion_image_slider';
    
    /**
    * @var DbTable_Promotion
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Promotion
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Promotion();
        }
        return self::$_instance;
    }

}
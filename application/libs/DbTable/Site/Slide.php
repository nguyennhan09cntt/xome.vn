<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:44
* Class DbTable_Site_Slide
*/

class DbTable_Site_Slide extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'site_slide';

    
    /**
    * @type <int(11)>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_SITE_SLIDE_ID = 'site_slide_id';
    
    /**
    * @type <varchar(128)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_SITE_SLIDE_NAME = 'site_slide_name';
    
    /**
    * @type <varchar(128)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_SITE_SLIDE_THUMBNAIL = 'site_slide_thumbnail';
    
    /**
    * @type <tinyint(4)>
    * @null <NO>
    * @default <1>
    * @extra <>
    */
    const COL_FK_CONFIG_ACTIVE = 'fk_config_active';
    
    /**
    * @type <datetime>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_SITE_SLIDE_CREATED_AT = 'site_slide_created_at';
    
    /**
    * @type <timestamp>
    * @null <NO>
    * @default <0000-00-00 00:00:00>
    * @extra <on update CURRENT_TIMESTAMP>
    */
    const COL_SITE_SLIDE_UPDATED_AT = 'site_slide_updated_at';
    
    /**
    * @var DbTable_Site_Slide
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Site_Slide
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Site_Slide();
        }
        return self::$_instance;
    }

}
<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:44
* Class DbTable_Site_Content
*/

class DbTable_Site_Content extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'site_content';

    
    /**
    * @type <int(11)>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_SITE_CONTENT_ID = 'site_content_id';
    
    /**
    * @type <varchar(128)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_SITE_CONTENT_NAME = 'site_content_name';
    
    /**
    * @type <text>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_SITE_CONTENT_CONTENT = 'site_content_content';
    
    /**
    * @type <varchar(256)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_SITE_CONTENT_IDENTIFY = 'site_content_identify';
    
    /**
    * @type <tinyint(4)>
    * @null <YES>
    * @default <1>
    * @extra <>
    */
    const COL_FK_CONFIG_ACTIVE = 'fk_config_active';
    
    /**
    * @type <datetime>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_SITE_CONTENT_CREATED_AT = 'site_content_created_at';
    
    /**
    * @type <timestamp>
    * @null <YES>
    * @default <>
    * @extra <on update CURRENT_TIMESTAMP>
    */
    const COL_SITE_CONTENT_UPDATED_AT = 'site_content_updated_at';
    
    /**
    * @var DbTable_Site_Content
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Site_Content
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Site_Content();
        }
        return self::$_instance;
    }

}
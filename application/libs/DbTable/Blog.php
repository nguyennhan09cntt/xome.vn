<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:43
* Class DbTable_Blog
*/

class DbTable_Blog extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'blog';

    
    /**
    * @type <int(10) unsigned>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_BLOG_ID = 'blog_id';
    
    /**
    * @type <int(10) unsigned>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_FK_BLOG_CATEGORY = 'fk_blog_category';
    
    /**
    * @type <varchar(512)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_BLOG_NAME = 'blog_name';
    
    /**
    * @type <varchar(256)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_BLOG_IDENTIFY = 'blog_identify';
    
    /**
    * @type <varchar(1024)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_BLOG_DESCRIPTION = 'blog_description';
    
    /**
    * @type <mediumtext>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_BLOG_CONTENT = 'blog_content';
    
    /**
    * @type <datetime>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_BLOG_CREATED_AT = 'blog_created_at';
    
    /**
    * @type <timestamp>
    * @null <YES>
    * @default <CURRENT_TIMESTAMP>
    * @extra <>
    */
    const COL_BLOG_UPDATED_AT = 'blog_updated_at';
    
    /**
    * @type <tinyint(4)>
    * @null <NO>
    * @default <5>
    * @extra <>
    */
    const COL_FK_CONFIG_STATUS = 'fk_config_status';
    
    /**
    * @type <varchar(256)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_BLOG_IMAGE = 'blog_image';
    
    /**
    * @type <varchar(256)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_BLOG_THUMB_IMAGE = 'blog_thumb_image';
    
    /**
    * @type <int(10) unsigned>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_FK_COMPONENT = 'fk_component';
    
    /**
    * @type <tinyint(4)>
    * @null <NO>
    * @default <0>
    * @extra <>
    */
    const COL_BLOG_IMPORT_FLAG = 'blog_import_flag';
    
    /**
    * @type <int(10) unsigned>
    * @null <NO>
    * @default <0>
    * @extra <>
    */
    const COL_BLOG_VIEW_QTY = 'blog_view_qty';
    
    /**
    * @var DbTable_Blog
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Blog
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Blog();
        }
        return self::$_instance;
    }

}
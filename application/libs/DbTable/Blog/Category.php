<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:43
* Class DbTable_Blog_Category
*/

class DbTable_Blog_Category extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'blog_category';

    
    /**
    * @type <int(10) unsigned>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_BLOG_CATEGORY_ID = 'blog_category_id';
    
    /**
    * @type <varchar(256)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_BLOG_CATEGORY_NAME = 'blog_category_name';
    
    /**
    * @type <int(11) unsigned>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_BLOG_CATEGORY_PARENT_ID = 'blog_category_parent_id';
    
    /**
    * @type <datetime>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_BLOG_CATEGORY_CREATED_AT = 'blog_category_created_at';
    
    /**
    * @type <timestamp>
    * @null <NO>
    * @default <CURRENT_TIMESTAMP>
    * @extra <on update CURRENT_TIMESTAMP>
    */
    const COL_BLOG_CATEGORY_UPDATED_AT = 'blog_category_updated_at';
    
    /**
    * @type <tinyint(3)>
    * @null <YES>
    * @default <1>
    * @extra <>
    */
    const COL_FK_CONFIG_STATUS = 'fk_config_status';
    
    /**
    * @type <int(11)>
    * @null <YES>
    * @default <0>
    * @extra <>
    */
    const COL_BLOG_CATGORY_POSITION = 'blog_catgory_position';
    
    /**
    * @type <int(11) unsigned>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_FK_COMPONENT = 'fk_component';
    
    /**
    * @type <varchar(128)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_BLOG_CATEGORY_IDENTIFY = 'blog_category_identify';
    
    /**
    * @var DbTable_Blog_Category
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Blog_Category
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Blog_Category();
        }
        return self::$_instance;
    }

}
<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:43
* Class DbTable_Blog_Component
*/

class DbTable_Blog_Component extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'blog_component';

    
    /**
    * @type <int(10) unsigned>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_BLOG_COMPONENT_ID = 'blog_component_id';
    
    /**
    * @type <varchar(128)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_BLOG_COMPONENT_IDENTIFY = 'blog_component_identify';
    
    /**
    * @type <varchar(256)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_BLOG_COMPONENT_NAME = 'blog_component_name';
    
    /**
    * @type <int(11)>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_BLOG_COMPONENT_PARENT_ID = 'blog_component_parent_id';
    
    /**
    * @type <datetime>
    * @null <YES>
    * @default <>
    * @extra <>
    */
    const COL_BLOG_COMPONENT_CREATED_AT = 'blog_component_created_at';
    
    /**
    * @type <timestamp>
    * @null <NO>
    * @default <CURRENT_TIMESTAMP>
    * @extra <on update CURRENT_TIMESTAMP>
    */
    const COL_BLOG_COMPONENT_UPDATED_AT = 'blog_component_updated_at';
    
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
    const COL_BLOG_COMPONENT_POSITION = 'blog_component_position';
    
    /**
    * @var DbTable_Blog_Component
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Blog_Component
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Blog_Component();
        }
        return self::$_instance;
    }

}
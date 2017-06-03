<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:43
* Class DbTable_Component
*/

class DbTable_Component extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'component';

    
    /**
    * @type <int(11)>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_ID = 'id';
    
    /**
    * @type <varchar(256)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_NAME = 'name';
    
    /**
    * @type <varchar(256)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_URL = 'url';
    
    /**
    * @type <timestamp>
    * @null <NO>
    * @default <CURRENT_TIMESTAMP>
    * @extra <>
    */
    const COL_CREATED_AT = 'created_at';
    
    /**
    * @var DbTable_Component
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Component
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Component();
        }
        return self::$_instance;
    }

}
<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:44
* Class DbTable_Schema_Updated
*/

class DbTable_Schema_Updated extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'schema_updated';

    
    /**
    * @type <int(11)>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_SCHEMA_UPDATED_ID = 'schema_updated_id';
    
    /**
    * @type <varchar(100)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_SCHEMA_UPDATED_FILE = 'schema_updated_file';
    
    /**
    * @type <timestamp>
    * @null <NO>
    * @default <CURRENT_TIMESTAMP>
    * @extra <on update CURRENT_TIMESTAMP>
    */
    const COL_CREATED_AT = 'created_at';
    
    /**
    * @var DbTable_Schema_Updated
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Schema_Updated
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Schema_Updated();
        }
        return self::$_instance;
    }

}
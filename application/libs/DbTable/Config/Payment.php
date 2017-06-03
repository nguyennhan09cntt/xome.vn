<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:43
* Class DbTable_Config_Payment
*/

class DbTable_Config_Payment extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'config_payment';

    
    /**
    * @type <varchar(20)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_CONFIG_PAYMENT_ID = 'config_payment_id';
    
    /**
    * @type <varchar(100)>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_CONFIG_PAYMENT_NAME = 'config_payment_name';
    
    /**
    * @type <timestamp>
    * @null <NO>
    * @default <CURRENT_TIMESTAMP>
    * @extra <>
    */
    const COL_CONFIG_PAYMENT_NAME_CREATED_AT = 'config_payment_name_created_at';
    
    /**
    * @var DbTable_Config_Payment
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Config_Payment
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Config_Payment();
        }
        return self::$_instance;
    }

}
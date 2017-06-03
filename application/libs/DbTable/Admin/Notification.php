<?php
/**
* This class is generated automatically by schema_update. !!! Do not touch or modify
* Last modified : 2017-05-28 18:56:42
* Class DbTable_Admin_Notification
*/

class DbTable_Admin_Notification extends Application_Db_DbTable
{
    /**
    * @type <string>
    */
    const _tableName = 'admin_notification';

    
    /**
    * @type <int(11) unsigned>
    * @null <NO>
    * @default <>
    * @extra <auto_increment>
    */
    const COL_ADMIN_NOTIFICATION_ID = 'admin_notification_id';
    
    /**
    * @type <int(11) unsigned>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_FK_TICKET_NOTE = 'fk_ticket_note';
    
    /**
    * @type <int(11) unsigned>
    * @null <NO>
    * @default <>
    * @extra <>
    */
    const COL_FK_ADMIN = 'fk_admin';
    
    /**
    * @type <tinyint(1)>
    * @null <YES>
    * @default <5>
    * @extra <>
    */
    const COL_ADMIN_NOTIFICATION_ACTIVE = 'admin_notification_active';
    
    /**
    * @type <timestamp>
    * @null <NO>
    * @default <CURRENT_TIMESTAMP>
    * @extra <>
    */
    const COL_ADMIN_NOTIFICATION_CREATED_AT = 'admin_notification_created_at';
    
    /**
    * @var DbTable_Admin_Notification
    */
    public static $_instance;

    public function __construct(){
        $this->_name = self::_tableName;
                    $this->_primary = $this->_name.'_id';
        
        parent::__construct();
    }

    /**
    * @return DbTable_Admin_Notification
    */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DbTable_Admin_Notification();
        }
        return self::$_instance;
    }

}
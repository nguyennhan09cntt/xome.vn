<?php
/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/19/15
 * Time: 4:55 PM
 */
class Cli_Model_Dao_SchemaUpdated
{
    /**
     * @var string
     */
    private $_table         = 'schema_updated';
    /**
     * @var string
     */
    public  $primary_key    = 'schema_updated_id';
    /**
     * @var mixed
     */
    private $_db;

    public function __construct(){
        $this->_db    = Zend_Registry::get('db_master');
    }

    /**
     * Query all migration from database
     * @return mixed
     */
    public function search()
    {
        $strQuery    = 'SELECT `schema_updated_file` AS `migration` FROM '.$this->_table.' WHERE 1=1';
        return $this->_db->fetchAll($strQuery);
    }

    /**
     * Insert new record into schema_update
     * @param $p_arrParams
     * @return mixed
     */
    public function insert($p_arrParams)
    {
        $this->_db->insert($this->_table, $p_arrParams);
        return $this->_db->lastInsertId();
    }
}
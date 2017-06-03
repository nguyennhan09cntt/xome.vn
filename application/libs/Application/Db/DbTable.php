<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/4/15
 * Time: 12:28 PM
 */
class Application_Db_DbTable extends Application_Db
{
    /**
     * @var int
     */
    static $transaction = 0;

    /**
     * @var int
     */
    static $dbMaster = 0;

    /**
     * @var int
     */
    static $dbSlave = 0;

    public function __construct()
    {
        $this->_db = Zend_Registry::get('db_slave');
    }

    /**
     * Begin transaction
     */
    protected function beginTransaction()
    {
        if (self::$transaction == 0) {
            $this->setDbMaster();
            $this->_db->beginTransaction();
            self::$transaction = 1;
        }

    }

    /**
     * Commit transaction
     */
    protected function commitTransaction()
    {
        if (self::$transaction == 1) {
            $this->_db->commit();
            self::$transaction = 0;
            $this->setDbSlave();
        }
    }

    /**
     * Rollback transaction
     */
    protected function rollbackTransaction()
    {
        if (self::$transaction == 1) {
            $this->_db->rollback();
            self::$transaction = 0;
            $this->setDbSlave();
        }
    }

    /**
     * Insert new record and return last insert ID
     * @param $array
     * @return int
     */
    public function insertAndGetLastInsertId($array)
    {
        $this->setDbMaster();
        parent::insert($array);
        $return = $this->_db->lastInsertId();
        $this->setDbSlave();
        return $return;
    }

    public function insert(array $data)
    {
        $this->setDbMaster();
        $return = parent::insert($data);
        $this->setDbSlave();
        return $return;
    }

    public function update(array $data, $where)
    {
        $this->setDbMaster();
        $return = parent::update($data, $where);
        $this->setDbSlave();
        return $return;
    }

    public function delete($where)
    {
        $this->setDbMaster();
        $return = parent::delete($where);
        $this->setDbSlave();
        return $return;
    }

    protected function setDbMaster()
    {
        if (self::$transaction == 0) {
            $this->_setAdapter('db_master');
        }
    }

    protected function setDbSlave()
    {
        if (self::$transaction == 0) {
            $this->_setAdapter('db_slave');
        }
    }
}
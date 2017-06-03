<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 10/11/15
 * Time: 1:54 PM
 */
class Application_Db extends Zend_Db_Table_Abstract
{
    /**
     * Fetch all data to Array
     * @param null $where
     * @param null $order
     * @param null $count
     * @param null $offset
     * @return array|null
     */
    public function fetchAllToArray($where = null, $order = null, $count = null, $offset = null)
    {
        $result = $this->fetchAll($where, $order, $count, $offset);
        return $result ? $result->toArray() : null;
    }

    /**
     * Fetch row to Array
     * @param null $where
     * @param null $order
     * @param null $count
     * @param null $offset
     * @return array|null
     */
    public function fetchRowToArray($where = null, $order = null, $count = null, $offset = null)
    {
        $result = $this->fetchRow($where, $order, $count, $offset);
        return $result ? $result->toArray() : null;
    }

    /**
     * @param null $where
     * @param null $order
     * @param null $count
     * @param null $offset
     * @return mixed|null
     */
    public function fetchOne($where = null, $order = null, $count = null, $offset = null)
    {
        $result = $this->fetchRow($where, $order, $count, $offset);
        $result = $result ? $result->toArray() : null;
        return is_array($result) ? reset($result) : null;
    }

    /**
     * Generate query for total found rows
     * @return Zend_Db_Select
     */
    public function queryTotalRow()
    {
        return $this->select()->setIntegrityCheck(false)->from(null, new Zend_Db_Expr('FOUND_ROWS()'));
    }

    /**
     * Get current datetime with mysql formatting
     * @return bool|string
     */
    public function mysqlSysDate()
    {
        return date('Y-m-d H:i:s');
    }

    protected function beginTransaction()
    {
        $this->_db->beginTransaction();
    }

    /**
     * Commit transaction
     */
    protected function commitTransaction()
    {
        $this->_db->commit();
    }

    /**
     * Rollback transaction
     */
    protected function rollbackTransaction()
    {
        $this->_db->rollback();
    }

    /**
     * Insert new record and return last insert ID
     * @param $array
     * @return int
     */
    public function insertAndGetLastInsertId($array)
    {
        parent::insert($array);
        $return = $this->_db->lastInsertId();
        return $return;
    }

    /**
     * Return db table
     * @return Zend_Db_Adapter_Abstract
     */
    public function getDbTable()
    {
        return $this->_db;
    }
}
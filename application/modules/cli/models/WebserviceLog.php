<?php
/**
 * Created by PhpStorm.
 * User: nhannvt
 * Date: 10/6/2015
 * Time: 10:44 AM
 */

class Cli_Model_WebserviceLog extends Application_Singleton
{
    /**
     * @var Cli_Model_Dao_WebserviceLog
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Cli_Model_Dao_WebserviceLog();
    }

    /**
     * Delete log by date
     * @param string $date
     * @return int
     */
    public function deleteByDate($date)
    {
        $where = sprintf(
            '%s <= %s',
            DbTable_Webservice_Log::COL_WEBSERVICE_LOG_CREATED_AT,
            $this->_dao->getAdapter()->quote($date)
        );
        return $this->_dao->delete($where);
    }
}
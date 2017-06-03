<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 6/26/15
 * Time: 3:29 PM
 */
class Cli_Model_SmlTransaction extends Application_Singleton
{
    /**
     * @var Cli_Model_Dao_SmlTransaction
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Cli_Model_Dao_SmlTransaction();
    }

    /**
     * Delete transaction by date
     * @param string $date
     * @return int
     */
    public function deleteByDate($date)
    {
        $where = sprintf(
            '%s <= %s',
            DbTable_Sml_Transaction::COL_SML_TRANSACTION_CREATED_AT,
            $this->_dao->getAdapter()->quote($date)
        );
        return $this->_dao->delete($where);
    }
}
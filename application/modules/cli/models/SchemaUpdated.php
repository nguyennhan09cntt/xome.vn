<?php
/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/19/15
 * Time: 4:57 PM
 */
class Cli_Model_SchemaUpdated extends Application_Singleton
{
    /**
     * @var Cli_Model_Dao_SchemaUpdated
     */
    private $_dao;

    protected function __construct(){
        $this->_dao = new Cli_Model_Dao_SchemaUpdated();
    }

    /**
     * Get all migrations
     * @param $p_arrParams
     * @return mixed
     */
    public function search($p_arrParams)
    {
        $arrResult    = $this->_dao->search($p_arrParams);
        return $arrResult;
    }

    /**
     * Insert new migration
     * @param $p_arrParams
     * @return mixed
     */
    public function insert($p_arrParams){
        return $this->_dao->insert($p_arrParams);
    }
}
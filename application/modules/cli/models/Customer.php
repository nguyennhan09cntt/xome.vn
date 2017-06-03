<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 6/4/15
 * Time: 9:28 PM
 */
class Cli_Model_Customer extends Application_Singleton
{
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Cli_Model_Dao_Customer();
    }

    /**
     * Update ref bonus
     * @param int $customerId
     * @param int $refBonusValue
     * @param int $ticketId
     * @return string
     */
    public function updateBonusByRefCode($customerId, $refBonusValue, $ticketId)
    {
        $customerId = intval($customerId);
        $refBonusValue = intval($refBonusValue);
        $ticketId = intval($ticketId);
        return $this->_dao->updateBonusByRefCode($customerId, $refBonusValue, $ticketId);
    }

    /**
     * get all customer
     * @return array
     */
    public function getAll(){
        $result = array();
        $data = $this->_dao->fetchAll();
        if($data){
            foreach($data as $customer){
                $result[$customer->{DbTable_Customer::COL_CUSTOMER_ID}] = $customer->toArray();
            }
        }
        return $result;
    }
}
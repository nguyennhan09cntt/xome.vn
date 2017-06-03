<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 6/4/15
 * Time: 9:28 PM
 */
class Cli_Model_Dao_Customer extends DbTable_Customer
{
    /**
     * Update ref bonus
     * @param int $customerId
     * @param int $refBonusValue
     * @param int $ticketId
     * @return string
     */
    public function updateBonusByRefCode($customerId, $refBonusValue, $ticketId)
    {
        $response = '';
        try {
            $this->beginTransaction();

            #Customer Transaction
            $params = array(
                DbTable_Customer_Transaction::COL_FK_CUSTOMER => $customerId,
                DbTable_Customer_Transaction::COL_CUSTOMER_TRANSACTION_PARAM => $ticketId,
                DbTable_Customer_Transaction::COL_CUSTOMER_TRANSACTION_VALUE => $refBonusValue,
                DbTable_Customer_Transaction::COL_FK_CUSTOMER_TRANSACTION_TYPE => Application_Constant_Db_Customer_Transaction_Type::REF_CODE
            );
            DbTable_Customer_Transaction::getInstance()->insert($params);

            #Customer
            $params = array(
                DbTable_Customer::COL_CUSTOMER_MARK => new Zend_Db_Expr(
                        sprintf(
                            '%s+%d',
                            DbTable_Customer::COL_CUSTOMER_MARK,
                            $refBonusValue
                        )
                    )
            );
            $where = sprintf(
                '%s=%d',
                DbTable_Customer::COL_CUSTOMER_ID,
                $customerId
            );
            $this->update($params, $where);

            $this->commitTransaction();
        } catch (Exception $e) {
            $this->rollbackTransaction();
            $response = $e->getMessage();
        }
        return $response;
    }
}
<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 2/16/2017
 * Time: 12:30 PM
 */
class Cli_Model_Dao_ProductOwner extends DbTable_Product_Own
{
    /**
     * @param string $facebookId
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function getByFacebookId($facebookId)
    {
        $select = $this->select()
            ->where(DbTable_Product_Own::COL_PRODUCT_OWN_FACEBOOK_ID . '=?', $facebookId);
        return $this->fetchRow($select);
    }
}
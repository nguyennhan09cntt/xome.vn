<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/21/2016
 * Time: 9:46 PM
 */
class Model_Dao_ProductProductOrder extends DbTable_Product_Product_Order
{

    public function checkProductExistOrder($orderId, $productId)
    {
        $select = $this->select()
            ->where(DbTable_Product_Product_Order::COL_FK_PRODUCT_ORDER . ' =?', $orderId)
            ->where(DbTable_Product_Product_Order::COL_FK_PRODUCT . '=?', $productId);

        return $this->fetchRow($select);
    }
}
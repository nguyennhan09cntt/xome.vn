<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/26/15
 * Time: 9:43 AM
 */
class Application_Function_Array
{
    static public function group($array, $qty)
    {
        $totalPage = ceil(count($array)/$qty);
        $result = array();
        for ($i=1; $i<=$totalPage; $i++) {
            $result[] = array_slice($array, ($i-1)*$qty, $qty);
        }
        return $result;
    }
}
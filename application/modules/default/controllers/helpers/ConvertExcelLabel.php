<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/3/15
 * Time: 9:33 AM
 */
class Controller_Helper_ConvertExcelLabel extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($row, $col)
    {
        $alpha = 'abcdfghjkmnpqrstvwxyz';
        return sprintf('%s%d', strtoupper($alpha[$col-1]), $row);
    }
}
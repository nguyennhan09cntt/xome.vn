<?php
/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/21/15
 * Time: 9:55 AM
 */
class View_Filter_Db_Admin_Password extends Application_Singleton implements Zend_Filter_Interface
{
    public function filter($value)
    {
        return trim($value);
    }
}
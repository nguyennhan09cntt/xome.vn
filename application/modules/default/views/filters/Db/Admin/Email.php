<?php
/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/20/15
 * Time: 4:46 PM
 */
class View_Filter_Db_Admin_Email extends Application_Singleton implements Zend_Filter_Interface
{
    public function filter($value)
    {
        return strtolower(trim($value));
    }
}
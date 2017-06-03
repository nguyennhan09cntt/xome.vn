<?php
/**
 * Created by Phong Pham <xitrumhaman@yahoo.com>.
 * User: Phong Pham
 * Date: 10/11/14
 * Time: 3:53 PM
 */
class Application_Singleton
{
    /**
     * @var static[]
     */
    private static $_instance;

    /**
     * @return static
     */
    final public static function getInstance()
    {
        $calledClass = get_called_class();
        if( !isset(self::$_instance[$calledClass]) || is_null(self::$_instance[$calledClass]) ){
            self::$_instance[$calledClass] = new $calledClass();
        }
        return self::$_instance[$calledClass];
    }

    final protected function __clone(){}
}
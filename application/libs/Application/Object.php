<?php
/**
 * Created by Phong Pham <xitrumhaman@yahoo.com>.
 * User: Phong Pham
 * Date: 10/11/14
 * Time: 10:52 AM
 */

class Application_Object
{
    /**
     * @param string $name
     * @param string $value
     * @return mixed
     * @throws Exception
     */
    public function __set($name, $value)
    {
        $method = 'set'.ucfirst($name);
        if( !method_exists($this, $method) ){
            throw new Exception( sprintf('Method [%s] does not exist in [%s]', $method, get_class($this)) );
        }
        return $this->$method($value);
    }

    /**
     * @param $name
     * @return mixed
     * @throws Exception
     */
    public function __get($name)
    {
        $method = 'get'.ucfirst($name);
        if( !method_exists($this, $method) ){
            throw new Exception( sprintf('Method [%s] does not exist in [%s]', $method, get_class($this)) );
        }
        return $this->$method();
    }

    /**
     * Initialize object properties and transfer array data to object properties
     * @param array $array
     * @return $this
     */
    protected function setOptions($array)
    {
        if($array)
        {
            foreach($array as $key=>$value){
                $this->__set($key, $value);
            }
        }
        return $this;
    }
}
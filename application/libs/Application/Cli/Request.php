<?php
class Application_Cli_Request extends Zend_Controller_Request_Abstract
{
    public function __construct()
    {
        $opts = new Application_Console_Getopt(
            array(
                'module|m-s'     => 'module name',
                'controller|c-s' => 'controller name',
                'action|a-s'     => 'action name'
            )
        );
        $params = $opts->getParams();
        foreach ($params as $param => $value) {
            $this->setParam($param, $value);
        }
        return $this;
    }

}
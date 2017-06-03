<?php
class Application_Cli_Response extends Zend_Controller_Response_Cli
{
    public function sendHeaders()
    {
        return $this;
    }
}
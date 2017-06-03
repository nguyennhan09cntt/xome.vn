<?php
class Application_Controller_Cli extends Application_Controller
{
    public function init()
    {
    }

    public function preDispatch()
    {
        if (strtolower(PHP_SAPI) != 'cli') {
            die('Run in command line only');
        }
    }

    public function postDispatch()
    {
        $this->noRender();
    }
}

<?php

class Cli_Model_Blog extends Application_Singleton
{

    protected function __construct()
    {

    }

    /**
     * @param $name
     * @param $image
     * @param $content
     * @param $description
     * @param $category
     * @param $component
     * @return null|string
     */
    public function insert($name, $image, $content, $description, $category, $component)
    {
        return Admin_Model_Blog::getInstance()->insert($name, $image, $content, $description, $category, $component);
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return Admin_Model_Blog::getInstance()->getAll();
    }

}
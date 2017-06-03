<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 3/9/15
 * Time: 5:57 PM
 */
class Admin_Model_AdminComponent extends Application_Singleton
{
    protected function __construct()
    {

    }

    /**
     * Get all components
     * @return array
     */
    public function getAll()
    {
        return array(
            Application_Constant_Db_Admin_Component::CMS => 'CMS',
            Application_Constant_Db_Admin_Component::OPERATION => 'Operation',
            Application_Constant_Db_Admin_Component::INTERNAL => 'Internal'
        );
    }

    /**
     * Get name by ID
     * @param int $id
     * @return null
     */
    public function getNameById($id)
    {
        $data = $this->getAll();
        return $data[$id] ? $data[$id] : null;
    }
}
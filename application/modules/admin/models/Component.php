<?php
class Admin_Model_Component extends Application_Singleton
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
            Application_Constant_Db_Component::LANGUAGE => 'Ngoại ngữ',
            Application_Constant_Db_Component::INFO_TECHNOLOGY => 'Tin học'          
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
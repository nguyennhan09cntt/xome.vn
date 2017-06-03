<?php
/**
 * Created by PhpStorm.
 * User: duyca
 * Date: 5/29/2015
 * Time: 4:12 PM
 */
class Cli_Model_Admin extends Application_Singleton
{
    /**
     * @var Cli_Model_Dao_Admin
     */
    private $_dao;

    protected function __construct(){
        $this->_dao = new Cli_Model_Dao_Admin();
    }

    /**
     * Get admin info by fk_admin_role
     * @param int $fk_admin_role
     * @return mixed
     */
    public function searchByAdminRoleId($fk_admin_role)
    {
        $fk_admin_role = intval($fk_admin_role);
        return $this->_dao->searchByAdminRoleId($fk_admin_role);
    }
}
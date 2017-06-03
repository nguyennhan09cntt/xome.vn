<?php
/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/23/15
 * Time: 10:02 AM
 */
class Admin_Model_AdminModule extends Application_Singleton
{
    /**
     * @var Admin_Model_Dao_AdminModule
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Admin_Model_Dao_AdminModule();
    }

    /**
     * Get all admin module
     * @return array|false|mixed|null
     */
    public function getAll()
    {
        $result = array();
        $result = Application_Cache::getInstance()->load(
            Application_Cache_Admin::getInstance()->adminModule()
        );
        if (!$result) {
            $data = $this->_dao->fetchAll();
            $result = $data ? $data->toArray() : null;
            Application_Cache::getInstance()->save(
                $result,
                Application_Cache_Admin::getInstance()->adminModule(),
                Application_Constant_Cache::ADMIN_MODULE_LIFE_TIME
            );
        }
        return $result;
    }

    /**
     * Insert new admin module
     * @param string $moduleName
     * @param int $priority
     * @param int $componentId
     */
    public function insert($moduleName, $priority, $componentId)
    {
        $params = array(
            DbTable_Admin_Module::COL_ADMIN_MODULE_NAME => trim($moduleName),
            DbTable_Admin_Module::COL_ADMIN_MODULE_PRIORITY => intval($priority),
            DbTable_Admin_Module::COL_FK_ADMIN_COMPONENT => intval($componentId),
        );
        $this->_dao->insert($params);
        Application_Cache_Admin::getInstance()->resetAdminModule();
    }

    /**
     * Get all privilege with module & resource name
     * @return array
     */
    public function getAllPrivileges()
    {
        $result = array();
        $privilegeData = $this->_dao->getAllPrivileges();
        if ($privilegeData) {
            foreach ($privilegeData as $data) {
                $module = sprintf(
                    '%s | %s',
                    Admin_Model_AdminComponent::getInstance()->getNameById($data->{DbTable_Admin_Module::COL_FK_ADMIN_COMPONENT}),
                    $data->{DbTable_Admin_Module::COL_ADMIN_MODULE_NAME}
                );
                if (!isset($result[$module])) {
                    $result[$module] = array();
                }
                $resource = $data->{DbTable_Admin_Resource::COL_ADMIN_RESOURCE_NAME};
                if (!isset($result[$module][$resource])) {
                    $result[$module][$resource] = array();
                }
                $result[$module][$resource][] = array(
                    DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_ID => $data->{DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_ID},
                    DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_NAME => $data->{DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_NAME}
                );
            }
        }
        return $result;
    }

    /**
     * Generate query search
     * @param int $componentId
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($componentId)
    {
        return $this->_dao->searchQuery($componentId);
    }
}
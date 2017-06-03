<?php
class Admin_View_Helper_Menu extends Zend_View_Helper_Abstract
{
    public function menu($adminId)
    {
        $permissionData = Admin_Model_AdminPermission::getInstance()->searchByAdminId($adminId);
        $menuData = array();
        if ($permissionData) {
            foreach ($permissionData as $data) {
                if ($data[DbTable_Admin_Module::COL_FK_ADMIN_COMPONENT] == Application_Constant_Db_Admin_Component::CMS) {
                    if ($data[DbTable_Admin_Resource::COL_ADMIN_RESOURCE_DISPLAY] == Application_Constant_Db_Admin_Resource::DISPLAY) {
                        $module = $data[DbTable_Admin_Module::COL_ADMIN_MODULE_NAME];
                        if (!isset($menuData[$module])) {
                            $menuData[$module] = array();
                        }

                        $resource = $data[DbTable_Admin_Resource::COL_ADMIN_RESOURCE_NAME];
                        if (!isset($menuData[$module][$resource])) {
                            $menuData[$module][$resource] = array();
                        }

                        $menuData[$module][$resource][] = array(
                            Application_Constant_Module_Admin::PREFIX_MENU_NAME => $data[DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_NAME],
                            Application_Constant_Module_Admin::PREFIX_MENU_URL => sprintf(
                                '%s/%s',
                                $data[DbTable_Admin_Resource::COL_ADMIN_RESOURCE_CONTROLLER],
                                $data[DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_ACTION]
                            )
                        );
                    }
                }
            }
        }
        $this->view->assign('menuData', $menuData);
        return $this->view->render('menu.phtml');
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/19/15
 * Time: 4:25 PM
 */
class MigrationList
{
    /**
     * Return list of migration need to be deployed
     * @return array
     */
    static public function getList()
    {
        return array(
            '_init.01.admin_role_table.sql',
            '_init.02.admin_table.sql',
            '_init.03.admin_module_table.sql',
            '_init.04.admin_resource_table.sql',
            '_init.05.admin_privilege_table.sql',
            '_init.06.admin_acl_table.sql',           
            'config_active_table.sql',       
        );
    }
}
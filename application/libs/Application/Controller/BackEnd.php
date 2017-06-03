<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 3/7/15
 * Time: 11:32 AM
 */
class Application_Controller_BackEnd extends Application_Controller
{
    /**
     * @var
     */
    protected $adminInfo;

    /**
     * @var Zend_Config_Ini
     */
    protected $config;

    public function init()
    {
        $this->config = Zend_Registry::get('config');
    }

    public function preDispatch()
    {
        if (!$this->adminInfo) {
            $this->gotoUrl('/login');
        } elseif (!$this->_isAllowed()) {
            $this->gotoUrl('/alert/access-deny');
        }
    }

    public function postDispatch()
    {
        $this->autoLoadResource($this->_getResourceCss(), 'css');
        $this->autoLoadResource($this->_getResourceJs(), 'js');

        $this->view->assign('adminInfo', $this->adminInfo);
        $this->view->assign('config', $this->config);
        $this->view->assign('controller', $this->getRequest()->getParam('controller'));
        $this->view->assign('action', $this->getRequest()->getParam('action'));
        $this->view->assign(
            'urlPath',
            sprintf(
                '%s/%s',
                $this->getRequest()->getParam('controller'),
                $this->getRequest()->getParam('action')
            )
        );
    }

    protected function goto404()
    {
        $this->gotoUrl('/alert/error404');
    }

    /**
     * Show error message when form is submitted
     * @param string $message
     */
    protected function alertSubmitError($message)
    {
        echo sprintf('<script>parent.alert("%s")</script>', trim($message));
    }

    /**
     * Redirect form is submitted
     * @param string $url
     */
    protected function redirectSubmit($url)
    {
        echo sprintf('<script>parent.location.href="/%s";</script>', $url);
    }

    /**
     * Alert error message
     * @param array|string $message
     */
    protected function alertAppendMessage($message)
    {
        $script = '<script>';
        $script .= 'parent.AdminCommon.resetErrorMsg();';
        if (!is_array($message)) {
            $messageArr[] = $message;
        } else {
            $messageArr = $message;
        }
        foreach ($messageArr as $msg) {
            $script .= 'parent.AdminCommon.appendErrorMsg("'.$msg.'");';
        }
        $script .= '</script>';
        echo $script;
    }

    /**
     * Get ID of admin role
     * @return int
     */
    protected function getAdminRole()
    {
        return $this->adminInfo ? $this->adminInfo->{DbTable_Admin::COL_FK_ADMIN_ROLE} : 0;
    }

    /**
     * Get Administrator ID
     * @return mixed
     */
    protected function getAdminId()
    {
        return $this->adminInfo->{DbTable_Admin::COL_ADMIN_ID};
    }

    /**
     * Check if current use is Root
     * @return bool
     */
    private function _isAdminRoot()
    {
        return $this->adminInfo && $this->adminInfo->{DbTable_Admin::COL_ADMIN_ID}==Application_Constant_Db_Admin::ADMIN_ROOT ;
    }

    /**
     * Check if user is allowed to access this controller-action
     * @return bool
     */
    private function _isAllowed()
    {
        $result = true;
        $controller = $this->getRequest()->getControllerName();
        $action = $this->getRequest()->getActionName();
        if (Admin_Model_AdminPrivilege::getInstance()->isIncluded($controller, $action)) {
            if (!$this->_isAdminRoot()) {
                $permissionData = Admin_Model_AdminPermission::getInstance()->searchByAdminId($this->adminInfo->{DbTable_Admin::COL_ADMIN_ID});
                if ($permissionData) {
                    $result = false;
                    foreach ($permissionData as $data) {
                        if ($controller==$data[DbTable_Admin_Resource::COL_ADMIN_RESOURCE_CONTROLLER]
                            && $action==$data[DbTable_Admin_Privilege::COL_ADMIN_PRIVILEGE_ACTION]) {
                            $result = true;
                            break;
                        }
                    }
                }
            }
        }
        return $result;
    }

    /**
     * Get Css resource
     * @return array
     */
    private function _getResourceCss()
    {
        return array(

        );
    }

    /**
     * Get Js Resource
     * @return array
     */
    private function _getResourceJs()
    {
        return array(

        );
    }

    /**
     * @param string $url
     */
    protected function clearCachePage($url)
    {
        if ($this->config->env->name == 'live') {
            file_get_contents('http://10.10.27.27' . $url);
        }
    }
}
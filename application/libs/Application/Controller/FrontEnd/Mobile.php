<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/22/15
 * Time: 2:06 PM
 */
class Application_Controller_FrontEnd_Mobile extends Application_Controller_FrontEnd
{
    public function init()
    {
        parent::init();
    }

    public function postDispatch()
    {
        parent::postDispatch();
        $this->autoLoadResource($this->_getResourceJs(), 'js');
        $this->autoLoadResource($this->_getResourceCss(), 'css');

        $controllerName = $this->getRequest()->getControllerName();
        $actionName = $this->getRequest()->getActionName();

        $this->view->assign('controllerName', $controllerName);
        $this->view->assign('actionName', $actionName);
    }

    /**
     * Get array Css resources
     * @return array
     */
    private function _getResourceCss()
    {
        return array(
            '../libs/css/plugins/validationEngine.jquery.css'
        );
    }

    /**
     * Initialize resource Js
     * @return array
     */
    private function _getResourceJs()
    {
        $time = time();
        return array(
            sprintf('autoload/js/mobile.common.js?m=%s', $time),
            sprintf('autoload/js/mobile.global-search.js?m=%s', $time)
        );
    }

    protected function setNoFooterLink()
    {
        $this->view->assign('noFooterLink', 1);
    }

    /**
     * @param array $provinceData
     * @param string $name
     * @param mixed $condition
     * @param int $limit
     */
    protected function assignProvinceData($provinceData, $name, $condition, $limit=2)
    {
        $this->view->assign(
            $name,
            Application_Function_Array::group(
                $this->_helper->filterArrayWithCondition(
                    $provinceData,
                    DbTable_Region_Province::COL_FK_REGION_AREA,
                    $condition
                ),
                $limit
            )
        );
    }

    /**
     * Call script parent window
     * @param string $method
     * @param array $params
     * @return string
     */
    protected function callScriptParent($method, $params=array())
    {
        return '
        <script>
            parent.' . trim($method) . '('. ($params ? sprintf('"%s"', implode('","', $params)) : '') .')
        </script>';

    }

    /**
     * Get config route
     * @param string $routeName
     * @return mixed
     */
    protected function getConfigRoute($routeName)
    {
        $config = $this->getConfig();
        return $config->resources->router->routes->mobile_subdomain->chains->$routeName->route;
    }

    /*
    /**
     * Redirect method
     * @param string $url
     * @param array $option
    protected function gotoUrl($url, $option=array())
    {
        if (strpos($url, '/') != 1) {
            $url = '/' . $url;
        }
        $this->view->assign('url', $url);
        die(
            $this->view->render('widgets/goToUrl.phtml')
        );
    }
    */
}
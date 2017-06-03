<?php

/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/22/15
 * Time: 2:07 PM
 */
class Application_Controller_FrontEnd_Default extends Application_Controller_FrontEnd
{
    /**
     * @var string
     */
    private $_metaImage = '';

    public function init()
    {
        $this->_metaImage = sprintf('%s/statics/asset/default/img/home.png', Application_Function_Common::currentUrl());
        $this->setMetaData(
            $this->getTranslateValue('common_title'),
            $this->getTranslateValue('common_keywords'),
            $this->getTranslateValue('common_description')
        );
        parent::init();
    }

    public function postDispatch()
    {
        parent::postDispatch();
        $this->autoLoadResource($this->_getResourceCss(), 'css');
        $this->autoLoadResource($this->_getResourceJs(), 'js');

        $controllerName = $this->getRequest()->getControllerName();
        $actionName = $this->getRequest()->getActionName();


        $this->view->assign('controllerName', $controllerName);
        $this->view->assign('actionName', $actionName);
        $this->view->assign(
            'staticUrl',
            $this->getConfig()->resources->router->routes->static_subdomain->route
        );

        #No cache
        $validateNonCache = false;

        if ($validateNonCache) {
            $this->setNoCachePage();
        }
        #No cache

        $this->view->assign('metaImage', $this->_metaImage);
        $this->view->assign('fullCurrentUrl', Application_Function_Common::fullCurrentUrl());
        $districtData = $this->_helper->buildArrayInKeyAttributeWithCondition(
            Admin_Model_District::getInstance()->getAll(),
            DbTable_District::COL_DISTRICT_ID,
            DbTable_District::COL_DISTRICT_NAME,
            DbTable_District::COL_DISTRICT_PROVINCE,
            79
        );
        $this->view->assign('districtData', $districtData);



    }


    /**
     * Get array Css resources
     * @return array
     */
    private function _getResourceCss()
    {
        return array();
    }

    private function _getResourceJs()
    {
        $time = time();
        return array();
    }

    /**
     * Set Meta Image
     * @param string $path
     */
    protected function setMetaImage($path)
    {
        $this->_metaImage = trim($path);
    }

    protected function noGlobalSearch()
    {
        $this->view->assign('noGlobalSearch', 1);
    }

    /**
     * Call script parent window
     * @param string $method
     * @param array $params
     * @return string
     */
    protected function callScriptParent($method, $params = array())
    {
        return '
        <script>
            parent.' . trim($method) . '(' . ($params ? sprintf("'%s'", implode("','", $params)) : '') . ')
        </script>';

    }

    /**
     * Set no navigation
     */
    protected function setNoNavigation()
    {
        $this->view->assign('noNavigation', 1);
    }

    /**
     * Get config route
     * @param string $routeName
     * @return mixed
     */
    protected function getConfigRoute($routeName)
    {
        $config = $this->getConfig();
        return $config->resources->router->routes->$routeName->route;
    }

    protected function noGlobalSlide()
    {
        $this->view->assign('noGlobalSlide', 1);
    }


    protected function blogNoSlide()
    {
        $this->view->assign('blogNoSlide', 1);
    }

}
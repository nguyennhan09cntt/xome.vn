<?php
/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 6/10/2016
 * Time: 10:56 AM
 */

class Mobile_SiteContentController extends Application_Controller_FrontEnd_Default
{
    public function indexOldAction()
    {

    }

    public function indexAction()
    {

    }

    public function error404Action()
    {
        $url = Application_Function_Common::fullCurrentUrl();
        if (!strstr($url, '/404.html')) {
            $this->gotoUrl('/404.html', array('code' => 301));
        }
        header("HTTP/1.0 404 Not Found");

        $this->noLayout();
        $this->noGlobalSearch();
        $this->setNoIndex();
    }

    public function siteMapAction()
    {

    }

}
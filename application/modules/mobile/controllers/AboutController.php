<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/19/2016
 * Time: 9:11 PM
 */
class Mobile_AboutController extends Application_Controller_FrontEnd_Default
{
    public function indexAction()
    {
        $contentData = Admin_Model_SiteContent::getInstance()->getByIdentify('gioi-thieu');
        if ($contentData) {
            $this->view->assign('content', $contentData->{DbTable_Site_Content::COL_SITE_CONTENT_CONTENT});
        }
        $this->view->assign('menuHeader', Application_Constant_Identify::MENU_HEADER_ABOUT);

    }

    public function guideAction()
    {
        $contentData = Admin_Model_SiteContent::getInstance()->getByIdentify('huong-dan');
        if ($contentData) {
            $this->view->assign('content', $contentData->{DbTable_Site_Content::COL_SITE_CONTENT_CONTENT});
        }
        $this->view->assign('menuHeader', Application_Constant_Identify::MENU_HEADER_GUIDE);
    }


}
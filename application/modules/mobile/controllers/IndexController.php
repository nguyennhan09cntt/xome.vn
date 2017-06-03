<?php

class Mobile_IndexController extends Application_Controller_FrontEnd_Default
{

    public function preDispatch()
    {
        $this->view->assign('menuHeader', Application_Constant_Identify::MENU_HEADER_HOME);
    }

    public function captchaAction()
    {
        $this->renderCaptcha($this->getRequest()->getParam('pos', -1));
        $this->noRender();
    }

    public function verifyCaptchaAction()
    {
        $captcha = $this->getRequest()->getParam('captcha');

        $data = 'error';
        if ($this->validateSessionCaptcha($captcha)) {
            $data = 'success';
        }
        $this->_helper->json(
            array(
                Application_Constant_Module_Default::RESPONSE_ERROR_KEY => 0,
                Application_Constant_Module_Default::DATA_RESPONSE => $data
            )
        );
        $this->noRender();
    }

    public function refreshCaptchaAction()
    {

        echo '/captcha.jpg?t' . time();
        $this->noRender();
    }



    public function indexAction()
    {
        $page = $this->getParam('page', 1);
        $limit = 8;
        $data = Model_Product::getInstance()->getHomeListing($page, $limit, null);
        $productData = $data ? $data[Application_Constant_Global::KEY_DATA] : array();
        $total = $data ? $data[Application_Constant_Global::KEY_TOTAL] : 0;
        $totalPage = ($total - 1) / $limit + 1;
        Application_Function_Pagination_Default::getInstance()->initialize($totalPage, $page);
        $this->view->assign('pagination', Application_Function_Pagination_Default::getInstance()->show());
	if($page <2){
		$slideData = Model_SiteSlide::getInstance()->getAll();
		$this->view->assign(
			'sliderData',
			$slideData
		);
	}

        $this->view->assign('productData', $productData);

    }

}
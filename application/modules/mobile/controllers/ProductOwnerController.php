<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/19/2016
 * Time: 9:11 PM
 */
class Mobile_ProductOwnerController extends Application_Controller_FrontEnd_Default
{
    public function indexAction()
    {
        $page = $this->getParam('page', 1);
        $limit = 12;
        $key = $this->getParam('key', '');
        $data = Model_ProductOwner::getInstance()->getListing($page, $limit, $key);
        $productOwnerData = $data ? $data[Application_Constant_Global::KEY_DATA] : array();
        $total = $data ? $data[Application_Constant_Global::KEY_TOTAL] : 0;
        $totalPage = ($total - 1) / $limit + 1;
        Application_Function_Pagination_Default::getInstance()->initialize($totalPage, $page);
        $this->view->assign('pagination', Application_Function_Pagination_Default::getInstance()->show());
        $this->view->assign('productOwnerData', $productOwnerData);
        $this->view->assign('key', $key);
        $this->view->assign('menuHeader', Application_Constant_Identify::MENU_HEADER_MOTEL_OWNER_INFO);
        $this->setMetaData(
            'Thông tin của những người đăng tin cho thuê phòng trọ, nhà trọ',
            $this->getTranslateValue('common_keywords'),
            'Thông tin của những người đăng tin cho thuê phòng trọ, nhà trọ'
        );

    }

    public function detailAction()
    {
        $encode = $this->getParam('encode');
        $encode = 'xomevn' . $encode;

        $id = Model_ProductOwner::getInstance()->decode($encode);

        if ($id) {
            $data = Model_ProductOwner::getInstance()->getById($id);
            $dataInfo = $data ? $data->current() : null;
            if ($dataInfo) {
                $page = 1;
                $limit = 12;
                $key = '';
                $data = Model_Product::getInstance()->getProductByOwner($page, $limit, $dataInfo[DbTable_Product_Own::COL_PRODUCT_OWN_ID]);
                $productOwnerData = $data ? $data[Application_Constant_Global::KEY_DATA] : array();
                $total = $data ? $data[Application_Constant_Global::KEY_TOTAL] : 0;
                $totalPage = ($total - 1) / $limit + 1;
                Application_Function_Pagination_Default::getInstance()->initialize($totalPage, $page);
                $this->view->assign('pagination', Application_Function_Pagination_Default::getInstance()->show());
                $this->view->assign('productData', $productOwnerData);
                $keyword = $dataInfo[DbTable_Product_Own::COL_PRODUCT_OWN_PHONE] ? $dataInfo[DbTable_Product_Own::COL_PRODUCT_OWN_PHONE] : '';
                $keyword = $dataInfo[DbTable_Product_Own::COL_PRODUCT_OWN_NAME] . ', ' . $keyword;
                $titleArray = array();
                if ($dataInfo[DbTable_Product_Own::COL_PRODUCT_OWN_NAME]) {
                    $titleArray[] = $dataInfo[DbTable_Product_Own::COL_PRODUCT_OWN_NAME];
                }
                if ($dataInfo[DbTable_Product_Own::COL_PRODUCT_OWN_PHONE]) {
                    $titleArray[] = $dataInfo[DbTable_Product_Own::COL_PRODUCT_OWN_PHONE];
                }
                $this->setMetaData(
                    implode(' - ', $titleArray).' | Thông tin người đăng Phòng cho thuê - Nhà cho thuê | Xome.vn',
                    $keyword,
                    'Thông tin người đăng cho thuê phòng trọ, nhà trọ '
                );

            }
            $this->view->assign('dataInfo', $dataInfo);
            $this->view->assign('menuHeader', Application_Constant_Identify::MENU_HEADER_MOTEL_OWNER_INFO);
        } else {
            $this->goto404();
        }

    }


}
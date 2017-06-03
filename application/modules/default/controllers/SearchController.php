<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 11/27/2016
 * Time: 9:15 AM
 */
class SearchController extends Application_Controller_FrontEnd_Default
{
    public function preDispatch()
    {
        $this->_helper->layout->setLayoutPath(APPLICATION_PATH . '/modules/default/views/scripts/search');
    }

    public function indexAction()
    {
        $limit = 200;
        $category = $this->getParam('category');
        $district = $this->getParam('district');
        $province = 79;
        $object = $this->getParam('object');

        $page = $this->getParam('page', 1);
        $query = $this->getParam('key');
        $facility = $this->getParam('facility');
        $area = $this->getParam('area');
        $priceValue = $this->getParam('price-value');
        $lat = $this->getParam('lat');
        $lng = $this->getParam('lng');


        $priceBegin = 0;
        $priceEnd = 30000000;

        $areaBegin = 0;
        $areaEnd = 1000;

        if ($priceValue) {
            if ($priceValue == 1) {
                $priceBegin = 0;
                $priceEnd = 1000000;
            }
            if ($priceValue == 2) {
                $priceBegin = 1000000;
                $priceEnd = 3000000;
            }
            if ($priceValue == 3) {
                $priceBegin = 3000000;
                $priceEnd = 5000000;

            }
            if ($priceValue == 4) {
                $priceBegin = 5000000;
                $priceEnd = 10000000;

            }
            if ($priceValue == 5) {
                $priceBegin = 10000000;
                $priceEnd = 0;

            }
        }

        if ($area) {
            if ($area == 1) {
                $areaBegin = 0;
                $areaEnd = 20;
            }
            if ($area == 2) {
                $areaBegin = 20;
                $areaEnd = 30;
            }
            if ($area == 3) {
                $areaBegin = 30;
                $areaEnd = 50;

            }
            if ($area == 4) {
                $areaBegin = 50;
                $areaEnd = 0;

            }
        }

        if ($lat && $lng) {

        }

        if ($district) {
            $limit = 100;
        }
        $metaTitle = 'Bản đồ tìm kiếm | Nhà trọ - Phòng trọ tại Hồ Chí Minh';
        $metaContent = 'Danh sách phòng trọ, nhà trọ cho thuê tại thành phố Hồ Chí Minh';
        $data = Model_Product::getInstance()->searchQuery($page, $limit, $query, $category, $facility, $priceBegin, $priceEnd, $province, $district, $object, $areaBegin, $areaEnd, true, $lat, $lng);
        $productData = $data ? $data[Application_Constant_Global::KEY_DATA] : array();
        $total = $data ? $data[Application_Constant_Global::KEY_TOTAL] : 0;
        $productData = $productData ? $productData->toArray() : null;
        $this->view->assign('productSearchData', $productData);
        //var_dump($productData);
        //$total = count($productData);
        $totalPage = ($total - 1) / $limit + 1;
        #Query String
        $params = $this->getRequest()->getParams();
        $queryPagination = array();
        foreach ($params as $key => $value) {
            if (in_array($key, array('key', 'category', 'province', 'district', 'price-value', 'area', 'object','lat','lng'))) {
                array_push($queryPagination, sprintf('%s=%s', $key, $value));
                $this->view->assign($key, $value);
            }
        }

        #Query String
        Application_Function_Pagination_Default::getInstance()->initialize($totalPage, $page);
        Application_Function_Pagination_Default::getInstance()->setQuery('&' . implode('&', $queryPagination));
        $this->view->assign('pagination', Application_Function_Pagination_Default::getInstance()->show());
        $this->view->assign('priceValue', $priceValue);
        $this->view->assign('queryPagination', implode('&', $queryPagination));

        $this->setMetaData(
            $metaTitle,
            $this->getTranslateValue('common_keywords'),
            $metaContent
        );
    }

    public function aroundAction()
    {
        $limit = 100;
        $radius = 0.5;
        $province = 79;
        $productIdentify = $this->getParam('productIdentify');
        $product = Model_Product::getInstance()->getDetail($productIdentify);

        if ($product) {
            $lat = $product[DbTable_Product::COL_PRODUCT_LAT];
            $lng = $product[DbTable_Product::COL_PRODUCT_LONG];
            if ($lat && $lng) {
                $data = Model_Product::getInstance()->searchAround($lat, $lng, $radius, $limit);
                $productData = $data ? $data[Application_Constant_Global::KEY_DATA] : array();

                $productData = $productData ? $productData->toArray() : null;
                $this->view->assign('productSearchData', $productData);


            }
            $this->view->assign('dataInfo', $product);
            $des = $product[DbTable_Product::COL_PRODUCT_SHORT_DESCRIPTION] ? $product[DbTable_Product::COL_PRODUCT_SHORT_DESCRIPTION] : $this->getTranslateValue('common_description');
            $this->setMetaData(
                $product[DbTable_Product::COL_PRODUCT_NAME],
                $this->getTranslateValue('common_keywords'),
                strip_tags($des)
            );

            $url = 'http://xome.ln3.in/statics/asset/default/img/home.png';
            if ($product[DbTable_Product::COL_PRODUCT_THUMB_NAIL]) {
                $url = 'http://xome.ln3.in/upload' . $product[DbTable_Product::COL_PRODUCT_THUMB_NAIL];
            }
            if (!$product[DbTable_Product::COL_PRODUCT_FLAG_UPLOAD_IMAGE]) {
                $url = $product[DbTable_Product::COL_PRODUCT_THUMB_NAIL];
            }
            $this->setMetaImage($url);

        } else {
            $this->goto404();
        }


    }
}
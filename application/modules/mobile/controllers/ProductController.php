<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/20/2016
 * Time: 1:11 PM
 */
class Mobile_ProductController extends Application_Controller_FrontEnd_Default
{

    public function preDispatch()
    {
        // $this->view->assign('menuHeader', Application_Constant_Identify::MENU_HEADER_PRODUCT);
    }


    public function indexAction()
    {

        $categoryIdentify = $this->getParam('categoryIdentify');
        $category = null;
        $categoryData = null;
        $component = null;
        $category = Model_ProductCategory::getInstance()->getByIdentify($categoryIdentify);

        if ($category) {

            if ($category[DbTable_Product_Category::COL_PRODUCT_CATEGORY_ID] == 1) {

                $this->view->assign('menuHeader', Application_Constant_Identify::MENU_HEADER_MOTEL);
            }
            if ($category[DbTable_Product_Category::COL_PRODUCT_CATEGORY_ID] == 2) {

                $this->view->assign('menuHeader', Application_Constant_Identify::MENU_HEADER_MOTEL_ROOM);
            }
            if ($category[DbTable_Product_Category::COL_PRODUCT_CATEGORY_ID] == 3) {

                $this->view->assign('menuHeader', Application_Constant_Identify::MENU_HEADER_MOTEL_ROOM_TRANSPLANT);
            }
        }


        $page = $this->getParam('page', 1);
        $limit = 8;
        $data = Model_Product::getInstance()->getListing($page, $limit, $component[DbTable_Product_Component::COL_PRODUCT_COMPONENT_ID], $category[DbTable_Product_Category::COL_PRODUCT_CATEGORY_ID]);

        $productData = $data ? $data[Application_Constant_Global::KEY_DATA] : array();
        $total = $data ? $data[Application_Constant_Global::KEY_TOTAL] : 0;
        $totalPage = ($total - 1) / $limit + 1;
        Application_Function_Pagination_Default::getInstance()->initialize($totalPage, $page);
        $this->view->assign('pagination', Application_Function_Pagination_Default::getInstance()->show());

        if ($component) {
            $categoryData = array();
            $categoryComponentData = $this->_helper->filterArrayWithCondition(
                Model_ProductCategory::getInstance()->getAll(),
                DbTable_Product_Category::COL_FK_PRODUCT_COMPONENT,
                $component[DbTable_Product_Component::COL_PRODUCT_COMPONENT_ID]
            );
            $parentCategory = $this->_helper->buildArrayInKeyAttributeWithCondition(
                $categoryComponentData,
                DbTable_Product_Category::COL_PRODUCT_CATEGORY_ID,
                DbTable_Product_Category::COL_PRODUCT_CATEGORY_NAME,
                DbTable_Product_Category::COL_PRODUCT_CATEGORY_PARENT_ID,
                null
            );

            foreach ($parentCategory as $key => $productCategoryName) {
                $categoryInfo[Application_Constant_Db_Product_Category::CATEGORY_INFO] = $productCategoryName;
                $categoryInfo[Application_Constant_Db_Product_Category::CATEGORY_SUB_CATEGORY] = $this->_helper->filterArrayWithCondition(
                    $categoryComponentData,
                    DbTable_Product_Category::COL_PRODUCT_CATEGORY_PARENT_ID,
                    $key
                );
                if ($categoryInfo[Application_Constant_Db_Product_Category::CATEGORY_SUB_CATEGORY]) {
                    $categoryData[$key] = $categoryInfo;
                }

            }
        }

        $this->view->assign('productData', $productData);
        $this->view->assign('productCategoryData', $categoryData);
        $this->view->assign('productCategory', $category);

    }

    public function detailAction()
    {
        $productIdentify = $this->getParam('productIdentify');
        $product = Model_Product::getInstance()->getDetail($productIdentify);

        if ($product) {
            $productImage = Model_ProductImage::getInstance()->getByFkProduct($product[DbTable_Product::COL_PRODUCT_ID]);
            $productImage = $productImage ? $productImage->toArray() : array();
            $this->view->assign('dataInfo', $product);
            $this->view->assign('productImageData', $productImage);
            $data = Model_Product::getInstance()->getListing(1, 8, 1, $product[DbTable_Product::COL_PRODUCT_CATEGORY_ID]);
            $productRelationData = $data ? $data[Application_Constant_Global::KEY_DATA] : array();
            $this->view->assign('productRelationData', $productRelationData);
            $this->noGlobalSlide();
            if ($product[DbTable_Product::COL_PRODUCT_CATEGORY_ID]) {

                if ($product[DbTable_Product::COL_PRODUCT_CATEGORY_ID] == 1) {

                    $this->view->assign('menuHeader', Application_Constant_Identify::MENU_HEADER_MOTEL);
                }
                if ($product[DbTable_Product::COL_PRODUCT_CATEGORY_ID] == 2) {

                    $this->view->assign('menuHeader', Application_Constant_Identify::MENU_HEADER_MOTEL_ROOM);
                }
                if ($product[DbTable_Product::COL_PRODUCT_CATEGORY_ID] == 3) {

                    $this->view->assign('menuHeader', Application_Constant_Identify::MENU_HEADER_MOTEL_ROOM_TRANSPLANT);
                }
            }

        } else {
            $this->goto404();
        }

    }

    public function searchAction()
    {
        $category = $this->getParam('category');
        $district = $this->getParam('district');
        $province = 79;
        $object = $this->getParam('object');

        $page = $this->getParam('page', 1);
        $query = $this->getParam('key');
        $facility = $this->getParam('facility');
        $area = $this->getParam('area');
        $priceValue = $this->getParam('price-value');


        $priceBegin = 300000;
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

        $limit = 8;
        $data = Model_Product::getInstance()->searchQuery($page, $limit, $query, $category, $facility, $priceBegin, $priceEnd, $province, $district, $object);
        $productData = $data ? $data[Application_Constant_Global::KEY_DATA] : array();
        $total = $data ? $data[Application_Constant_Global::KEY_TOTAL] : 0;
        $productData = $productData ? $productData->toArray() : null;
        $this->view->assign('productSearchData', $productData);

        //$total = count($productData);
        $totalPage = ($total - 1) / $limit + 1;
        #Query String
        $params = $this->getRequest()->getParams();
        $queryPagination = array();
        foreach ($params as $key => $value) {
            if (in_array($key, array('key', 'category', 'province', 'district', 'price-value', 'area', 'object'))) {
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


    }


    public function addAction()
    {
		 if(!$this->getCustomerLoginId()){
            $this->gotoUrl('/tai-khoan/dang-nhap.html');
        }
		
        $data = Model_Product::getInstance()->getListing(1, 8, 1, 1);
        $productRelationData = $data ? $data[Application_Constant_Global::KEY_DATA] : array();
        $this->view->assign('productRelationData', $productRelationData);
        $categoryId = 1;
        $this->view->assign('categoryId', $categoryId);
        //$this->view->assign('menuHeader', 'product-add');
    }

    public function submitAddAction()
    {

        $customerId = $this->getCustomerLoginId();
        $name = $this->getRequest()->getParam('name');
        $phone = $this->getRequest()->getParam('phone');
        $referCode = null;
        $originalPrice = 0;
        $promotionPrice = 0;
        $paidPrice = $this->getRequest()->getParam('paid_price');
        $component = 1;
        $categoryId = $this->getRequest()->getParam('categoryId', 1);

        $description = $this->getRequest()->getParam('description');
        $shortDescription = null;
        $note = null;
        $address = $this->getRequest()->getParam('address');
        $area = $this->getRequest()->getParam('area');
        $facilityArrId = $this->getRequest()->getParam('facility');
        $own = $this->getRequest()->getParam('own');
        $district = $this->getRequest()->getParam('district');
        $object = $this->getRequest()->getParam('object');


        $elementName = 'file_image';
        $image = $this->getRequest()->getParam('image');
        if (isset($_FILES[$elementName]) && $_FILES[$elementName]['name']) {
            $image = $this->uploadImage('product', $elementName);
        }

        $pos = strpos($description, ' ', 100);
        if ($pos > 0)
            $shortDescription = substr($description ['description'], 0, $pos);

        $id = Admin_Model_Product::getInstance()->insert($name, $referCode, $categoryId, $originalPrice, $paidPrice, $image, $description, $component, $note, $shortDescription, $promotionPrice, $address, $area, $own, $phone, $object, $district, $customerId);

        if (intval($id)) {
            if ($facilityArrId) {
                foreach ($facilityArrId as $facilityId) {
                    Admin_Model_ProductFacility::getInstance()->insert($facilityId, $id);
                }
            }
        }

        $this->gotoUrl('/nguoi-cho-thue/dang-tin-thanh-cong/');
        $this->view->assign('menuHeader', 'product-add');
        $this->noRender();


    }

    public function addSuccessAction()
    {
        $data = Model_Product::getInstance()->getListing(1, 8, 1, 1);
        $productRelationData = $data ? $data[Application_Constant_Global::KEY_DATA] : array();
        $this->view->assign('productRelationData', $productRelationData);
    }

    public function provinceAction()
    {
        $districtIdentify = $this->getRequest()->getParam('districtIdentify');

        $districtIdentify = str_replace(array("quan-", "huyen-"), "", $districtIdentify);
        $province = 79;

        $district = Model_District::getInstance()->getByIdentify($districtIdentify);
        $districtId = null;


        if ($district) {
            $districtId = $district[DbTable_District::COL_DISTRICT_ID];
        }


        $page = $this->getParam('page', 1);
        $limit = 8;
        $data = Model_Product::getInstance()->getListingByProvince($page, $limit, $province, $districtId);

        $productData = $data ? $data[Application_Constant_Global::KEY_DATA] : array();
        $total = $data ? $data[Application_Constant_Global::KEY_TOTAL] : 0;
        $totalPage = ($total - 1) / $limit + 1;
        Application_Function_Pagination_Default::getInstance()->initialize($totalPage, $page);
        $this->view->assign('pagination', Application_Function_Pagination_Default::getInstance()->show());
        $this->view->assign('productData', $productData);


    }


}
<?php

class Admin_ProductController extends Application_Controller_BackEnd_Admin
{
    public function indexAction()
    {
        $name = $this->getRequest()->getParam('n');
        $code = $this->getRequest()->getParam('e');
        $category = $this->getRequest()->getParam('c');
        $active = Application_Constant_Db_Config_Active::ACTIVE;// $this->getRequest()->getParam('a', -1);
        $priority = $this->getRequest()->getParam('p', -1);
        $this->loadGird(Admin_Model_Product::getInstance()->searchQuery($name, $code, $category, $active, $priority));

        $this->view->assign('name', $name);
        $this->view->assign('code', $code);
        $this->view->assign('category', $category);
        $this->view->assign('priority', $priority);

    }

    public function pendingAction()
    {
        $name = $this->getRequest()->getParam('n');
        $code = $this->getRequest()->getParam('e');
        $category = $this->getRequest()->getParam('c');
        $active = Application_Constant_Db_Config_Active::PENDING;
        $priority = $this->getRequest()->getParam('p', -1);
        $this->loadGird(Admin_Model_Product::getInstance()->searchQuery($name, $code, $category, $active, $priority));

        $this->view->assign('name', $name);
        $this->view->assign('code', $code);
        $this->view->assign('category', $category);
        $this->view->assign('priority', $priority);

    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('i');
        $processFlag = $this->getParam('processFlag', Application_Constant_Db_Config_Active::PENDING);
        $categoryData = Admin_Model_ProductCategory::getInstance()->getAllProductCategory();
        $dataInfo = Admin_Model_Product::getInstance()->getById($id);
        $dataInfo = $dataInfo ? $dataInfo->current() : null;
        $this->view->assign('categoryData', $this->_helper->buildArrayInKeyAttribute($categoryData, DbTable_Product_Category::COL_PRODUCT_CATEGORY_ID, DbTable_Product_Category::COL_PRODUCT_CATEGORY_NAME));
        $this->view->assign('dataInfo', $dataInfo);
        $componentData = Admin_Model_ProductComponent::getInstance()->getAll();
        $this->view->assign('componentData', $this->_helper->buildArrayInKeyAttribute($componentData, DbTable_Product_Component::COL_PRODUCT_COMPONENT_ID, DbTable_Product_Component::COL_PRODUCT_COMPONENT_NAME));

        $facilityData = Admin_Model_ConfigProductFacility::getInstance()->getAll();
        $this->view->assign('facilityData', $facilityData);
        $facilityArr = Admin_Model_ProductFacility::getInstance()->searchByProductId($id);
        /*$this->view->assign('facilityArr', $facilityArr);*/


        $districtData = $this->_helper->buildArrayInKeyAttributeWithCondition(
            Admin_Model_District::getInstance()->getAll(),
            DbTable_District::COL_DISTRICT_ID,
            DbTable_District::COL_DISTRICT_NAME,
            DbTable_District::COL_DISTRICT_PROVINCE,
            79
        );
        $this->view->assign('districtData', $districtData);

        $this->view->assign(
            'facilityArr',
            $facilityArr ? $this->_helper->buildArrayByKey(
                $facilityArr,
                DbTable_Product_Facility::COL_FACILITY_ID
            ) : array()
        );

        $this->view->assign('processFlag', $processFlag);

    }

    public function submitEditAction()
    {
        $id = $this->getRequest()->getParam('id');
        $name = $this->getRequest()->getParam('name');
        $referCode = $this->getRequest()->getParam('referCode');
        $originalPrice = $this->getRequest()->getParam('original_price', 0);
        $promotionPrice = $this->getRequest()->getParam('promotion_price', 0);
        $paidPrice = $this->getRequest()->getParam('paid_price');
        $component = $this->getRequest()->getParam('componentId');
        $category = $this->getRequest()->getParam('category');
        $description = $this->getRequest()->getParam('description');
        $shortDescription = $this->getRequest()->getParam('shortDescription');
        $note = $this->getRequest()->getParam('note');
        $address = $this->getRequest()->getParam('address');
        $area = $this->getRequest()->getParam('area');
        $phone = $this->getRequest()->getParam('phone');
        $nameRealEst = $this->getRequest()->getParam('own');

        $facilityArrId = $this->getRequest()->getParam('facilityArrId');

        $object = $this->getRequest()->getParam('object');
        $district = $this->getRequest()->getParam('district');
        $lat = $this->getRequest()->getParam('lat');
        $lng = $this->getRequest()->getParam('lng');
        $flagNoImport = 1;

        $processFlag = $this->getParam('processFlag', Application_Constant_Db_Config_Active::PENDING);


        $elementName = 'file_image';
        $image = $this->getRequest()->getParam('image');
        if (isset($_FILES[$elementName]) && $_FILES[$elementName]['name']) {
            $image = $this->uploadImage('product', $elementName);
        }
        if (!$shortDescription) {
            $shortDescription = strip_tags($description);
            $pos = strpos($shortDescription, ' ', 100);
            $shortDescription = substr($description, 0, $pos);
        }
        $message = null;
        if ($id) {
            $message = Admin_Model_Product::getInstance()->update($id, $name, $referCode, $category, $originalPrice, $paidPrice, $image, $description, $component, $note, $shortDescription, $promotionPrice, $address, $area, $nameRealEst, $phone, $object, $district, $lat, $lng, $flagNoImport);
        } else {
			$processFlag = Application_Constant_Db_Config_Active::PENDING;
            $id = Admin_Model_Product::getInstance()->insert($name, $referCode, $category, $originalPrice, $paidPrice, $image, $description, $component, $note, $shortDescription, $promotionPrice, $address, $area, $nameRealEst, $phone, $object, $district, $lat, $lng, $flagNoImport);
            if (intval($id) == 0) {
                $message = $id;
            }
        }

        if ($message) {
            $this->alertSubmitError($message);
        } else {
            Admin_Model_ProductFacility::getInstance()->deleteByProductId($id);
            if ($facilityArrId) {
                foreach ($facilityArrId as $facilityId) {
                    $msg = Admin_Model_ProductFacility::getInstance()->insert($facilityId, $id);
                }
            }
            if ($processFlag == Application_Constant_Db_Config_Active::PENDING) {
                $this->redirectSubmit('product/pending');
            }
            if ($processFlag == Application_Constant_Db_Config_Active::ACTIVE) {
                $this->redirectSubmit('product');
            }
            $this->redirectSubmit('product');
        }

        $this->noRender();
    }

    public function manualUpdateAction()
    {
        $manualUpdateId = $this->getRequest()->getParam('manualUpdateId');
        $manualUpdateAction = $this->getRequest()->getParam('manualUpdateAction');
        $manualUpdateUrl = $this->getRequest()->getParam('manualUpdateUrl');

        $manualUpdateAction = strtolower(trim($manualUpdateAction));

        $idValue = explode(',', $manualUpdateId);
        if ($idValue) {
            if (in_array($manualUpdateAction, array('activate', 'inactivate'))) {
                $valueActive = $manualUpdateAction == 'activate' ?
                    Application_Constant_Db_Config_Active::ACTIVE : Application_Constant_Db_Config_Active::INACTIVE;
                Admin_Model_Product::getInstance()->manualUpdateActive($valueActive, $idValue);
                if ($valueActive == Application_Constant_Db_Config_Active::ACTIVE) {
                    $customerData = Admin_Model_Product::getInstance()->searchCustomerByProductId($idValue);
                    $customerData = $customerData ? $customerData->toArray() : array();
                    foreach ($customerData as $customer) {
                        if ($customer[DbTable_Customer::COL_CUSTOMER_EMAIL]) {
                            $url = Admin_Model_Product::getInstance()->generateUrl($customer[DbTable_Product::COL_PRODUCT_ID]);
                            $this->view->assign('customerName', $customer[DbTable_Customer::COL_CUSTOMER_NAME]);
                            $this->view->assign('url', $url);
                            $this->doSendMail($customer[DbTable_Customer::COL_CUSTOMER_EMAIL], $customer[DbTable_Customer::COL_CUSTOMER_NAME], 'Xác nhận đăng tin cho thuê', $this->view->render('mail-templates/update-product-active.phtml'));
                        }
                    }
                }

            }
            if (in_array($manualUpdateAction, array('deleted', 'approved'))) {
                $valueActive = $manualUpdateAction == 'deleted' ?
                    Application_Constant_Db_Config_Active::DELETED : Application_Constant_Db_Config_Active::APPROVED;
                Admin_Model_Product::getInstance()->manualUpdateActive($valueActive, $idValue);
            }
        }

        $this->gotoUrl($manualUpdateUrl);
        $this->noRender();
    }

    public function manualPriorityAction()
    {
        $manualUpdateId = $this->getRequest()->getParam('manualUpdateId');
        $manualUpdateAction = $this->getRequest()->getParam('manualUpdateAction');
        $manualUpdateUrl = $this->getRequest()->getParam('manualUpdateUrl');

        $valueActive = intval($manualUpdateAction);

        $idValue = explode(',', $manualUpdateId);
        if ($idValue) {
            Admin_Model_Product::getInstance()->manualUpdatePriority($valueActive, $idValue);
        }

        $this->gotoUrl($manualUpdateUrl);
        $this->noRender();
    }

    public function approvedAction()
    {
        $name = $this->getRequest()->getParam('n');
        $code = $this->getRequest()->getParam('e');
        $category = $this->getRequest()->getParam('c');
        $active = Application_Constant_Db_Config_Active::APPROVED;
        $priority = $this->getRequest()->getParam('p', -1);
        $this->loadGird(Admin_Model_Product::getInstance()->searchQuery($name, $code, $category, $active, $priority));

        $this->view->assign('name', $name);
        $this->view->assign('code', $code);
        $this->view->assign('category', $category);
        $this->view->assign('priority', $priority);
    }

    public function deletedAction()
    {
        $name = $this->getRequest()->getParam('n');
        $code = $this->getRequest()->getParam('e');
        $category = $this->getRequest()->getParam('c');
        $active = Application_Constant_Db_Config_Active::DELETED;
        $priority = $this->getRequest()->getParam('p', -1);
        $this->loadGird(Admin_Model_Product::getInstance()->searchQuery($name, $code, $category, $active, $priority));

        $this->view->assign('name', $name);
        $this->view->assign('code', $code);
        $this->view->assign('category', $category);
        $this->view->assign('priority', $priority);
    }
}

<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/21/2016
 * Time: 2:40 PM
 */
class Admin_ProductOrderController extends Application_Controller_BackEnd_Admin
{
    public function indexAction(){
        $fkActive = $this->getRequest ()->getParam ( 'a' , -1);
        $code = $this->getRequest ()->getParam ( 'e' );
        $userName = $this->getRequest ()->getParam ( 'n' );
        $phone = $this->getRequest ()->getParam ( 'p' );
        $email =  $this->getRequest ()->getParam ( 'm' );

        $id = Admin_Model_ProductOrder::getInstance()->decode($code);

        $this->loadGird ( Admin_Model_ProductOrder::getInstance()->searchQuery($id, $userName, $phone, $email, $fkActive));

        $this->view->assign ( 'active', $fkActive );
        $this->view->assign ( 'code', $code );
        $this->view->assign ( 'userName', $userName );
        $this->view->assign ( 'phone', $phone );
        $this->view->assign ( 'email', $email );
    }

    public function detailAction(){
        $encode = $this->getRequest ()->getParam ( 'e' );
        $id = Admin_Model_ProductOrder::getInstance()->decode($encode);
        if($id){
            $orderData = Admin_Model_ProductOrder::getInstance()->getById($id);
            $orderData = $orderData ? $orderData->current() : array();
            $productData = Admin_Model_ProductProductOrder::getInstance()->getByFkOrder($id);
            $total = $this->_helper->calculateArrayByKey(
                $productData,
                Application_Constant_Global::KEY_TOTAL
            );
            $this->view->assign ( 'orderData', $orderData );
            $this->view->assign ( 'productData', $productData );
            $this->view->assign ( 'totalPrice', $total );
        }
        $provinceData = Admin_Model_Province::getInstance()->getAll();
        $this->view->assign ( 'idEncode', $encode );
        $this->view->assign ( 'provinceData', $provinceData);
        $this->view->assign ( 'statusData', Admin_Model_ProductOrder::getInstance()->getOrderStatus());


    }

    public function updateStatusAction(){
        $encode = $this->getRequest ()->getParam ( 'encode' );
        $id = Admin_Model_ProductOrder::getInstance()->decode($encode);
        $status = $this->getRequest ()->getParam ( 'status' );
        $message = '';
        if($id){
            $message =  Admin_Model_ProductOrder::getInstance()->manualUpdateActive($status, $id);

            $this->gotoUrl('/product-order/detail/?e=' . $encode);
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
            if (in_array($manualUpdateAction, array('deleted', 'inactivate'))) {
                $valueActive = $manualUpdateAction == 'deleted' ? Application_Constant_Db_Config_Active::DELETED : Application_Constant_Db_Config_Active::INACTIVE;
                Admin_Model_ProductOrder::getInstance()->manualUpdateActive($valueActive, $idValue);
            }
        }

        $this->gotoUrl($manualUpdateUrl);
        $this->noRender();
    }

    public function updateNoteAction(){

        $encode = $this->getRequest ()->getParam ( 'encode' );
        $id = Admin_Model_ProductOrder::getInstance()->decode($encode);
        $note = $this->getRequest ()->getParam ( 'note' );

        if($id){
            Admin_Model_ProductOrder::getInstance()->updateNote($id, $note);

            $this->gotoUrl('/product-order/detail/?e=' . $encode);
        }
        $this->noRender();
    }
}
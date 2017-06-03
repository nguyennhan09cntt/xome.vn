<?php
class Admin_ProductImageController extends Application_Controller_BackEnd_Admin {
	
	public function indexAction() {
		$fkActive = $this->getRequest ()->getParam ( 'a', -1 );
		$product = $this->getRequest ()->getParam ( 'p' );
		$this->loadGird ( Admin_Model_ProductImage::getInstance ()->searchQuery($product, $fkActive) );
		
		$this->view->assign ( 'product', $product );
		$this->view->assign ( 'active', $fkActive );
	}
	
	public function editAction() {
		$id = $this->getRequest ()->getParam ( 'i' );
		$product = $this->getRequest ()->getParam ( 'p' );
		$dataInfo = Admin_Model_ProductImage::getInstance ()->getById ( $id );
		$dataInfo = $dataInfo ? $dataInfo->current () : null;	
		if($dataInfo){
			$product = $dataInfo[DbTable_Product_Image::COL_FK_PRODUCT];
		}
		$this->view->assign ( 'dataInfo', $dataInfo );
		$this->view->assign ( 'product', $product );
	}
	
	public function submitEditAction() {
		$id = $this->getRequest ()->getParam ( 'id' );		
		$note = $this->getRequest ()->getParam ( 'note' );
		$product = $this->getRequest ()->getParam ( 'product' );
		$image = $this->getRequest()->getParam('image');
		
		$elementName = 'file_image';
		
		if (isset($_FILES[$elementName]) && $_FILES[$elementName]['name']) {
			$image = $this->uploadImage('product-image', $elementName);
		}
		
		$message = null;
		if ($id) {
			$message = Admin_Model_ProductImage::getInstance ()->update ($id, $image, $note, $product);
		} else {
			$message = Admin_Model_ProductImage::getInstance ()->insert ($image, $note, $product);
		}
		
		if ($message) {
			$this->alertSubmitError ( $message );
		} else {
			$this->redirectSubmit ( 'product-image/?p='.$product );
		}
		
		$this->noRender ();
	}
	public function manualUpdateAction() {
		$manualUpdateId = $this->getRequest ()->getParam ( 'manualUpdateId' );
		$manualUpdateAction = $this->getRequest ()->getParam ( 'manualUpdateAction' );
		$manualUpdateUrl = $this->getRequest ()->getParam ( 'manualUpdateUrl' );
		
		$manualUpdateAction = strtolower ( trim ( $manualUpdateAction ) );
		
		$idValue = explode ( ',', $manualUpdateId );
		if ($idValue) {
			if (in_array ( $manualUpdateAction, array (
					'activate',
					'inactivate' 
			) )) {
				$valueActive = $manualUpdateAction == 'activate' ? Application_Constant_Db_Config_Active::ACTIVE : Application_Constant_Db_Config_Active::INACTIVE;
				Admin_Model_ProductImage::getInstance ()->manualUpdateActive ( $valueActive, $idValue );
			}
		}
		
		$this->gotoUrl ( $manualUpdateUrl );
		$this->noRender ();
	}
}


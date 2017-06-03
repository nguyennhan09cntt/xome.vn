<?php
class Admin_SiteSlideController extends Application_Controller_BackEnd_Admin {
	
	public function indexAction() {
		$fkActive = $this->getRequest ()->getParam ( 'a', -1 );
		$name = $this->getRequest ()->getParam ( 'n' );
		$this->loadGird ( Admin_Model_SiteSlide::getInstance ()->searchQuery($name, $fkActive) );
		
		$this->view->assign ( 'name', $name );
		$this->view->assign ( 'active', $fkActive );
	}
	
	public function editAction() {
		$id = $this->getRequest ()->getParam ( 'i' );	
		$dataInfo = Admin_Model_SiteSlide::getInstance ()->getById ( $id );
		$dataInfo = $dataInfo ? $dataInfo->current () : null;			
		$this->view->assign ( 'dataInfo', $dataInfo );
	
	}
	
	public function submitEditAction() {
		$id = $this->getRequest ()->getParam ( 'id' );		
		$name = $this->getRequest ()->getParam ( 'name' );
		
		$image = $this->getRequest()->getParam('image');
		
		$elementName = 'file_image';
		
		if (isset($_FILES[$elementName]) && $_FILES[$elementName]['name']) {
			$image = $this->uploadImage('site-slide', $elementName);
		}
		
		$message = null;
		if ($id) {
			$message = Admin_Model_SiteSlide::getInstance ()->update ($id, $name, $image);
		} else {
			$message = Admin_Model_SiteSlide::getInstance ()->insert ( $name, $image);
		}
		
		if ($message) {
			$this->alertSubmitError ( $message );
		} else {
			$this->redirectSubmit ( 'site-slide/' );
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
				Admin_Model_SiteSlide::getInstance ()->manualUpdateActive ( $valueActive, $idValue );
			}
		}
		
		$this->gotoUrl ( $manualUpdateUrl );
		$this->noRender ();
	}
}


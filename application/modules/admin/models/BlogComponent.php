<?php
class Admin_Model_BlogComponent extends Application_Singleton {
	
	/**
	 *
	 * @var Admin_Model_Dao_BlogComponent
	 */
	private $_dao;
	
	protected function __construct() {
		$this->_dao = new Admin_Model_Dao_BlogComponent ();
	}
	
	/**
	 * Get all components
	 * @return array
	 */
	public function getAll()
	{
		$result = array();
        $key = Application_Cache_Admin::getInstance()->blogComponent();
        $result = Application_Cache::getInstance()->load($key);
        if (!$result) {
            $data = $this->_dao->fetchAll();
            if ($data) {
                foreach ($data as $item) {
                    $result[$item->{DbTable_Blog_Component::COL_BLOG_COMPONENT_ID}] = $item->toArray();
                }               
            }
            Application_Cache::getInstance()->save($result, $key, Application_Constant_Cache::BLOG_COMPONENT_LIFE_TIME);
        }
        return $result;
	}
	
	
}
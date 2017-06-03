<?php
class Admin_Model_Dao_BlogCategory extends DbTable_Blog_Category {
	
	/*
	 * @param int $componentId        	
	 * @param string $name        	
	 * @param int $status        	
	 * @return Zend_Db_Table_Select
	 */
	public function searchQuery($componentId, $name, $status) {
		$select = $this->select ();
		if ($componentId) {
			$select->where ( DbTable_Blog_Category::COL_FK_COMPONENT . ' =? ', $componentId );
		}
		if ($status >-1) {
			$select->where ( DbTable_Blog_Category::COL_FK_CONFIG_STATUS . ' =? ', $status );
		}
		if ($name) {
			$select->where ( sprintf ( '%s like %s', new Zend_Db_Expr ( 'LOWER(' . DbTable_Blog_Category::COL_BLOG_CATEGORY_NAME . ')' ), $this->getAdapter ()->quote ( '%' . strtolower ( $name ) . '%' ) ) );
		}
		return $select;
	}
	/**
	 * get all
	 *
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function getAll() {
		return $this->fetchAll ( $this->select ()->where ( DbTable_Blog_Category::COL_FK_CONFIG_STATUS . '=? ', 1 ) );
	}
	
	/**
	 * get all parent category
	 *
	 */
	public function getAllParentCategory(){
		$select = $this->select ()
		->where(DbTable_Blog_Category::COL_BLOG_CATEGORY_PARENT_ID . ' is null')
		->order ( DbTable_Blog_Category::COL_BLOG_CATEGORY_NAME . ' asc' );
		return $this->fetchAll($select);
	}
}
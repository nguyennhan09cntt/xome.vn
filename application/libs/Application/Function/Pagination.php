<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 3/21/15
 * Time: 8:59 AM
 */
class Application_Function_Pagination extends Application_Singleton
{
    protected $_intStep 	= 5;			# số trang hiển thị trên layout
    protected $_intPage 	= null;		# số thứ tự trang hiện tại
    protected $_intTotalPage= null;	# tổng số trang
    protected $_strAction 	= null;		# hàm javascript được gọi khi có sự kiện nhấn vào trang
    protected $_strActionP 	= null;		# hàm javascript được gọi khi có sự kiện nhấn vào trang
    protected $_strUrl 		= null ;
    protected $_strQuery 	= null;

    protected function __construct()
    {

    }

    /**
     * Initialize pagination
     * @param int $p_intTotalPage
     * @param int $p_intPage
     */
    public function initialize($p_intTotalPage, $p_intPage)
    {
        $this->_intTotalPage = $p_intTotalPage;
        $this->_intPage = $p_intPage;
    }

    /**
     * Set javascript method
     * @param string $p_strAction
     */
    public function setAction($p_strAction)
    {
        $this->_strAction = $p_strAction;
    }

    /**
     * Set parameters
     * @param string $p_strParam
     */
    public function setActionParam($p_strParam)
    {
        $this->_strActionP = $p_strParam;
    }

    /**
     * Set Url
     * @param string $p_strUrl
     */
    public function setUrl($p_strUrl)
    {
        $this->_strUrl = $p_strUrl;
    }

    /**
     * Set query
     * @param string $p_strQuery
     */
    public function setQuery($p_strQuery)
    {
        $this->_strQuery = $p_strQuery;
    }

    protected function _getHref($p_intPage)
    {

        $strResult = null;
        if ($this->_strAction) {
            if($this->_strActionP){
                $strResult = 'javascript:'.$this->_strAction.'('.($p_intPage).', '.($this->_strActionP).')';
            }
            else{
                $strResult = 'javascript:'.$this->_strAction.'('.($p_intPage).')';
            }
        }
        else {
            $strResult = $this->_strUrl. '?page=' . $p_intPage . $this->_strQuery;
        }
        return $strResult;
    }
}
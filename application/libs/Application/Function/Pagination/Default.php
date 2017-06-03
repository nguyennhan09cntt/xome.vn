<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 3/21/15
 * Time: 8:58 AM
 */
class Application_Function_Pagination_Default extends Application_Function_Pagination
{
    protected function __construct()
    {

    }

    /**
     * Show pagination
     * @return string
     */
    public function show()
    {
        $strResult 	= '';
        if ($this->_intPage < $this->_intStep) {
            $intStart = 1;
        } else {
            $intStart = floor(($this->_intPage-1)/ $this->_intStep)*$this->_intStep + 1;
        }
        $intEnd = $intStart + $this->_intStep;
        $intEnd = $intEnd<=$this->_intTotalPage ? $intEnd : $this->_intTotalPage;
        /*
        if ($intStart>1) {
            $strResult.='<li><a href="'.$this->_getHref(1).'" aria-label="Previous"><span aria-hidden="true"><i class="fa fa-angle-left"></i></span></a></li>';
        }*/
        if ($this->_intPage>1) {
            $strResult.='<li><a href="'.$this->_getHref($this->_intPage-1).'" aria-label="Previous"><span aria-hidden="true"><i class="fa fa-angle-left"></i></span></a></li>';
        }
        for ($i=$intStart; $i<=$intEnd; $i++) {
            if ($i!=$this->_intPage) {
                $strPage = '<li><a href="'.$this->_getHref($i).'">'.$i.'</a></li>';
            } else {
                $strPage = '<li class="active"><a href="'. $this->_getHref($i) .'" >'.$i.'</a></li>';
            }
            $strResult .= $strPage;
        }
        if ($intEnd < $this->_intTotalPage) {
            #$strResult.='<li><a href="'.$this->_getHref($this->_intPage+1).'">&gt;</a></li>';
            $strResult.='<li><a href="'.$this->_getHref($this->_intPage+1).'" aria-label="Next"><span aria-hidden="true"><i class="fa fa-angle-right"></i></span></a></li>';
            #$strResult.='<li><a href="'.$this->_getHref($this->_intTotalPage).'" aria-label="Next"><span aria-hidden="true"><i class="fa fa-angle-right"></i></span></a></li>';
        }
        return sprintf('<ul class="pagination f_right">%s</ul>', $strResult);
    }
}
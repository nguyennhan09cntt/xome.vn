<?php

/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/9/15
 * Time: 10:51 AM
 */
class Admin_View_Helper_ShowImage extends Zend_View_Helper_Abstract
{
    public function showImage($image, $width = 0, $import = false)
    {

        $path = $import ? '': '/upload/';
        $image = $image ? $image : 'no-image.png';
        return sprintf(
            '<img src="%s%s" %s />',
            $path,
            $image,
            $width ? sprintf('width=%d', $width) : ''
        );
    }
}
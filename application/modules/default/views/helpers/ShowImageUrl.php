<?php

/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/9/15
 * Time: 10:51 AM
 */
class View_Helper_ShowImageUrl extends Zend_View_Helper_Abstract
{
    public function showImageUrl($image, $import = false, $width = 330)
    {
        $link = 'https://images1-focus-opensocial.googleusercontent.com/gadgets/proxy?container=focus&resize_w=' . $width;
        $path = $import ? '' : 'http://xome.ln3.in/upload/';
        if (!$path && !$image) {
            $image = 'no-image.png';
        }
        $image = $image ? $image : 'no-image.png';
        return sprintf(
            '%s&url=%s%s',
            $link,
            $path,
            $image
        );
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/9/15
 * Time: 11:12 AM
 */
class Controller_Helper_GenerateImageName extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($fileName)
    {
        $fileInfo = explode('.', $fileName);
        $extension = $fileInfo[count($fileInfo)-1];
        return sprintf('%s.%s', time(). rand(1,100), $extension);
    }
}
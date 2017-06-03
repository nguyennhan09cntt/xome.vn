<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 5/13/15
 * Time: 9:59 AM
 */
class Cli_BlogController extends Application_Controller_Cli
{

    public function cleanAction(){
        $blogData = Cli_Model_Blog::getInstance()->getAll();
        foreach($blogData as $data){
            $content =$data[DbTable_Blog::COL_BLOG_CONTENT];
            $content = preg_replace("/<\/?a[^>]*>/", "", $content);
            $content = preg_replace("/<script\b[^>]*>(.*?)<\/script>/is", "", $content);
            Admin_Model_Blog::getInstance()->updateContent($data[DbTable_Blog::COL_BLOG_ID], $content);

        }
    }
}
<?php
class Application_Function_Folder
{
    /**
     * Remove folder
     * @param string $path
     */
    public static function removePath($path)
    {
        if(is_dir($path))
        {
            $arrDir = scandir($path);
            foreach($arrDir as $dir)
            {
                if(in_array($dir, array('.', '..'))){
                    continue;
                }
                self::removePath($path.'/'.$dir);
            }
            rmdir($path);
        }
        else{
            unlink($path);
        }
    }

    /**
     * Parse path to component & create folder
     * @param string $root_folder
     * @param string $path
     * @param string $separated
     * @return void
     */
    public static function createFolderFollowPath($root_folder, $path, $separated='/')
    {
        $info = explode('/', $path);
        $folderPath = $root_folder;
        foreach($info as $folder)
        {
            if( strstr($folder, '.') ){
                continue;
            }
            $folderPath .= '/'.$folder;
            if( !is_dir($folderPath) ){
                mkdir($folderPath);
            }
        }
    }

}
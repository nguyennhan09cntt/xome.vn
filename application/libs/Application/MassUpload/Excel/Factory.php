<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/11/15
 * Time: 3:53 PM
 */
class Application_MassUpload_Excel_Factory
{
    /**
     * @param string $component
     * @return Application_MassUpload_Excel_Abstract
     */
    static public function factory($component)
    {
        $componentClass = sprintf('Application_MassUpload_Excel_Component_%s', $component);
        return new $componentClass();
    }
}
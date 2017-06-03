<?php

/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/23/15
 * Time: 9:55 AM
 */
class Application_Cache_Admin extends Application_Cache
{

    public function adminModule()
    {
        return Application_Constant_Cache::ADMIN_MODULE;
    }

    public function resetAdminModule()
    {
        $this->remove($this->adminModule());
    }

    public function adminPrivilege()
    {
        return Application_Constant_Cache::ADMIN_PRIVILEGE;
    }

    public function resetAdminPrivilege()
    {
        $this->remove($this->adminPrivilege());
    }

    public function adminAcl($roleId)
    {
        return Application_Constant_Cache::ADMIN_ACL . $roleId;
    }

    public function resetadminAcl($roleId)
    {
        $this->remove($this->adminAcl($roleId));
    }

    public function adminInfo()
    {
        return Application_Constant_Cache::ADMIN_INFO;
    }

    public function adminPermission($adminId)
    {
        return Application_Constant_Cache::ADMIN_PERMISSION . $adminId;
    }

    public function resetAdminPermission($adminId)
    {
        $this->remove($this->adminPermission($adminId));
    }

    public function configComponent()
    {
        return Application_Constant_Cache::CONFIG_COMPONENT;
    }

    public function resetConfigComponent()
    {
        $this->remove($this->configComponent());
    }

    public function configActive()
    {
        return Application_Constant_Cache::CONFIG_ACTIVE;
    }

    public function resetConfigActive()
    {
        $this->remove($this->configActive());
    }


    public function component()
    {
        return Application_Constant_Cache::COMPONENT;
    }

    public function resetComponent()
    {
        $this->remove($this->component());
    }

    public function category()
    {
        return Application_Constant_Cache::COMPONENT;
    }

    public function resetCategory()
    {
        $this->remove($this->category());
    }

    public function blogComponent()
    {
        return Application_Constant_Cache::BLOG_COMPONENT;
    }

    public function resetBlogComponent()
    {
        $this->remove($this->blogComponent());
    }

    public function blogCategory()
    {
        return Application_Constant_Cache::BLOG_CATEGORY;
    }

    public function resetBlogCategory()
    {
        $this->remove($this->blogCategory());
    }

    public function blogCategoryAllInfo()
    {
        return Application_Constant_Cache::BLOG_CATEGORY;
    }

    public function resetBlogCategoryAllInfo()
    {
        $this->remove($this->blogCategoryAllInfo());
    }

    public function productCategory()
    {
        return Application_Constant_Cache::PRODUCT_CATEGORY;
    }

    public function resetProductCategory()
    {
        $this->remove($this->productCategory());
    }

    public function productCategoryAllInfo()
    {
        return Application_Constant_Cache::PRODUCT_CATEGORY_ALL_INFO;
    }

    public function resetProductCategoryAllInfo()
    {
        $this->remove($this->productCategoryAllInfo());
    }

    public function productCategoryAll()
    {
        return Application_Constant_Cache::PRODUCT_CATEGORY_ALL;
    }

    public function resetProductCategoryAll()
    {
        $this->remove($this->productCategoryAll());
    }

    public function districtAllInfo()
    {
        return Application_Constant_Cache::DISTRICT_ALL_INFO;
    }

    public function resetDistrictAllInfo()
    {
        $this->remove($this->districtAllInfo());
    }

    public function provinceAllInfo()
    {
        return Application_Constant_Cache::PROVINCE_ALL_INFO;
    }

    public function resetProvinceAllInfo()
    {
        $this->remove($this->provinceAllInfo());
    }

    public function configPayment()
    {
        return Application_Constant_Cache::CONFIG_PAYMENT;
    }

    public function resetConfigPayment()
    {
        $this->remove($this->configPayment());
    }

    public function productComponentAllInfo()
    {
        return Application_Constant_Cache::PRODUCT_COMPONENT_ALL_INFO;
    }

    public function resetProductComponentAllInfo()
    {
        $this->remove($this->productComponentAllInfo());
    }

    public function configProductFacility()
    {
        return Application_Constant_Cache::CONFIG_PRODUCT_FACILITY;
    }
}
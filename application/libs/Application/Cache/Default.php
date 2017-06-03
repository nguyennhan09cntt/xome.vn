<?php

/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/9/15
 * Time: 1:38 PM
 */
class Application_Cache_Default extends Application_Cache
{
    public function siteSlideAllInfo()
    {
        return Application_Constant_Cache::SITE_SLIDE_ALL_INFO;
    }

    public function resetSiteSlideAllInfo()
    {
        return $this->remove($this->siteSlideAllInfo());
    }

    public function homeProduct()
    {
        return Application_Constant_Cache::HOME_PRODUCT_ALL_INFO;
    }

    public function resetHomeProduct()
    {
        return $this->remove($this->homeProduct());
    }

    public function homeBlog()
    {
        return Application_Constant_Cache::HOME_BLOG_ALL_INFO;
    }

    public function resetHomeBlog()
    {
        return $this->remove($this->homeBlog());
    }

    public function productSale()
    {
        return Application_Constant_Cache::PRODUCT_SALE_ALL_INFO;
    }

    public function resetProductSale()
    {
        return $this->remove($this->productSale());
    }

    public function productListing($componentId, $category)
    {
        return Application_Constant_Cache::PRODUCT_LISTING_ALL_INFO . $componentId . '_' . $category;
    }

    public function resetProductListing($componentId, $category)
    {
        return $this->remove($this->productListing($componentId, $category));
    }

    public function blogNewListing()
    {
        return Application_Constant_Cache::BLOG_NEW_LISTING;
    }

    public function resetBlogNewListing()
    {
        return $this->remove($this->blogNewListing());
    }

    public function newsListingBlog($category)
    {
        return Application_Constant_Cache::BLOG_NEW_LISTING . '_' . $category;
    }

    public function resetNewsListingBlog($category)
    {
        return $this->remove($this->newsListingBlog($category));
    }

    public function resetPromotionListing($fkComponent)
    {
        return $this->remove($this->promotionListing($fkComponent));
    }

    public function promotionListing($fkComponent)
    {
        return Application_Constant_Cache::PROMOTION_LISTING . '_' . $fkComponent;
    }

    public function promotionDetail($id)
    {
        return Application_Constant_Cache::PROMOTION_DETAIL . '_' . $id;
    }

    public function resetPromotionDetail($id)
    {
        return $this->remove($this->promotionDetail($id));
    }

    public function contactListing($componentId, $category)
    {
        return Application_Constant_Cache::CONTACT_LISTING_ALL_INFO . $componentId . '_' . $category;
    }

    public function resetContactListing($componentId, $category)
    {
        return $this->remove($this->contactListing($componentId, $category));
    }


    public function productListingProvince($province, $district)
    {
        return Application_Constant_Cache::PRODUCT_LISTING_PROVINCE . '_' . $province . '_' . $district;
    }

    public function resetProductListingProvince($province, $district)
    {
        return $this->remove($this->productListingProvince($province, $district));
    }

}
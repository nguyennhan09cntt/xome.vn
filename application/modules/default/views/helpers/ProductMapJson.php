<?php

/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/5/15
 * Time: 9:25 AM
 */
class View_Helper_ProductMapJson extends Zend_View_Helper_Abstract
{
    public function productMapJson($productList = array())
    {
        $productArray = array();
        $dataDistrict = Model_District::getInstance()->getAll();
        $categoryData = Model_ProductCategory::getInstance()->getAll();
        foreach ($productList as $product) {
            $link = 'https://images1-focus-opensocial.googleusercontent.com/gadgets/proxy?container=focus&resize_w=' . 330;
            $path = !$product[DbTable_Product::COL_PRODUCT_FLAG_UPLOAD_IMAGE] ? '' : 'http://xome.ln3.in/upload';
            $image = $product[DbTable_Product::COL_PRODUCT_THUMB_NAIL];
            if (!$path && !$image) {
                $image = 'http://xome.ln3.in/upload/no-image.png';
            }
            $image = $image ? $image : 'no-image.png';

            $image = sprintf(
                '%s&url=%s%s',
                $link,
                $path,
                $image
            );
            $district = isset($dataDistrict[$product[DbTable_Product::COL_FK_DISTRICT]]) ? $dataDistrict[$product[DbTable_Product::COL_FK_DISTRICT]][DbTable_District::COL_DISTRICT_TYPE] . ' ' . $dataDistrict[$product[DbTable_Product::COL_FK_DISTRICT]][DbTable_District::COL_DISTRICT_NAME] : '';
            $link = '/' . $categoryData[$product[DbTable_Product::COL_PRODUCT_CATEGORY_ID]][DbTable_Product_Category::COL_PRODUCT_CATEGORY_IDENTIFY] . '/ho-chi-minh/' . $dataDistrict[$product[DbTable_Product::COL_FK_DISTRICT]][DbTable_District::COL_DISTRICT_IDENTIFY] . '/' . $product[DbTable_Product::COL_PRODUCT_IDENTIFY] . '-' . Model_Product::getInstance()->encode($product[DbTable_Product::COL_PRODUCT_ID]);
            $price = $product[DbTable_Product::COL_PRODUCT_PAID_PRICE];
            if($price > 0){
              $price =  $product[DbTable_Product::COL_PRODUCT_PAID_PRICE]/1000000 >= 1 ?  ($product[DbTable_Product::COL_PRODUCT_PAID_PRICE]/1000000 .'tr' ): ($product[DbTable_Product::COL_PRODUCT_PAID_PRICE]/1000 .'k');
            }else{
                $price = 'Thỏa thuận';
            }
            $productInfo = array(
                'latitude' => $product[DbTable_Product::COL_PRODUCT_LAT],
                'longitude' => $product[DbTable_Product::COL_PRODUCT_LONG],
                'title' => $product[DbTable_Product::COL_PRODUCT_NAME],
                "price" => $price,
                'area' => $product[DbTable_Product::COL_PRODUCT_AREA],
                'phone' => $product[DbTable_Product::COL_PRODUCT_PHONE],
                'image' => $image,
                'district' => $district,
                'link' => $link

            );
            $productArray[] = $productInfo;
        }
        return (json_encode($productArray));

    }
}
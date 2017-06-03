cd<?php
header('Content-type: text/html; charset=UTF-8');
/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 11/12/2016
 * Time: 9:30 PM
 */
require_once 'simple_html_dom/simple_html_dom.php';

class Cli_ProductController extends Application_Controller_Cli
{


    private function getDistrictId($identify)
    {
        $districtData = array(
            "quan-1" => 760,
            "quan-12" => 761,
            "quan-thu-duc" => 762,
            "quan-9" => 763,
            "quan-go-vap" => 764,
            "quan-binh-thanh" => 765,
            "quan-tan-binh" => 766,
            "quan-tan-phu" => 767,
            "quan-phu-nhuan" => 768,
            "quan-2" => 769,
            "quan-3" => 770,
            "quan-10" => 771,
            "quan-11" => 772,
            "quan-4" => 773,
            "quan-5" => 774,
            "quan-6" => 775,
            "quan-8" => 776,
            "quan-binh-tan" => 777,
            "quan-7" => 778,
            "huyen-cu-chi" => 783,
            "huyen-hoc-mon" => 784,
            "huyen-binh-chanh" => 785,
            "huyen-nha-be" => 786,
            "huyen-can-gio" => 787,
        );
        return isset($districtData[$identify]) ? $districtData[$identify] : null;
    }

    /**
     * Usage: php cli.php -m cli -c product -a import
     */
    public function importAction()
    {


       /* $category = array(
            1 => array(
                'phongtro123.com' => array(
                    'component' => 1,
                    'export' => 1,
                    'site' => 'https://phongtro123.com',
                    'url' => 'https://phongtro123.com/tim-kiem/page/%s',
                    'page' => '%s',
                    //'size' => 80,
                    'size' => 50,
                    'item' => array(
                        'container' => 'ul.list-post li.post-item',
                        'title' => '.post_info  span.post-title',
                        'description' => '.post_info .p_content',
                        'district' => 'span.address a',
                        'url' => '.post_info a.post-link',
                        'image' => 'img.photo_item_image',
                        'content' => '#motachitiet',
                        'price' => '.summary_item_info_price',
                        'area' => '.summary_item_info_area',
                        'phone' => '.post_summary_right .summary_item_info a',
                        'address' => '.fullwidth .summary_item_info'
                    )
                )

            ),*/
            /*
            2 => array(
                'phongtro123.com' => array(
                    'component' => 1,
                    'export' => 1,
                    'site' => 'https://phongtro123.com',
                    'url' => 'https://phongtro123.com/tim-kiem/page/%s',
                    'page' => '%s',
                    // 'size' => 620,
                    'size' => 50,
                    'item' => array(
                        'container' => 'ul.list-post li.post-item',
                        'title' => '.post_info  span.post-title',
                        'description' => '.post_info .p_content',
                        'district' => 'span.address a',
                        'url' => '.post_info a.post-link',
                        'image' => 'img.photo_item_image',
                        'content' => '#motachitiet',
                        'price' => '.summary_item_info_price',
                        'area' => '.summary_item_info_area',
                        'phone' => '.post_summary_right .summary_item_info a',
                        'address' => '.fullwidth .summary_item_info'
                    )
                )

            ),
            3 => array(
                'phongtro123.com' => array(
                    'component' => 1,
                    'export' => 1,
                    'site' => 'https://phongtro123.com',
                    'url' => 'https://phongtro123.com/tim-kiem/page/%s',
                    'page' => '%s',
                    //'size' => 245,
                    'size' => 50,
                    'item' => array(
                        'container' => 'ul.list-post li.post-item',
                        'title' => '.post_info  span.post-title',
                        'description' => '.post_info .p_content',
                        'district' => 'span.address a',
                        'url' => '.post_info a.post-link',
                        'image' => 'img.photo_item_image',
                        'content' => '#motachitiet',
                        'price' => '.summary_item_info_price',
                        'area' => '.summary_item_info_area',
                        'phone' => '.post_summary_right .summary_item_info a',
                        'address' => '.fullwidth .summary_item_info'
                    )
                )

            )
        );*/


        $category = array(
           /* 1 => array(
                'phongtro123.com' => array(
                    'component' => 1,
                    'export' => 1,
                    'site' => 'https://phongtro123.com',
                    'url' => 'https://phongtro123.com/tim-kiem/page/%s',
                    'page' => '%s',
                    //'size' => 80,
                    'size' => 3,
                    'item' => array(
                        'container' => 'ul.list-post li.post-item',
                        'title' => '.post_info  span.post-title',
                        'description' => '.post_info .p_content',
                        'district' => 'span.address a',
                        'url' => '.post_info a.post-link',
                        'image' => 'img.photo_item_image',
                        'content' => '#motachitiet',
                        'price' => '.summary_item_info_price',
                        'area' => '.summary_item_info_area',
                        'phone' => '.post_summary_right .summary_item_info a',
                        'address' => '.fullwidth .summary_item_info'
                    )
                )

            ),
            3 => array(
                'phongtro123.com' => array(
                    'component' => 1,
                    'export' => 1,
                    'site' => 'https://phongtro123.com',
                    'url' => 'https://phongtro123.com/tim-kiem/page/%s',
                    'page' => '%s',
                    //'size' => 245,
                    'size' => 5,
                    'item' => array(
                        'container' => 'ul.list-post li.post-item',
                        'title' => '.post_info  span.post-title',
                        'description' => '.post_info .p_content',
                        'district' => 'span.address a',
                        'url' => '.post_info a.post-link',
                        'image' => 'img.photo_item_image',
                        'content' => '#motachitiet',
                        'price' => '.summary_item_info_price',
                        'area' => '.summary_item_info_area',
                        'phone' => '.post_summary_right .summary_item_info a',
                        'address' => '.fullwidth .summary_item_info'
                    )
                )
            ),*/
            2 => array(
                'phongtro123.com' => array(
                    'component' => 1,
                    'export' => 1,
                    'site' => 'https://phongtro123.com',
                    'url' => 'https://phongtro123.com/tim-kiem/page/%s',
                    'page' => '%s',
                    //'size' => 80,
                    'size' => 6,
                    'item' => array(
                        'container' => 'ul.list-post li.post-item',
                        'title' => '.post_info  span.post-title',
                        'description' => '.post_info .p_content',
                        'district' => 'span.address a',
                        'url' => '.post_info a.post-link',
                        'image' => 'img.photo_item_image',
                        'content' => '#motachitiet',
                        'price' => '.summary_item_info_price',
                        'area' => '.summary_item_info_area',
                        'phone' => '.post_summary_right .summary_item_info a',
                        'address' => '.fullwidth .summary_item_info'
                    )
                ),

            ),

        );

        foreach ($category as $categoryId => $categoryData) {
            foreach ($categoryData as $categoryIdentify => $category) {
                $size = $category['size'];
                for ($i = $size; $i >= 1; $i--) {
                    //for ($i = 1; $i < $size; $i++) {
                    $component = $category['component'];
                    $site = $category['site'];
                    $page = '';

                    $page = sprintf($category['page'], $i);

                    $link = sprintf($category['url'], $page);
                    $query = array();
                    $query[1] = '?q&type=Nhà+thuê+nguyên+căn&tinh=90&quan=0&phuongxa=0&duong=0&price=0&dientich=0&doituong=0';
                    $query[2] = '?q&type=Ph%C3%B2ng+tr%E1%BB%8D%2C+nh%C3%A0+tr%E1%BB%8D&tinh=90&quan&phuongxa&duong&price=0&dientich=0&doituong=0';
                    $query[3] = '?q=&type=Tìm+bạn+ở+ghép&tinh=90&quan=0&phuongxa=0&duong=0&price=0&dientich=0&doituong=0';
                    $link = $link . $query[$categoryId];
                    $formatItem = $category['item'];
                    $export = $category['export'];
                    $result = $this->getListing($link, $formatItem, $categoryId, $component, $site, $export);

                    if (!$result)
                        break;
                }
            }

        }


        var_dump('DONE : IMPORT');
    }


    private function getListing($url, $item, $categoryId, $componentId, $site, $export)
    {
        var_dump('BEGIN ' . $url);
        $html_dom = $this->file_get_html($url);

        if (isset($html_dom) && count($html_dom->find($item['container'])) == 0)
            return false;

        foreach ($html_dom->find($item['container']) as $e) {
            $element = array();

            if (isset($e->find($item['url'])[0])) {
                $element ['identify'] = $e->find($item['url'])[0]->href;
                $element ['name'] = html_entity_decode($e->find($item['title'])[0]->innertext);

                $element ['uri'] = Application_Function_String::getFormatUrl($element ['name']);
                //$element ['price'] = $e->find('span.promo_price')[0]->innertext;
                $district = html_entity_decode($e->find($item['district'])[0]->innertext);
                $district = Application_Function_String::getFormatUrl($district);
                $district = str_replace('-ho-chi-minh', '', $district);
                $element['district'] = $this->getDistrictId($district);
                $element ['description'] = '';
                if ($item['description']) {
                    if (isset($e->find($item['description'])[0])) {
                        $element ['description'] = html_entity_decode($e->find($item['description'])[0]->innertext);
                    }

                }
                $element ['category'] = $categoryId;
                $element ['thumb_nail'] = '';


                $element ['identify'] = $this->removeDomain($site, $element ['identify']);

                $result = $this->getContentByLink($site . $element ['identify'], $item);
                $element ['content'] = $result['content'];
                $element ['phone'] = $result['phone'];
                $element ['price'] = $result['price'];
                $element ['area'] = $result['area'];
                $element ['address'] = $result['address'];


                $element ['src'] = $site . $element ['identify'];

            }

           // var_dump($element);


            if ($element && $element ['content']) {

                $thumbnail = '';

                $phone = $element['phone'];
                $price = floatval($element['price']);
                $price = $price > 100 ? $price * 1000 : $price * 1000000;
                $address = $element['address'];
                $area = $element['area'];

                $str = Cli_Model_Product::getInstance()->insert($element ['name'], $thumbnail, $element ['content'], $element ['description'], $categoryId, $componentId, $thumbnail, $element['src'], $phone, $area, $price, $element ['uri'], $address, $element['district']);
                if ($str) {
                    var_dump($str);
                }

            }


        }

        var_dump('DONE ' . $url);
        return true;
    }

    public function getContentByLink($url, $item)
    {
        $result = array();

        // base url
        // $base = 'http://www.sendo.vn/nhip-song/diem-danh-cac-kieu-toc-dep-hua-hen-gay-bao-2016/';
        $html_dom = $this->file_get_html($url);//print_r($html_dom->find('#template_wrapper'));
        ;
        //file_put_contents('03-29-2016_112122.txt', print_r($html_dom->find('#template_wrapper'), TRUE));
        #var_dump($html_dom->getElementById('introduction_course_wrap'));

        if (!$html_dom)
            return '';
        // 1. create HTML Dom
        // $html = file_get_html('http://www.sendo.vn/nhip-song/diem-danh-cac-kieu-toc-dep-hua-hen-gay-bao-2016/');
        // var_dump();
        // $html = file_get_html('http://www.google.com/');

        // find all div tags with class=td-post-content
        if ($html_dom->find($item['content'])) {
            $result['price'] = $this->formatNumber($html_dom->find($item['price'])[0]->innertext);
            $result['phone'] = html_entity_decode($html_dom->find($item['phone'])[0]->innertext);
            $result['area'] = $this->formatNumber($html_dom->find($item['area'])[0]->innertext);
            $result['address'] = $html_dom->find($item['address'])[0]->innertext;
            $result['content'] = html_entity_decode($html_dom->find($item['content'])[0]->innertext);
            return $result;
        }

        return '';
    }

    private function file_get_html($baseUrl)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_URL, $baseUrl);
        curl_setopt($curl, CURLOPT_REFERER, $baseUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');
        $str = curl_exec($curl);
        if (!$str)
            return $str;
        curl_close($curl);
        $html_base = new simple_html_dom ();
        // Load HTML from a string
        $html_base->load($str);
        return $html_base;
    }

    private function clean($string)
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

        return $string;
    }

    private function formatNumber($string)
    {
        $string = preg_replace('/[^0-9\.]/', '', $string); // Removes special chars.
        return $string;
    }

    private function getBackgroundImage($style)
    {
        $string = str_replace(')', '', $style); // Replaces all ) with null.
        $string = str_replace('(', '', $string); // Replaces all ) with null.
        $string = preg_replace('/background-image: url/', '', $string); // Removes special chars.
        return $string;
    }

    public function writeFile($name, $content)
    {
        //    $name='D:/JAVA_WEB/workspace/rest-client/data/'.date('m-d-Y_his').'.txt';
        /*$dataListFile = fopen($name, 'w');


        fwrite($dataListFile, $content);
        fclose($dataListFile);*/
        file_put_contents($name, $content, FILE_APPEND | LOCK_EX);
    }

    public function removeDomain($site, $url)
    {
        $string = str_replace(' ', '-', $url); // Replaces all spaces with hyphens.
        $string = str_replace($site, '', $string);

        return $string;
    }

    public function cloneThumbnail($thumbnailUrl, $width = 371, $height = 177, $flagImage = false)
    {
        $imageArray = array();
        $imagePath = null;
        $url = strtok($thumbnailUrl, '?');
        $fileName = basename($url, '?');
        /* var_dump(
             $fileName
         );*/
        if ($fileName) {
            $folder = $this->getUploadPath() . '/' . 'news-blog';
            if (!is_dir($folder)) {
                mkdir($folder);
            }
            $folder = $folder . '/' . date('Y');
            if (!is_dir($folder)) {
                mkdir($folder);
            }
            $folder = $folder . '/' . date('m');
            if (!is_dir($folder)) {
                mkdir($folder);
            }
            $folder = $folder . '/' . date('d');
            if (!is_dir($folder)) {
                mkdir($folder);
            }

            $imagePath = sprintf('%s/%s', $folder, $this->_helper->generateImageName($fileName));
            try {
                file_put_contents($imagePath, file_get_contents($thumbnailUrl));
                Application_Function_Image::crop($imagePath, $imagePath, $width, $height);
                if ($flagImage) {
                    $position = strpos($imagePath, '.');
                    if ($position) {
                        $image550x300 = substr_replace($imagePath, '_550x300', $position, 0);
                        Application_Function_Image::crop($imagePath, $image550x300, 550, 300);
                        $image550x300 = str_replace($this->getUploadPath(), '', $image550x300);
                        $imageArray[1] = $image550x300;
                    }

                }

                $imagePath = str_replace($this->getUploadPath(), '', $imagePath);
            } catch (Exception $ex) {
                $imagePath = null;
            }


        }
        $imageArray[0] = $imagePath;
        return $imageArray;
    }
}
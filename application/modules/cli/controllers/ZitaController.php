<?php
header('Content-type: text/html; charset=UTF-8');
/**
 * Created by PhpStorm.
 * User: nguyennhan09cntt
 * Date: 11/12/2016
 * Time: 9:30 PM
 */
require_once 'simple_html_dom/simple_html_dom.php';

class Cli_ZitaController extends Application_Controller_Cli
{

    /**
     * Method return district id
     * @param $identify
     * @return null| array
     */
    private function getDistrictId($identify)
    {
        $districtData = array(
            "quan-1" => 760,
            "quan-12" => 761,
            "thu-duc" => 762,
            "quan-9" => 763,
            "go-vap" => 764,
            "binh-thanh" => 765,
            "tan-binh" => 766,
            "tan-phu-2" => 767,
            "phu-nhuan" => 768,
            "quan-2" => 769,
            "quan-3" => 770,
            "quan-10" => 771,
            "quan-11" => 772,
            "quan-4" => 773,
            "quan-5" => 774,
            "quan-6" => 775,
            "quan-8" => 776,
            "binh-tan" => 777,
            "quan-7" => 778,
            "cu-chi" => 783,
            "hoc-mon" => 784,
            "binh-chanh" => 785,
            "nha-be" => 786,
            "can-gio" => 787,
        );
        return isset($districtData[$identify]) ? $districtData[$identify] : null;
    }

    /**
     * Usage: php cli.php -m cli -c zita -a import
     */
    public function importAction()
    {

        $districtData = array(
            "quan-1" => 760,
            "quan-12" => 761,
            "thu-duc" => 762,
            "quan-9" => 763,
            "go-vap" => 764,
            "binh-thanh" => 765,
            "tan-binh" => 766,
            "tan-phu-2" => 767,
            "phu-nhuan" => 768,
            "quan-2" => 769,
            "quan-3" => 770,
            "quan-10" => 771,
            "quan-11" => 772,
            "quan-4" => 773,
            "quan-5" => 774,
            "quan-6" => 775,
            "quan-8" => 776,
            "binh-tan" => 777,
            "quan-7" => 778,
            "cu-chi" => 783,
            "hoc-mon" => 784,
            "binh-chanh" => 785,
            "nha-be" => 786,
            "can-gio" => 787,
        );


        $category = array(

            2 => array(
                'zita.vn' => array(
                    'component' => 1,
                    'export' => 1,
                    'site' => 'https://zita.vn',
                    'url' => 'https://www.zita.vn/cho-thue-nha-tro-phong-tro/tp-ho-chi-minh/%s?%s',
                    'page' => 'page=%s',
                    'size' => 2,
                    'item' => array(
                        'container' => '#resultList .card-item',
                        'title' => 'h2.property-title',
                        'description' => '.post_info .p_content',
                        'district' => 'span.address .glyphicon-map-marker',
                        'url' => 'a.card',
                        'image' => '.img-responsive',
                        'content-container' => '#content',
                        'content' => '.property-content',
                        'price' => '.prop-summary tr td',
                        'area' => '.prop-summary tr td',
                        'phone' => '.contactBtn',
                        'address' => '.address',
                        'own' => '.agentName',
                        'images' => 'a.swiper-slide'
                    )
                )
            ),
            1 => array(
                'zita.vn' => array(
                    'component' => 1,
                    'export' => 1,
                    'site' => 'https://zita.vn',
                    'url' => 'https://www.zita.vn/cho-thue-nha-rieng/tp-ho-chi-minh/%s?%s',
                    'page' => 'page=%s',
                    'size' => 3,
                    'item' => array(
                        'container' => '#resultList .card-item',
                        'title' => 'h2.property-title',
                        'description' => '.post_info .p_content',
                        'district' => 'span.address .glyphicon-map-marker',
                        'url' => 'a.card',
                        'image' => '.img-responsive',
                        'content-container' => '#content',
                        'content' => '.property-content',
                        'price' => '.prop-summary tr td',
                        'area' => '.prop-summary tr td',
                        'phone' => '.contactBtn',
                        'address' => '.address',
                        'own' => '.agentName',
                        'images' => 'a.swiper-slide'
                    )
                )
            )

        );

        foreach ($category as $categoryId => $categoryData) {
            foreach ($categoryData as $categoryIdentify => $category) {
                foreach ($districtData as $districtIdentify => $district) {
                    $size = $category['size'];
                    for ($i = $size; $i >= 1; $i--) {

                        $component = $category['component'];
                        $site = $category['site'];
                        $page = '';
                        $page = sprintf($category['page'], $i);
                        $link = sprintf(
                            $category['url'],
                            $districtIdentify,
                            $page
                        );


                        $query = array();
                        $query[1] = '?q&type=Nhà+thuê+nguyên+căn&tinh=90&quan=0&phuongxa=0&duong=0&price=0&dientich=0&doituong=0';
                        $query[2] = '?q&type=Ph%C3%B2ng+tr%E1%BB%8D%2C+nh%C3%A0+tr%E1%BB%8D&tinh=90&quan&phuongxa&duong&price=0&dientich=0&doituong=0';
                        $query[3] = '?q=&type=Tìm+bạn+ở+ghép&tinh=90&quan=0&phuongxa=0&duong=0&price=0&dientich=0&doituong=0';

                        $formatItem = $category['item'];
                        $export = $category['export'];
                        $result = '';


                        $result = $this->getListing($link, $formatItem, $categoryId, $component, $site, $export, $district);

                        /* if (!$result)
                             break;*/
                    }
                }
            }

        }


        var_dump('DONE : IMPORT');
        var_dump('BEGIN TRUNCATE ');
        $this->removeDuplicate();
        var_dump('DONE TRUNCATE');
    }


    private function getListing($url, $item, $categoryId, $componentId, $site, $export, $district)
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


                $element ['category'] = $categoryId;
                $property = 'data-original';
                $element ['thumb_nail'] = $this->get_string_between(html_entity_decode($e->find($item['image'])[0]->$property), 'url=', '&');

                $element ['identify'] = $this->removeDomain($site, $element ['identify']);
                $element ['description'] = '';

                $element ['content'] = null;
                // $element ['address'] = strip_tags(html_entity_decode($e->find($item['address'])[0]->innertext));
                $element ['src'] = $site . $element ['identify'];

                $result = $this->getContentByLink($site . $element ['identify'], $item);
                if ($result) {
                    $element ['content'] = preg_replace("/<\/?a[^>]*>/", "", $result['content']);
                    $element ['phone'] = $result['phone'];
                    $element ['price'] = $result['price'];
                    $element ['area'] = $result['area'];
                    $element ['address'] = $result['address'];
                    $element['images'] = $result['images'];
                    $element ['description'] = str_replace('Nội dung   ', '', strip_tags($element ['content']));
                    $pos = strpos($element ['description'], ' ', 100);
                    $element ['description'] = substr($element ['description'], 0, $pos);
                    $element ['own'] = $result['own'];
                }

            }


            if ($element && $element ['content']) {

                $thumbnail = $element['thumb_nail'];

                $phone = $element['phone'];
                $element['price'] = str_replace(',', '.', $element['price']);
                $price = floatval($element['price']);
                $price = $price > 500 ? $price * 1000 : $price * 1000000;
                $address = $element['address'];
                $area = $element['area'];
                var_dump($element ['uri']);
                $dataItem = Cli_Model_Product::getInstance()->getDetail($element ['uri']);
                $dataItem = $dataItem ? $dataItem->toArray() : null;

                if(!$dataItem){
                    $str = Cli_Model_Product::getInstance()->insert($element ['name'], $thumbnail, $element ['content'], $element ['description'], $categoryId, $componentId, $thumbnail, $element['src'], $phone, $area, $price, $element ['uri'], $address, $district, $element ['own']);
                    if (!intval($str)) {
                        var_dump($str);
                    } else {
                        $id = intval($str);
                        foreach ($element['images'] as $image) {
                            Admin_Model_ProductImage::getInstance()->insert($image, $element['name'], $id, true);
                        }

                    }
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
        if ($html_dom->find($item['content-container'])) {
            $result['price'] = $this->formatNumber($html_dom->find($item['price'])[0]->innertext);
            $result['phone'] = $this->formatNumber(html_entity_decode($html_dom->find($item['phone'])[0]->innertext));
            $result['area'] = $this->formatNumber($html_dom->find($item['area'])[1]->innertext);
            $result['address'] = strip_tags(html_entity_decode($html_dom->find($item['address'])[0]->innertext));
            $result['content'] = html_entity_decode($html_dom->find($item['content'])[0]->innertext);
            $result['own'] = html_entity_decode($html_dom->find($item['own'])[0]->innertext);
            foreach ($html_dom->find($item['images']) as $imageElement) {
                $result['images'][] = 'http://zita.vn' . $imageElement->href;
            }

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
        $string = preg_replace('/[^0-9\,]/', '', $string); // Removes special chars.
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

    private function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    /**
     * php cli.php -m cli -c zita -a remove-duplicate
     */
    public function removeDuplicateAction()
    {
        $this->removeDuplicate();
    }

    private function removeDuplicate()
    {
        $data = Cli_Model_Product::getInstance()->duplicate();
        $data = $data ? $data->toArray() : array();
        $result = array();
        foreach ($data as $product) {
            $ids = explode(', ', $product['ids']);
            if (count($ids) > 1) {
                $ids = array_unique($ids);
                sort($ids);
                unset($ids[0]);
                $result = array_merge($result, $ids);
            }
        }

        if ($result) {
            // Delete image
            Cli_Model_ProductImage::getInstance()->deleteByProductId($result);
            $rowCnt = Cli_Model_Product::getInstance()->deleteById($result);
            if ($rowCnt <= 0) {
                Admin_Model_Product::getInstance()->manualUpdateActive(Application_Constant_Db_Config_Active::DELETED, $result);
            }
        }
    }
}
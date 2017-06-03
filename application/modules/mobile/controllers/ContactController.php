<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/19/2016
 * Time: 9:11 PM
 */
class Mobile_ContactController extends Application_Controller_FrontEnd_Default
{
    public function indexAction()
    {
        $contentData = Admin_Model_SiteContent::getInstance()->getByIdentify('lien-he');
        if ($contentData) {
            $this->view->assign('content', $contentData->{DbTable_Site_Content::COL_SITE_CONTENT_CONTENT});
        }
        $this->view->assign('menuHeader', Application_Constant_Identify::MENU_HEADER_RENT);
        // $this->view->assign('menuHeader', 'product-add');
    }

    public function listingAction()
    {
        $componentIdentify = $this->getParam('componentIdentify');
        $categoryIdentify = $this->getParam('categoryIdentify');
        $page = $this->getParam('page', 1);
        $limit = 16;
        $componentId = null;
        /* $category = Model_ProductCategory::getInstance()->getByIdentify($categoryIdentify);
         if (!$category) {
             $this->goto404();
         }
         $categoryId = $category[DbTable_Product_Category::COL_PRODUCT_CATEGORY_ID];
         //$categoryId = null;*/

        $categoryId = null;

        $data = Model_Contact::getInstance()->getListing($page, $limit, $componentId, $categoryId);

        $contactData = $data ? $data[Application_Constant_Global::KEY_DATA] : array();

        $total = $data ? $data[Application_Constant_Global::KEY_TOTAL] : 0;
        $totalPage = ($total - 1) / $limit + 1;
        Application_Function_Pagination_Default::getInstance()->initialize($totalPage, $page);
        $this->view->assign('pagination', Application_Function_Pagination_Default::getInstance()->show());
        $this->view->assign('contactData', $contactData);
        // $this->view->assign('menuHeader', Application_Constant_Identify::MENU_HEADER_CONTACT);
    }


    public function submitContactAction()
    {
        // $captcha = $this->getRequest()->getParam('captcha');
        $name = $this->getRequest()->getParam('name');
        $phone = $this->getRequest()->getParam('phone');
        $email = $this->getRequest()->getParam('email');
        $address = $this->getRequest()->getParam('address');
        $price = $this->getRequest()->getParam('price');
        $product = $this->getRequest()->getParam('product');
        $message = $this->getParam('message');
        $image = $this->getParam('image');

        $lat = $this->getParam('lat');
        $lng = $this->getParam('lng');
        $radius = $this->getParam('radius');
        $color = $this->getParam('color');
        $arrRemove = array(',', '.', '~', '`', '!', '@', '#', '$', '%', '^', '*', '(', ')', '_', '=', '+', '[', ']', '{', '}', '|', '\\', ';', ':', "'", '"', ',', '<', '>', '?', '/', '*', '“', '”', '–', ' -', 'quot', 'lsquo', '&amp', '&', '‘');
        $color = str_replace($arrRemove, "", $color);
        /*   $name = 'TEST';
           $phone = '0123456789';*/
        $msgError = null;
        $url = $this->generateUrlImageMap(round($lat, 6), round($lng, 6), round($radius, 0)/1000, $color);
        //$image = $this->saveImage($img);
        $id = null;

        if (true) {
            if ($name & $phone) {
                $id = Model_Contact::getInstance()->insert($name, $email, $phone, $message, $address, $price, $product, $image, $lat, $lng, $radius, $url, $color, $this->getCustomerLoginId());
                $msgError = 'Chúng tôi đã nhận đuọc thông tin của bạn. Chúng tôi sẽ liên lạc lại bạn trong thời gian sớm nhất.';
            } else {
                $msgError = 'Bạn cần điền đầy đủ thông tin';
            }
        } else {
            $msgError = 'Mã xác nhận không hợp lệ';
        }

        $this->gotoUrl('/tin-tim-phong/' . Application_Function_String::getFormatUrl($address . ' ' . $phone) . '-' . strtolower(Model_Contact::getInstance()->encode($id)) . '.html');
        $this->noRender();
    }

    public function successAction()
    {

    }

    public function addAction()
    {

    }

    private function saveImage($img)
    {

        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $image = null;
        $folder = $this->getUploadPath() . '/' . 'contact';
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


        $imagePath = sprintf('%s/%s', $folder, $this->_helper->generateImageName('contact_map.png'));

        $success = file_put_contents($imagePath, $data);
        if ($success) {
            $image = str_replace($this->getUploadPath(), '', $imagePath);
        }
        return $image;
    }

    public function detailAction()
    {
        $encode = $this->getParam('encode');

        if ($encode) {
            $encode = 'xomevn' . $encode;

            $id = Model_Contact::getInstance()->decode($encode);


            $dataInfo = Model_Contact::getInstance()->getById($id);
            $dataInfo = $dataInfo ? $dataInfo->current() : null;
            if ($dataInfo) {
                $data = Model_Product::getInstance()->searchAround($dataInfo[DbTable_Contact::COL_CONTACT_LAT], $dataInfo[DbTable_Contact::COL_CONTACT_LNG], 0.5, 8);
                $productData = $data ? $data[Application_Constant_Global::KEY_DATA] : array();

                $productRelationData = $productData ? $productData->toArray() : null;
                //$productRelationData = $data ? $data[Application_Constant_Global::KEY_DATA] : array();
                $this->view->assign('productRelationData', $productRelationData);
                $this->view->assign('dataInfo', $dataInfo);
                //$encodeStringMap = $this->generateUrlImageMap($dataInfo[DbTable_Contact::COL_CONTACT_LAT], $dataInfo[DbTable_Contact::COL_CONTACT_LNG], $dataInfo[DbTable_Contact::COL_CONTACT_RADIUS] / 1000, null);
                $this->view->assign('encodeStringMap', $dataInfo[DbTable_Contact::COL_CONTACT_URL_STATIC_MAP]);
                //  $this->view->assign('encodeStringMap', $encodeStringMap);

                $url = 'http://xome.vn/statics/asset/default/img/home.png';
                if ($dataInfo[DbTable_Contact::COL_CONTACT_URL_STATIC_MAP]) {
                    $url = $dataInfo[DbTable_Contact::COL_CONTACT_URL_STATIC_MAP];
                }
                $this->setMetaImage($url);
                $this->setMetaData(
                    'Tôi tìm phòng gần khu vực '. $dataInfo[DbTable_Contact::COL_CONTACT_ADDRESS],
                    $this->getTranslateValue('common_keywords'),
                    strip_tags($dataInfo[DbTable_Contact::COL_CONTACT_MESSAGE])
                );
            } else {
                $this->goto404();
            }
        } else {
            $this->goto404();
        }

    }

    private function gMapCircle($Lat, $Lng, $Rad, $Detail = 8)
    {
        $R = 6371;

        $pi = pi();

        $Lat = ($Lat * $pi) / 180;
        $Lng = ($Lng * $pi) / 180;
        $d = $Rad / $R;

        $points = array();
        $i = 0;

        for ($i = 0; $i <= 360; $i += $Detail):
            $brng = $i * $pi / 180;

            $pLat = asin(sin($Lat) * cos($d) + cos($Lat) * sin($d) * cos($brng));
            $pLng = (($Lng + atan2(sin($brng) * sin($d) * cos($Lat), cos($d) - sin($Lat) * sin($pLat))) * 180) / $pi;
            $pLat = ($pLat * 180) / $pi;

            $points[] = array($pLat, $pLng);
        endfor;

        require_once('PolylineEncoder.php');
        $PolyEnc = new PolylineEncoder($points);
        $EncString = $PolyEnc->dpEncode();

        return $EncString['Points'];
    }

    private function generateUrlImageMap($MapLat, $MapLng, $MapRadius, $color)
    {
        /* $MapLat    = '-42.88188'; // latitude for map and circle center
         $MapLng    = '147.32427'; // longitude as above
         $MapRadius = 100;         // the radius of our circle (in Kilometres)*/
        $MapFill = $color ? $color : 'E85F0E';    // fill colour of our circle
        $MapBorder = '91A93A';    // border colour of our circle
        $MapWidth = 640;         // map image width (max 640px)
        $MapHeight = 480;         // map image height (max 640px)
        $key = 'AIzaSyACxeyH_WD2MaKwbNS4AIFpgKQf_hk3NCk';

        /* create our encoded polyline string */
        $EncString = $this->gMapCircle($MapLat, $MapLng, $MapRadius);

        /* put together the static map URL */
        $MapAPI = 'http://maps.google.com.au/maps/api/staticmap?';
        $MapURL = $MapAPI . 'center=' . $MapLat . ',' . $MapLng . '&size=' . $MapWidth . 'x' . $MapHeight . '&maptype=roadmap&path=fillcolor:0x' . $MapFill . '33%7Ccolor:0x' . $MapBorder . '00%7Cenc:' . $EncString . '&sensor=false' . '&key=' . $key;
        // var_dump($MapURL);exit;
        /* output an image tag with our map as the source */
        return $MapURL;
    }
}
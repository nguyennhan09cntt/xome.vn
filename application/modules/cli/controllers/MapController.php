<?php

/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 5/13/15
 * Time: 9:59 AM
 */
class Cli_MapController extends Application_Controller_Cli
{
    /**
     * Usage: php cli.php -m cli -c map -a init-lat-lng
     */
    public function initLatLngAction()
    {
        $data = Cli_Model_Product::getInstance()->getPending();
        $data = $data ? $data->toArray() : array();
        foreach ($data as $product) {
            $address = $product[DbTable_Product::COL_PRODUCT_ADDRESS];
            $latLng = $this->getLatLong($address);
            if ($latLng) {
                Cli_Model_Product::getInstance()->updateLatLng($product[DbTable_Product::COL_PRODUCT_ID], $latLng['latitude'], $latLng['longitude']);
            }

        }
    }

    /**
     * Author: CodexWorld
     * Author URI: http://www.codexworld.com
     * Function Name: getLatLong()
     * $address => Full address.
     * Return => Latitude and longitude of the given address.
     **/
    private function getLatLong($address)
    {
        if (!empty($address)) {
            /*//Formatted address
            //$formattedAddr = str_replace(' ', '+', $address);
            $formattedAddr = html_entity_decode($address);;
            //Send request and receive json data by address
            $geocodeFromAddr = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . $formattedAddr . '&sensor=false');
            $output = json_decode($geocodeFromAddr);
            var_dump($output);
            //Get latitude and longitute from json data
            $data['latitude'] = $output->results[0]->geometry->location->lat;
            $data['longitude'] = $output->results[0]->geometry->location->lng;*/
            $address = urlencode($address);
            $url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($ch);
            curl_close($ch);
            $response_a = json_decode($response);

            $data = null;
            if($response_a->results){
                $data['latitude']   = $response_a->results[0]->geometry->location->lat;

                $data['longitude'] = $response_a->results[0]->geometry->location->lng;
            }


            //Return latitude and longitude of the given address
            if (!empty($data)) {
                return $data;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
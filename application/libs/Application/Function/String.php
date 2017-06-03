<?php

/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/11/15
 * Time: 9:26 AM
 */
class Application_Function_String
{
    /**
     * Decode un-expect character from FCK string
     * @param string $value
     * @return mixed
     */
    static public function decodeFCK($value)
    {
        return str_replace('\"', '"', $value);
    }

    /**
     * Convert string without VN
     * @param string $title
     * @param string $replacement
     * @return string
     */
    static function convertNoVn($title, $replacement = ' ')
    {
        $map = array();
        $quotedReplacement = preg_quote($replacement, '/');
        $default = array(
            '/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ|å/' => 'a',
            '/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ|È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ|ë/' => 'e',
            '/ì|í|ị|ỉ|ĩ|Ì|Í|Ị|Ỉ|Ĩ|î/' => 'i',
            '/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ|ø/' => 'o',
            '/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ|ů|û/' => 'u',
            '/ỳ|ý|ỵ|ỷ|ỹ|Ỳ|Ý|Ỵ|Ỷ|Ỹ/' => 'y',
            '/đ|Đ/' => 'd',
            '/ç/' => 'c',
            '/ñ/' => 'n',
            '/ä|æ/' => 'ae',
            '/ö/' => 'oe',
            '/ü/' => 'ue',
            '/Ä/' => 'Ae',
            '/Ü/' => 'Ue',
            '/Ö/' => 'Oe',
            '/ß/' => 'ss',
            '/[^\s\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]/mu' => '',
            '/\\s+/' => $replacement,
            sprintf('/^[%s]+|[%s]+$/', $quotedReplacement, $quotedReplacement) => ''
        );
        $title = urldecode($title);
        $map = array_merge($map, $default);
        return preg_replace(array_keys($map), array_values($map), $title);
    }

    static function getFormatUrl($p_strString)
    {
        $strResult = '';
        $arrReplace = array(' ');
        $arrRemove = array(',', '.', '~', '`', '!', '@', '#', '$', '%', '^', '*', '(', ')', '_', '=', '+', '[', ']', '{', '}', '|', '\\', ';', ':', "'", '"', ',', '<', '>', '?', '/', '*', '“', '”', '–', ' -', 'quot', 'lsquo', '&amp', '&', '‘');
        $arrPlace = array('  ', '   ');

        $strResult = trim($p_strString);
        $strResult = self::convertNoVn($strResult);
        $strResult = str_replace($arrRemove, "", $strResult);
        $strResult = str_replace($arrPlace, " ", $strResult);
        $strResult = str_replace($arrReplace, "-", $strResult);

        return strtolower($strResult);
    }

    static public function randomString($length = 8)
    {
        $characters = '123456789abcdefghjkmnpqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
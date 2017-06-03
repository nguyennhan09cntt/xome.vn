<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/23/15
 * Time: 10:25 PM
 */
class Application_Function_Common
{
    /**
     * Swap elements
     * @param mixed $a
     * @param mixed $b
     */
    static function swap(&$a, &$b)
    {
        $temp = $a;
        $a = $b;
        $b = $temp;
        unset($temp);
    }

    /**
     * Retrieve back url
     * @return string
     */
    static function referredUrl()
    {
        return isset($_SERVER['HTTP_REFERER']) ?  $_SERVER['HTTP_REFERER'] : '/';
    }

    /**
     * Get full current Url
     * @param array $excludeData
     * @return string
     */
    static function fullCurrentUrl($excludeData = array())
    {
        $url = sprintf(
            'http://%s%s',
            $_SERVER['HTTP_HOST'],
            $_SERVER['REQUEST_URI']
        );
        $urlInfo = explode('?', $url);
        $params = end($urlInfo);
        $needed = array();
        if ($params) {
            $paramsInfo = explode('&', $params);
            if ($paramsInfo) {
                foreach ($paramsInfo as $info) {
                    $infoDetail = explode('=', $info);
                    if (!$excludeData || ($excludeData && !in_array($infoDetail[0], $excludeData))) {
                        array_push($needed, $info);
                    }
                }
            }
        }
        $result = $urlInfo[0];
        if ($needed) {
            $result = $result . '?' . implode('&', $needed);
        }
        return $result;
    }

    /**
     * Get full Url without paramss
     * @return mixed
     */
    static function fullCurrentUrlNoParam()
    {
        $url = sprintf(
            'http://%s%s',
            $_SERVER['HTTP_HOST'],
            $_SERVER['REQUEST_URI']
        );
        $urlInfo = explode('?', $url);
        return current($urlInfo);
    }

    /**
     * Get current URL
     * @return string
     */
    static function currentUrl()
    {
        return "http://$_SERVER[HTTP_HOST]";
    }

    /**
     * Build domain name
     * @param null|string $subName
     * @return string
     */
    static function buildDomain($subName=null)
    {
        $hostName = $_SERVER['HTTP_HOST'];
        $hostInfo = explode('.', $hostName);
        $n = count($hostInfo);
        $domain = $hostInfo[$n-2] . '.' . $hostInfo[$n-1];
        if ($subName) {
            $domain = $subName . '.' . $domain;
        }
        return $domain;
    }

    /**
     * Build Url with param options
     * @param array $optionsUrl
     * @return string
     */
    static function buildUrl($optionsUrl=array())
    {
        $uri = $_SERVER['REQUEST_URI'];
        if ($uri) {
            $uriInfo = explode('?', $uri);
            $request = isset($uriInfo[1]) ? $uriInfo[1] : null;
            if ($request) {
                $requestInfo = explode('&', $request);
                $requestArr = array();
                if ($requestInfo) {
                    $keyOptionsUrl = $optionsUrl ? array_keys($optionsUrl) : array();
                    foreach ($requestInfo as $query) {
                        $queryInfo = explode('=', $query);
                        if (!in_array($queryInfo[0], $keyOptionsUrl)) {
                            array_push($requestArr, $query);
                        }
                    }
                }
                $request = implode('&', $requestArr);
            }
            $uriInfo[1] = $request;
            $uri = implode('?', $uriInfo);
        }
        if ($optionsUrl) {
            foreach ($optionsUrl as $params => $value) {
                $uri .= sprintf('&%s=%s', $params, $value);
            }
        }
        return self::currentUrl() . $uri;
    }

    /**
     * Convert month to string
     * @param int $month
     * @return mixed
     */
    static function convertMonth($month)
    {
        $data = array('Tháng Giêng', 'Tháng Hai', 'Tháng Ba', 'Tháng Tư', 'Tháng Năm', 'Tháng Sáu', 'Tháng Bảy', 'Tháng Tám', 'Tháng Chín', 'Tháng Mười', 'Tháng Mười Một', 'Tháng Mười Hai');
        return $data[$month-1];
    }

    /**
     * Remove the end of route in route.ini
     * @param string $route
     * @return mixed
     */
    static function formatRouteConfig($route)
    {
        return str_replace('[/]?', '', $route);
    }
}
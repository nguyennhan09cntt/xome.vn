<?php
include_once('simple_html_dom.php');

//base url
$base = 'http://www.sendo.vn/nhip-song/diem-danh-cac-kieu-toc-dep-hua-hen-gay-bao-2016/';

$curl = curl_init();
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_URL, $base);
curl_setopt($curl, CURLOPT_REFERER, $base);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
$str = curl_exec($curl);
curl_close($curl);
$html_base = new simple_html_dom();
// Load HTML from a string
$html_base->load($str);


// 1. create HTML Dom
//$html = file_get_html('http://www.sendo.vn/nhip-song/diem-danh-cac-kieu-toc-dep-hua-hen-gay-bao-2016/');
//var_dump();
//$html = file_get_html('http://www.google.com/');
// find all div tags with class=td-post-content
foreach($html_base->find('div.td-post-content') as $e)
    echo $e->outertext . '<br>';


?>
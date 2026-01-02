<?php
if (getenv('REQUEST_METHOD') == 'OPTIONS')
{
    exit;
}

if (!defined("ROOT_PATH"))
{
    define("ROOT_PATH", dirname(__FILE__) . '/');
}
require ROOT_PATH . 'app/config/options.inc.php';

$http_referer = isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']: gethostbyaddr($_SERVER['REMOTE_ADDR']);

# Fix for Authorize.NET
if (isset($_REQUEST['payment_method']) && strpos($_REQUEST['payment_method'], '|') !== false)
{
    list($_REQUEST['payment_method'], $str) = explode('|', $_REQUEST['payment_method'], 2);
    $str = str_replace('|', '&', $str);
    $qs = array();
    parse_str($str, $qs);
    $_REQUEST = array_merge($_REQUEST, $qs);
}

$redirect = true;
if ($_REQUEST['payment_method'] == 'paypal_express')
{
    $redirect = false;
}

$opts = array('http' => array(
    'method'  => 'POST',
    'header'  => 'Content-type: application/x-www-form-urlencoded',
    'follow_location' => 1,
    'content' => http_build_query($_REQUEST + array('pj_http_referer' => $http_referer))
));
$context = stream_context_create($opts);
$url = file_get_contents(PJ_INSTALL_URL."index.php?controller=pjFrontEnd&action=pjActionConfirm", false, $context);
$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '*';
header("Access-Control-Allow-Origin: " . $origin);
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With");
header('P3P: CP="ALL DSP COR CUR ADM TAI OUR IND COM NAV INT"');
$install_url = parse_url(PJ_INSTALL_URL);
if($install_url['scheme'] == 'https'){
    header('Set-Cookie: '.session_name().'='.session_id().'; SameSite=None; Secure');
}
if (!empty($url))
{
    if ($redirect)
    {
        if (strstr($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS'))
        {
            echo '<html><head><title></title><script type="text/javascript">window.location.href="'.$url.'";</script></head><body></body></html>';
        } else {
            header("Location: $url", true, 303);
        }
    } else {
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode(array('status' => 'OK', 'location' => $url));
        exit;
    }
}
?>
<?php

# weixin.php
# 2018 07 30 下午12:04
# 王磊
# 1992454838@qq.com
# 微信支付demo

//是否在微信
define('ON_WEIXIN', false !== stripos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger'));

//微信appid
define('APP_ID', 'wx60ef890ebfb97045');

//微信secret
define('APP_SECRET', 'd76d5c4d49d0db4613564ba4eb6bd0d1');

/**
 * curl get 请求
 * @param string $url
 * @return string
 */
function get($url)
{
    if ('' == $url) {
        return '';
    }

    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL =>  $url,
        CURLOPT_RETURNTRANSFER  =>  true
    ]);

    $res = curl_exec($ch);

    curl_close($ch);

    return $res;
}

//获取code回跳链接
$redirect_uri = 'http://passport.guixue.com/ywl.php';

//获取code地址
$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.APP_ID.'&redirect_uri='.urlencode($redirect_uri).'&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect';

if (!isset($_GET['code'])) {
    header('location:'.$url);
    die;
}

$url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.APP_ID.'&secret='.APP_SECRET.'&code='.$_GET['code'].'&grant_type=authorization_code';

$res = get($url);

var_dump($res);

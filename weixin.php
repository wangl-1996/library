<?php

# weixin.php
# 2018 07 30 下午12:04
# 王磊
# 1992454838@qq.com
# 微信支付demo

define('ON_WEIXIN', false !== stripos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger'));

$redirect_uri = 'http://passport.guixue.com/ywl.php';

$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx60ef890ebfb97045&redirect_uri='.urlencode($redirect_uri).'&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect';

if (!isset($_GET['code'])) {
    header('location:'.$url);
    die;
}

var_dump($_GET);

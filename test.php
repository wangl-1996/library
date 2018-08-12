<?php

# test.php
# 2018 07 30 下午3:15
# 王磊
# 1992454838@qq.com

date_default_timezone_set('PRC');

require './src/openssl/sign.php';

/**
 * 生成xml数据
 * @param array $data
 * @return string
 */
function buildXml(array $data)
{
    $xml = '<xml>';

    foreach ($data as $key => $val) {
        $val = htmlentities($val);
        $xml .= "<{$key}>".$val."</{$key}>";
    }

    $xml .= '</xml>';

    return $xml;
}

//是否在微信
define('ON_WEIXIN', false !== stripos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger'));

//微信appid
define('APP_ID', 'wx60ef890ebfb97045');

//商户号
define('MCH_ID', '1504890621');

define('KEY', 'f6066bb1118890c601699d8hh89786d8');

$sign = new \wangl_1996\library\src\openssl\sign();

//获取key地址
$url = 'https://api.mch.weixin.qq.com/sandboxnew/pay/getsignkey';

$param = [
    'mch_id'    =>  1504890621,
    'nonce_str' =>  md5(time())
];

ksort($param);

$signString = $sign->formatSignString($param);

$signString .= '&key='.KEY;

$param['sign'] = md5($signString);

$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL =>  $url,
    CURLOPT_POST    =>  true,
    CURLOPT_RETURNTRANSFER  =>  true,
    CURLOPT_POSTFIELDS  =>  buildXml($param)
]);

$res = curl_exec($ch);

curl_close($ch);

echo '<pre>';

var_dump(htmlentities($res));
var_dump($param);

echo '</pre>';
/*
//参数
$data = [
    'appid'     =>  APP_ID,
    'mch_id'    =>  MCH_ID,
    'nonce_str' =>  md5(rand(1, 100)),
    'sign'      =>  '',
    'sign_type' =>  'md5',
    'body'      =>  '测试商品',
    'out_trade_no'  =>  'S0000'.time(),
    'total_fee' =>  100,
    'spbill_create_ip'  =>  $_SERVER['REMOTE_ADDR'] ?? 'unknown',
    'notify_url'    =>  'http://www.guojf.com/notify.php',
    'trade_type'    =>  'JSAPI',
    'openid'        =>  'o0-4b1F30uTyuRMGXBXWDORFWT48'
];

//字典序排序
ksort($data);

//签名
$signString = $sign->formatSignString($data, '&', function ($val) {
    if (null === $val || '' == trim($val)) {
        return null;
    }

    return $val;
});

$signString .= '&key='.KEY;

var_dump($signString);

$data['sign'] = strtoupper(md5($signString));

$url = 'https://api.mch.weixin.qq.com/sandboxnew/pay/unifiedorder';

$ch = curl_init();

$data = buildXml($data);

curl_setopt_array($ch, [
    CURLOPT_URL =>  $url,
    CURLOPT_POST    =>  true,
    CURLOPT_RETURNTRANSFER  =>  true,
    CURLOPT_POSTFIELDS  =>  $data
]);

$res = curl_exec($ch);

curl_close($ch);

var_dump($res);
*/

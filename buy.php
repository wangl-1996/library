<?php

# buy.php
# 2018 07 30 下午3:51
# 王磊
# 1992454838@qq.com

//sign
require './src/openssl/sign.php';

session_start();

//是否在微信
define('ON_WEIXIN', false !== stripos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger'));

//微信appid
define('APP_ID', 'wx60ef890ebfb97045');

//商户号
define('MCH_ID', '1504890621');

define('KEY', 'f6066bb1118890c601699d8hh89786d8');

// define('KEY', 'a3ba83f52525e8991218eb8b5c5b3d59');

$sign = new \wangl_1996\library\src\openssl\sign();

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

//open id
if (!isset($_SESSION['openid']) || !$_SESSION['openid']) {
    die(json_encode([
        'code'  =>  1,
        'info'  =>  '当前网络不稳定，请刷新后再试'
    ]));
}

//金额
$price = $_POST['price'] ?? null;

if (!is_numeric($price)) {
    die(
        json_encode([
            'code'  =>  1,
            'info'  =>  is_null($price) ? '请填写支付金额' : '金额不正确'
        ])
    );
}

//元换成分
$price *= 100;

settype($price, 'int');

//参数
$data = [
    'appid'     =>  APP_ID,
    'mch_id'    =>  MCH_ID,
    'nonce_str' =>  md5(rand(1, 100)),
    'sign'      =>  '',
    'sign_type' =>  'md5',
    'body'      =>  '测试商品',
    'out_trade_no'  =>  'S0000'.time(),
    'total_fee' =>  $price,
    'spbill_create_ip'  =>  $_SERVER['REMOTE_ADDR'] ?? 'unknown',
    'notify_url'    =>  'http://www.guojf.com/notify.php',
    'trade_type'    =>  'JSAPI',
    'openid'        =>  $_SESSION['openid']
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

$data['sign'] = strtoupper(md5($signString));

$url = 'https://api.mch.weixin.qq.com/sandboxnew/pay/unifiedorder';

$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL =>  $url,
    CURLOPT_POST    =>  true,
    CURLOPT_RETURNTRANSFER  =>  true,
    CURLOPT_POSTFIELDS  =>  buildXml($data)
]);

$res = curl_exec($ch);
$simplexml = simplexml_load_string($res, 'SimpleXMLElement', LIBXML_NOCDATA);

curl_close($ch);

//解析返回内容
if (false === $simplexml) {
    die(json_encode(['code' => 1, 'info' => 'error: get prepay id.', 'data' => $simplexml]));
}

settype($simplexml, 'array');

if (!isset($simplexml['prepay_id'])) {
    die(json_encode(['code' => 1, 'info' => 'error: get prepay id.', 'data' => $simplexml, 'sgin' => $signString]));
}

$data = [
    'appId'     =>  APP_ID,
    'timeStamp' =>  time(),
    'nonceStr'  =>  md5(time()),
    'package'   =>  'prepay_id='.$simplexml['prepay_id'],
    'signType'  =>  'MD5',
    'paySign'   =>  ''
];

ksort($data);

//签名
$signString = $sign->formatSignString($data, '&', function ($val) {
    if ('' == trim($val)) {
        return null;
    }

    return $val;
});

$data['paySign'] = md5($signString);

die(
    json_encode(
        [
            'code' => 0, 'data' => $data
        ]
    )
);
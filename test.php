<?php

# test.php
# 2018 07 30 下午3:15
# 王磊
# 1992454838@qq.com

require './src/openssl/sign.php';

$sign = new \wangl_1996\library\src\openssl\sign();

//获取key地址
$url = 'https://api.mch.weixin.qq.com/sandboxnew/pay/getsignkey';

$param = [
    'mch_id'    =>  '1504890621',
    'nonce_str' =>  md5(time())
];

ksort($param);

$signString = $sign->formatSignString($param);

$param['sign'] = $signString;

$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL =>  $url,
    CURLOPT_POST    =>  true,
    CURLOPT_RETURNTRANSFER  =>  true,
    CURLOPT_POSTFIELDS  =>  $param
]);

$res = curl_exec($ch);

curl_close($ch);

var_dump(base64_encode($res));

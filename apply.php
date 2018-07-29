<?php

# apply.php
# 2018 07 27 下午3:27
# 王磊
# 1992454838@qq.com

date_default_timezone_set('Asia/Shanghai');

require './src/openssl/sign.php';
require './src/openssl/encrypt.php';
/*
$arr = json_decode('{"gmt_create":"2018-07-29 00:12:42","charset":"UTF-8","seller_email":"konvyp7160@sandbox.com","subject":"test ali pay","sign":"x7cau2E3a7pN7phEVguuVCGRreQka8A21uHghGIVhOj\/wJI6oTcf0ukUMXhWcy4NKu4u3NlCyjZekrMDFZceBgKlbrptbeZsp9LJ0CG6BHJ1lzaVExmNdYxLtAesZwUtiY8ceX600LOLHdgnCdFLCvZdqW3iAJXv83ubUWNQPz0=","body":"pay test","buyer_id":"2088102176376102","invoice_amount":"1.00","notify_id":"ba1b392470cdc76717536c0c58493fbgru","fund_bill_list":"[{\"amount\":\"1.00\",\"fundChannel\":\"ALIPAYACCOUNT\"}]","notify_type":"trade_status_sync","trade_status":"TRADE_SUCCESS","receipt_amount":"1.00","app_id":"2016091700532623","buyer_pay_amount":"1.00","sign_type":"RSA","seller_id":"2088102176042878","gmt_payment":"2018-07-29 00:12:42","notify_time":"2018-07-29 00:17:30","version":"1.0","out_trade_no":"705011S1532794345","total_amount":"1.00","trade_no":"2018072921001004100200710099","auth_app_id":"2016091700532623","buyer_logon_id":"vyv***@sandbox.com","point_amount":"0.00"}', true);

$sign     = $arr['sign'] ?? '';
$signType = $arr['sign_type'] ?? '';

$arr['sign'] = '';
$arr['sign_type'] = '';

$verify = new \wangl_1996\library\src\openssl\sign();
$verify->pubKey = $verify->formatPubKey('MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDIgHnOn7LLILlKETd6BFRJ0GqgS2Y3mn1wMQmyh9zEyWlz5p1zrahRahbXAfCfSqshSNfqOmAQzSHRVjCqjsAw1jyqrXaPdKBmr90DIpIxmIyKXv4GGAkPyJ/6FTFY99uhpiq0qadD/uSzQsefWo0aTvP/65zi3eof7TcZ32oWpwIDAQAB');

ksort($arr);

$signString = $verify->formatSignString($arr, '&', function ($val, $key) {
    if (null === $val || '' == trim($val)) {
        return null;
    }

    return urldecode($val);
});

echo '<pre>';
var_dump($signString);
var_dump($sign);
var_dump($verify->pubKey);
var_dump($verify->verify($signString, $sign));
echo '</pre>';
*/
//业务参数
$biz_content = [
    'body'          =>  '商品',
    'subject'       =>  '测试商品',
    'out_trade_no'  =>  '705011S'.time(),
    'total_amount'  =>  9.99,
    'seller_id'     =>  '2088102176042878',
    'quit_url'      =>  'http://123.56.86.74/quit.php',
    'product_code'  =>  'QUICK_WAP_PAY'
];

//系统参数
$param = [
    'app_id'        =>  '2016091700532623',
    'method'        =>  'alipay.trade.wap.pay',
    'format'        =>  'JSON',
    'return_url'    =>  'http://123.56.86.74/result.php',
    'charset'       =>  'utf-8',
    'sign_type'     =>  'RSA',
    'sign'          =>  '',
    'timestamp'     =>  date('Y-m-d H:i:s'),
    'version'       =>  '1.0',
    'notify_url'    =>  'http://123.56.86.74/src/ali/pay/notify.php',
    'biz_content'   =>  json_encode($biz_content, JSON_UNESCAPED_UNICODE)
];

$sign = new \wangl_1996\library\src\openssl\sign();

$sign->priKey = $sign->formatPriKey('MIICXQIBAAKBgQCzz1QCVdzRL+zEm53DentQcPGufamku45puysJch7d/AOuX1Nml3jFdDICb8q9hQ+nSeVNBEEX8X8UF5ck0xH6ViJ8KNUl5I9e+znI/FfMoHWctiah9Db2dxBmlCb4dokMPrYe3z3dFvX/yD1O+7EonypuEqGjQVYDUypPLoOcOwIDAQABAoGAMS1PCKR7FCtLUipNZ50kBMgfEV4E+6zgMkKibp7rmkLGrvYbVT+wJDC3TLtOc67krRgkwn+bXfUKkHAzQjsH+z2GUg7VefwM8No0FHY2b8vqAvX53HYCi1+CfqGZmVWNIbIOnvKY4RfgIWq5TyelduGiodAaKmyEuL28GKUb34ECQQDtXw7/xWcS15nXaWiQ6TNhu64vsqoE956ycBw1wTuhd0HDl22EfPg5fjtRvY08yBGlOD/DtDTlj6ycG7XS+hAxAkEAwevSx0LsGgC2Wv0Dqi02jDncs2cUVH8F7a0Om/r6B+FMWWia0+3NfPUmSTaL28CbBFJz983qlADDzGlm5PwkKwJBAL8LBL1iGUUW9SBkG96Vcd80+Eo3V5NL4BPpGytAbEfV/b33wBMjqXxMVl3BW00SEPGSxe8yuGgSLHAv9TTqQeECQQCOg+VwE7q4kXVzASdEVd4UyCFup37FamTM+7YU5CoEyIr32myO++FcyD3O6It4gOBsGLypjWesRbOf8oZwGu3pAkAy70dUII8FqNyMLKNGOaJcg41+amLRgpUr50m1f+f4tb880iTF3liZFotgWOiaRUsu5Wf/n5nukbDca/ddLCzo');

ksort($param);

$signString = $sign->formatSignString($param, '&', function ($val) {
    //过滤掉空的参数
    if (null === $val || '' == trim($val)) {
        return null;
    }

    return $val;
});

$param['sign'] = $sign->getSign($signString);

pay($param);

/**
 * @param $data
 */
function pay($data)
{
    echo '<form action="https://openapi.alipaydev.com/gateway.do?charset='.$data['charset'].'" method="post" id="pay">';

    foreach ($data as $key => $val) {
        $val = str_replace("'","&apos;", $val);
        $key = str_replace("'","&apos;", $key);
        echo "<input name='".$key."' value='".mb_convert_encoding($val, $data['charset'])."' type='hidden' />";
    }

    echo '</form>';

    echo '<script>var pay = document.querySelector("#pay"); if (pay) { pay.submit(); } </script>';
}



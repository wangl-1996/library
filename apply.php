<?php

# apply.php
# 2018 07 27 下午3:27
# 王磊
# 1992454838@qq.com

date_default_timezone_set('Asia/Shanghai');

require './src/aes.php';

# 姓名
$name  = $_GET['name'] ?? '';
# 手机号
$phone = $_GET['phone'] ?? '';

$publicKey = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCzz1QCVdzRL+zEm53DentQcPGu
famku45puysJch7d/AOuX1Nml3jFdDICb8q9hQ+nSeVNBEEX8X8UF5ck0xH6ViJ8
KNUl5I9e+znI/FfMoHWctiah9Db2dxBmlCb4dokMPrYe3z3dFvX/yD1O+7Eonypu
EqGjQVYDUypPLoOcOwIDAQAB
-----END PUBLIC KEY-----';

/**
 * @return null|\wangl_1996\library\aes
 * @throws Exception
 */
function getAes()
{
    static $aes = null;

    if (is_null($aes)) {
        $aes = new \wangl_1996\library\aes('FTSSgfjVaXd64T4TyGvmvA==');
    }

    return $aes;
}

//
// $pKey = openssl_pkey_get_public($publicKey);

// openssl_public_decrypt(base64_decode('bPEXX9FwKeXjRKhvcGc++Zif6l6kAHQB4LqPM0f9mLJix8OUUVoszEmD2KGoUJ4jHxQpK9C/ru6VapJ/IfA5XAp7E8Xs4ezCTfpaOwa37noH30xfmqFeFhsx4jUlJqoxebV5GdXMCp8k0MWnHhJtARBAgC62EOpEZ1CK0M0PSgg='), $decrypted, $pKey);

//

// $crypted = base64_encode($crypted);

// var_dump($crypted);

// var_dump($decrypted);
/*


$aes = new \wangl_1996\library\aes('FTSSgfjVaXd64T4TyGvmvA==');


$encrypt = $aes->encrypt($name ?: 'wanglei');
var_dump($encrypt);
var_dump($aes->decrypt($encrypt));
*/



/**
 * @param $signString
 * @return string
 */
function sign($signString)
{
    $privateKey = '-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQCzz1QCVdzRL+zEm53DentQcPGufamku45puysJch7d/AOuX1Nm
l3jFdDICb8q9hQ+nSeVNBEEX8X8UF5ck0xH6ViJ8KNUl5I9e+znI/FfMoHWctiah
9Db2dxBmlCb4dokMPrYe3z3dFvX/yD1O+7EonypuEqGjQVYDUypPLoOcOwIDAQAB
AoGAMS1PCKR7FCtLUipNZ50kBMgfEV4E+6zgMkKibp7rmkLGrvYbVT+wJDC3TLtO
c67krRgkwn+bXfUKkHAzQjsH+z2GUg7VefwM8No0FHY2b8vqAvX53HYCi1+CfqGZ
mVWNIbIOnvKY4RfgIWq5TyelduGiodAaKmyEuL28GKUb34ECQQDtXw7/xWcS15nX
aWiQ6TNhu64vsqoE956ycBw1wTuhd0HDl22EfPg5fjtRvY08yBGlOD/DtDTlj6yc
G7XS+hAxAkEAwevSx0LsGgC2Wv0Dqi02jDncs2cUVH8F7a0Om/r6B+FMWWia0+3N
fPUmSTaL28CbBFJz983qlADDzGlm5PwkKwJBAL8LBL1iGUUW9SBkG96Vcd80+Eo3
V5NL4BPpGytAbEfV/b33wBMjqXxMVl3BW00SEPGSxe8yuGgSLHAv9TTqQeECQQCO
g+VwE7q4kXVzASdEVd4UyCFup37FamTM+7YU5CoEyIr32myO++FcyD3O6It4gOBs
GLypjWesRbOf8oZwGu3pAkAy70dUII8FqNyMLKNGOaJcg41+amLRgpUr50m1f+f4
tb880iTF3liZFotgWOiaRUsu5Wf/n5nukbDca/ddLCzo
-----END RSA PRIVATE KEY-----';

    $pKey = openssl_pkey_get_private($privateKey);

    openssl_sign($signString, $sign, $pKey);

    return base64_encode($sign);
}

function getOrder()
{
    return date('YmdHis').'001';
}

/**
 * @param $data
 * @return string
 * @throws Exception
 */
function encrypt($data)
{
    $aes = getAes();

    return $aes->encrypt($data);
}

/**
 * @param $data
 * @return string
 * @throws Exception
 */
function decrypt($data)
{
    $aes = getAes();

    return $aes->decrypt($data);
}

function pay($data)
{
    if (!is_string($data)) {
        $data = json_encode($data);
    }

    echo '<pre>';
    var_dump($data);
    echo '</pre>';

    try {
        $data = encrypt($data);
    } catch (\Exception $e) {
        die($e->getMessage());
    }

    echo '<pre>';
    var_dump($data);
    echo '</pre>';

    try {
        echo '<pre>';
        var_dump(decrypt($data));
        echo '</pre>';
    } catch (\Exception $e) {
        die($e->getMessage());
    }

    $param = [
        'app_id'        =>  '2016091700532623',
        'method'        =>  'alipay.trade.wap.pay',
        'format'        =>  'JSON',
        'return_url'    =>  urlencode('http://123.56.86.74/result.php'),
        'charset'       =>  'utf-8',
        'sign_type'     =>  'RSA',
        'sign'          =>  '',
        'timestamp'     =>  date('Y-m-d H:i:s'),
        'version'       =>  '1.0',
        'notify_url'    =>  urlencode('http://123.56.86.74/src/ali/pay/notify.php'),
        'biz_content'   =>  $data
    ];

    ksort($param);

    $signString = '';
    $split = '';

    foreach ($param as $key => $val) {
        if (trim($val) == '') {
            continue;
        }

        $signString .= $split.$key.'='.$val;
        $split = '&';
    }

    $param['sign'] = sign($signString);

    echo '<form action="https://openapi.alipaydev.com/gateway.do" method="post" id="pay">';

    foreach ($param as $key => $val) {
        $val = str_replace("'","&apos;",$val);
        echo '<input name="'.$key.'" value="'.mb_convert_encoding($val, $param['charset']).'" type="hidden" />';
    }

    echo '</form>';

    echo '<script>var pay = document.querySelector("#pay"); if (pay && confirm("提交") !== false) { pay.submit(); } </script>';
}

$biz_content = [
    'body'          =>  'pay test',
    'subject'       =>  'test ali pay',
    'out_trade_no'  =>  '70501111111S001111119',
    'total_amount'  =>  1.00,
    'seller_id'     =>  '2088102176042878',
    'quit_url'      =>  urlencode('http://123.56.86.74/quit.php'),
    'product_code'  =>  'QUICK_WAP_PAY'
];

pay($biz_content);
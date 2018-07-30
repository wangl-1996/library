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

session_start();

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

if (!isset($_SESSION['openid'])) {
    //获取code回跳链接
    $redirect_uri = 'http://passport.guixue.com/ywl.php';

    //获取code地址
    $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . APP_ID . '&redirect_uri=' . urlencode($redirect_uri) . '&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect';

    if (!isset($_GET['code'])) {
        header('location:' . $url);
        die;
    }

    $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . APP_ID . '&secret=' . APP_SECRET . '&code=' . $_GET['code'] . '&grant_type=authorization_code';

    $res = get($url);
    $res = json_decode($res, true);

    //判断返回结果
    if (null == $res || !isset($res['openid'])) {
        die('获取openid失败');
    }

    $_SESSION['access_token'] = $res['access_token'];
    $_SESSION['openid'] = $res['openid'];

    $url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $res['access_token'] . '&openid=' . $res['openid'] . '&lang=zh_CN';

    $res = get($url);
    $res = json_decode($res, true);

    if (null == $res || !isset($res['nickname'])) {
        var_dump($res);
        die('获取用户信息失败');
    }

    $_SESSION['nickname'] = $res['nickname'];
    $_SESSION['headimgurl'] = $res['headimgurl'];
}
?>

<html>
<head>
    <meta charset="UTF-8" />
    <title>微信支付</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
</head>
<body>
<p>
    谁的青春不迷茫
</p>
<p>
    <img src="https://pay.weixin.qq.com/index.php/public/chatroom/url_to_qrcode?url=https%3A%2F%2Fweixin.qq.com%2Fg%2FAb6vB3PzgdFL9IPk" alt="">
</p>
<form action="/apply.php" id="pay">
    <p>
        姓&nbsp;&nbsp;&nbsp;名：<input type="text" name="name" value="" placeholder="姓名" style="border: 1px solid #ccc; height: 1.5rem;" />
    </p>
    <p>
        手机号：<input type="text" name="phone" value="" placeholder="手机号" style="border: 1px solid #ccc; height: 1.5rem;" />
    </p>
    <p>
        金&nbsp;&nbsp;&nbsp;额：<input type="number" name="price" value="" placeholder="支付金额" style="border: 1px solid #ccc; height: 1.5rem;" />
    </p>
    <p>
        <button style="border: 1px solid #ccc;">提交</button>
    </p>
</form>
</body>
<script>
    var lock  = true;
    var WxApi = window.WeixinJSBridge;

    //微信js api
    if ('undefined' == typeof WxApi) {
        document.addEventListener('WeixinJSBridgeReady', function () {
            lock  = false;
            WxApi = window.WeixinJSBridge;
        }, false);
    } else {
        lock = false;
    }

    var pay = document.querySelector('#pay');

    pay.onsubmit = function (e) {
        e.preventDefault();

        if (lock) {
            alert('error.');
            return;
        }

        var data = new FormData(this);
        var xhr  = new XMLHttpRequest();

        xhr.onload = function (ev) {
            var res = JSON.parse(ev.currentTarget.responseText);

            if (res.code) {
                alert(res.info);
            } else {
                WeixinJSBridge.invoke('getBrandWCPayRequest', res.data, function(res){
                    if(res.err_msg == "get_brand_wcpay_request:ok" ){
                        // 使用以上方式判断前端返回,微信团队郑重提示：
                        //res.err_msg将在用户支付成功后返回ok，但并不保证它绝对可靠。
                    }
                    alert(JSON.stringify(res));
                });
            }
        };

        xhr.open('post', '/buy.php');
        xhr.send(data);
    }
</script>
</html>

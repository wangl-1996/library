<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>支付测试</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
</head>
<body>
    <form action="/apply.php" id="pay">
        <p>
            姓&nbsp;&nbsp;&nbsp;名：<input type="text" name="name" value="" placeholder="姓名" style="border: 1px solid #ccc; height: 1.5rem;" />
        </p>
        <p>
            手机号：<input type="text" name="phone" value="" placeholder="手机号" style="border: 1px solid #ccc; height: 1.5rem;" />
        </p>
        <p>
            金&nbsp;&nbsp;&nbsp;额: <input type="number" name="price" value="" placeholder="支付金额" style="border: 1px solid #ccc; height: 1.5rem;" />
        </p>
        <p>
            <button style="border: 1px solid #ccc;">提交</button>
        </p>
    </form>
</body>
<script>
    var pay = document.querySelector('#pay');

    pay.onsubmit = function (e) {
        e.preventDefault();

        var data = new FormData(this);
        var xhr  = new XMLHttpRequest();

        xhr.onload = function (ev) {
            var res = JSON.parse(ev.currentTarget.responseText);

            if (res.code) {
                alert(res.info);
            } else {
                // 如果jsbridge已经注入则直接调用
                if (window.AlipayJSBridge) {
                    payment(res);
                } else {
                    // 如果没有注入则监听注入的事件
                    document.addEventListener('AlipayJSBridgeReady', function () {
                        payment(res);
                    });
                }
            }
        };

        xhr.open('post', '/apply.php');
        xhr.send(data);
    };

    function payment(res) {
        AlipayJSBridge.call("tradePay", {
            orderStr: res.data
        }, function(result) {
            alert(JSON.stringify(result));
        });
    }
</script>
</html>
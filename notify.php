<?php

# notify.php
# 2018 07 27 下午5:00
# 王磊
# 1992454838@qq.com

file_put_contents('./get', "notify\r\n".json_encode($_GET));

file_put_contents('./post', "notify\r\n".json_encode($_POST));

file_put_contents('./input', "notify\r\n".file_get_contents('php://input'));

die('<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>');
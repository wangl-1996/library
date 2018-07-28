<?php

# result.php
# 2018 07 27 下午4:56
# 王磊
# 1992454838@qq.com


file_put_contents('./get', "result:\r\n".json_encode($_GET));

file_put_contents('./post', "result\r\n".json_encode($_POST));

file_put_contents('./input', "result\r\n", file_get_contents('php://input'));
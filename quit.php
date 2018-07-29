<?php

# quit.php
# 2018 07 28 下午7:28
# 王磊
# 1992454838@qq.com

file_put_contents('./get', "quit:\r\n".json_encode($_GET));

file_put_contents('./post', "quit\r\n".json_encode($_POST));

file_put_contents('./input', "quit\r\n".file_get_contents('php://input'));
<?php

# notify.php
# 2018 07 27 下午5:00
# 王磊
# 1992454838@qq.com

file_put_contents('./notify', "quit:\r\n".json_encode($_GET));

file_put_contents('./notify', "quit\r\n".json_encode($_POST));

file_put_contents('./notify', "quit\r\n".file_get_contents('php://input'));
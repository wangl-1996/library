<?php

# helpers.php
# 2018 07 25 下午1:27
# 王磊
# 1992454838@qq.com

if (!function_exists('dump')) {
    /**
     * 打印
     */
    function dump()
    {
        echo '<pre>';

        foreach (func_get_args() as $val) {
            var_dump($val);
        }

        echo '</pre>';
    }
}
<?php

# wap_pay.php
# 2018 07 27 下午5:03
# 王磊
# 1992454838@qq.com

namespace wangl_1996\library\src\alipay\pay\request;

use wangl_1996\library\src\alipay\pay\config;

/**
 * Class wap_pay
 *
 * @package wangl_1996\library\src\alipay\pay\request
 */
class wap_pay
{
    # 线上
    const ON_LINE = 1;

    # 沙箱
    const ON_DEV = 2;

    /**
     * @var config
     */
    private $config;

    /**
     * @var int
     */
    private $env;

    /**
     * wap_pay constructor.
     *
     * @param int $env
     */
    public function __construct($env = self::ON_DEV)
    {
        $this->env = $env;
    }

    /**
     * @param config $config
     */
    public function exec(config $config)
    {
        $this->config = $config;

        # 缓冲区
        ob_start();

        ob_end_flush();
    }
}
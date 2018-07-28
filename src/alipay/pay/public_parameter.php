<?php

# public_parameter.php
# 2018 07 27 下午4:53
# 王磊
# 1992454838@qq.com

namespace wangl_1996\library\src\alipay\pay;

/**
 * Class public_parameter
 *
 * @package wangl_1996\library\src\alipay\pay
 */
class public_parameter
{
    /**
     * @var string
     */
    private $app_id = '2016091700532623';

    /**
     * @var string
     */
    private $method = 'alipay.trade.wap.pay';

    /**
     * @var string
     */
    private $format = 'JSON';

    /**
     * @var string
     */
    private $return_url = 'http://123.56.86.74/result.php';

    /**
     * @var string
     */
    private $charset = 'utf-8';

    /**
     * @var string
     */
    private $sign_type = 'RSA';

    /**
     * @var string
     */
    private $sign = '';

    /**
     * @var string
     */
    private $timestamp = '';

    /**
     * @var string
     */
    private $version = '';

    /**
     * @var string
     */
    private $notify_url = 'http://123.56.86.74/notify.php';

    /**
     * @var string
     */
    private $biz_content = '';
}
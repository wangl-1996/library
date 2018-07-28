<?php

# sign.php
# 2018 07 27 下午5:22
# 王磊
# 1992454838@qq.com
# 签名

namespace wangl_1996\library\src\alipay\pay;

/**
 * Class sign
 *
 * @package wangl_1996\library\src\alipay\pay
 */
class sign
{
    /**
     * @param  string $privateKey
     * @return resource
     */
    public function getPrivateKey($privateKey)
    {
        return openssl_pkey_get_private($privateKey);
    }

    /**
     * @param  string $publicKey
     * @return resource
     */
    public function getPublicKey($publicKey)
    {
        return openssl_pkey_get_public($publicKey);
    }
}
<?php

# opssl.php
# 2018 07 29 下午12:24
# 王磊
# 1992454838@qq.com
# openssl封装

namespace wangl_1996\library;

/**
 * Class openssl
 *
 * @package wangl_1996\library
 */
class openssl
{
    # openssl签名
    const OPENSSL_SIGN = 1;

    # openssl加密
    const OPENSSL_ENCRYPT = 2;

    # openssl验签
    const OPENSSL_VERIFY = 3;

    /**
     * @var int
     */
    private $mode;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    public $iv;

    /**
     * openssl constructor.
     *
     * @param int $mode
     */
    public function __construct(int $mode = self::OPENSSL_SIGN)
    {
        $this->mode = $mode;
    }

    /**
     * @param string $key
     */
    public function setKey(string $key)
    {
        if ($this->mode == self::OPENSSL_ENCRYPT) {
            $this->key = $key;
        } elseif ($this->mode == self::OPENSSL_SIGN) {
            $this->setPrivateKey($key);
        } elseif ($this->mode == self::OPENSSL_VERIFY) {
            $this->setPublicKey($key);
        }
    }

    /**
     * @param string $key
     */
    private function setPublicKey(string $key)
    {
        $this->key = "-----BEGIN PUBLIC KEY-----\n".wordwrap($key, 64, "\n", true)."\n-----END PUBLIC KEY-----";
    }

    /**
     * @param string $key
     */
    private function setPrivateKey(string $key)
    {
        $this->key = "-----BEGIN RSA PRIVATE KEY-----\n".wordwrap($key, 64, "\n", true)."\n-----END RSA PRIVATE KEY-----";
    }

    /**
     * 扩展是否加载
     *
     * @return bool
     */
    public static function extensionIsLoaded()
    {
        return extension_loaded('openssl');
    }
}
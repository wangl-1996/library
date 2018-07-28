<?php

# aes.php
# 2018 07 27 下午4:21
# 王磊
# 1992454838@qq.com
# aes加密

namespace wangl_1996\library;

/**
 * Class aes
 *
 * @package wangl_1996\library
 */
class aes
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $iv;

    /**
     * aes constructor.
     *
     * @param  string $key
     * @throws \Exception
     */
    public function __construct($key)
    {
        $this->key = $key;
        $this->iv  = random_bytes(16);
    }

    /**
     * 加密方法
     * @param string $str
     * @return string
     */
    public function encrypt($str)
    {
        $encrypt = openssl_encrypt($str, 'AES-128-CBC', $this->key, OPENSSL_RAW_DATA, $this->iv);

        return base64_encode($encrypt);
    }

    /**
     * 解密方法
     * @param string $str
     * @return string
     */
    public function decrypt($str)
    {
        $encrypt = openssl_decrypt(base64_decode($str), 'AES-128-CBC', $this->key, OPENSSL_RAW_DATA, $this->iv);

        return $encrypt;
    }
}
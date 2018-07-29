<?php

# encrypt.php
# 2018 07 29 下午12:50
# 王磊
# 1992454838@qq.com

namespace wangl_1996\library\src\openssl;

/**
 * Class encrypt
 * @package wangl_1996\library\src\openssl
 */
class encrypt
{
    /**
     * @var string
     */
    public $iv;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    public $method = 'AES-128-CBC';

    /**
     * @var int
     */
    public $option = OPENSSL_RAW_DATA;

    /**
     * encrypt constructor.
     * @param string $key
     * @param string $iv
     * @throws \Exception
     */
    public function __construct(string $key, string $iv = '')
    {
        $this->key = $key;
        $this->iv  = $iv;
    }

    /**
     * 加密
     * @param string $data 待加密字符串
     * @return string 返回加密后的字符串
     */
    public function getEncrypt($data)
    {
        $encrypt = @openssl_encrypt($data, $this->method, $this->key, $this->option, $this->iv);

        //返回false，加密失败
        if (false === $encrypt) {
            return '';
        }

        //返回原始数据时，进行编码
        if (OPENSSL_RAW_DATA == ($this->option & OPENSSL_RAW_DATA)) {
            return base64_encode($encrypt);
        }

        return $encrypt;
    }

    /**
     * 解密
     * @param string $data 待解密字符串
     * @return string 返回解密后内容
     */
    public function getDecrypt($data)
    {
        //加密时，返回编码数据，解密时进行解码
        if (OPENSSL_RAW_DATA == ($this->option & OPENSSL_RAW_DATA)) {
            $data = base64_decode($data);
        }

        $decrypt = @openssl_decrypt($data, $this->method, $this->key, $this->option, $this->iv);

        //返回false，解密失败
        if (false === $decrypt) {
            return '';
        }

        return $decrypt;
    }

    /**
     * 获取随机iv
     * @return string
     * @throws \Exception
     */
    public function getIv()
    {
        return random_bytes(16);
    }
}
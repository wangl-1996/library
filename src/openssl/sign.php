<?php

# sign.php
# 2018 07 29 下午1:25
# 王磊
# 1992454838@qq.com
# openssl 签名

namespace wangl_1996\library\src\openssl;

/**
 * Class sign
 * @package wangl_1996\library\src\openssl
 */
class sign
{
    /**
     * @var string
     */
    public $priKey;

    /**
     * @var string
     */
    public $pubKey;

    /**
     * @var int
     */
    public $alg = OPENSSL_ALGO_SHA1;

    /**
     * 签名
     * @param string $data 待签名的数据
     * @return string 返回签名
     */
    public function getSign($data)
    {
        if (false === openssl_sign($data, $sign, $this->priKey, $this->alg)) {
            return '';
        } else {
            return base64_encode($sign);
        }
    }

    /**
     * 验签
     * @param string $data 加签原始数据
     * @param string $sign 待验证待签名
     * @return bool 返回原始数据加签后是否和给定签名相等
     */
    public function verify($data, $sign)
    {
        return (bool)openssl_verify($data, base64_decode($sign), $this->pubKey, $this->alg);
    }

    /**
     * 格式化公匙
     * @param string $key
     * @return string
     */
    public function formatPubKey($key)
    {
        //已经格式化好的
        if (false !== stripos($key, '-----BEGIN PUBLIC KEY-----')) {
            return $key;
        }

        return "-----BEGIN PUBLIC KEY-----\n".
            wordwrap($key, 64, "\n", true).
            "\n-----END PUBLIC KEY-----";
    }

    /**
     * 格式化私匙
     * @param string $key
     * @return string
     */
    public function formatPriKey($key)
    {
        //已经格式化好的
        if (false !== stripos($key, '-----BEGIN RSA PRIVATE KEY-----')) {
            return $key;
        }

        return "-----BEGIN RSA PRIVATE KEY-----\n".
            wordwrap($key, 64, "\n", true).
            "\n-----END RSA PRIVATE KEY-----";
    }

    /**
     * 格式化数据
     * @param array $data 待可格式化数组
     * @param string $split 值和值之间的分隔
     * @param \Closure $map 回调函数
     * @return string
     */
    public function formatSignString(array $data, $split = '&', \Closure $map = null)
    {
        $string = '';
        $splitString = '';

        foreach ($data as $key => $val) {
            //回调函数过滤值
            if (null !== $map) {
                $val = $map($val, $key);

                //过滤掉的值
                if (null === $val) {
                    continue;
                }
            }

            $string .= $splitString.$key.'='.$val;
            $splitString = $split;
        }

        return $string;
    }
}
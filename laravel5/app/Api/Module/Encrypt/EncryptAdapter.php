<?php

namespace App\Api\Module\Encrypt;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Encryption\Encrypter;

/**
 * Class EncryptAdapter
 * @package App\Api\EncryptModule
 */
class EncryptAdapter extends AbstractEncrypt
{
    /**
     * @var Encrypter
     */
    protected $_encrypter;

    public function  __construct()
    {
        $random_key = env('APP_KEY');
        $encrypt = new Encrypter($random_key, 'AES-256-CBC');
        $this->_encrypter = $encrypt;
    }


    /**
     * 功能：对参数$var进行加密
     *
     * @param $var
     * @return string
     */
    public function doEncrypt($var)
    {
        $encrypted =  $this->_encrypter->encrypt($var);
        return $encrypted;
    }


    /**
     * 功能：对参数$var进行解密
     *
     * @param $var
     * @return string
     */
    public function doDecrypt($var)
    {
        $decrypted = "";
        try{
            $decrypted = $this->_encrypter->decrypt($var);
        }catch (DecryptException $e){
            $e->getMessage();
        }
        return $decrypted;
    }
}
<?php

namespace App\Api\Module\Encrypt\EncryptFactory;

use App\Api\Module\Contracts\AbstractFactory;
use App\Api\Module\Encrypt\EncryptAdapter;

class EncryptFactory extends AbstractFactory
{
    /**
     * @var Singleton reference to singleton instance
     */
    private static $__instance = null;

    /**
     * 通过延迟加载（用到时才加载）获取实例
     *
     * @return self
     */
    public static function getInstance(){
        if(self::$__instance == null){
            self::$__instance = new EncryptFactory();
        }
        return self::$__instance;
    }

    /**
     * 构造函数私有，不允许在外部实例化
     */
    private function __construct()
    {
    }

    /**
     * 防止对象实例被克隆
     *
     * @return void
     */
    private function __clone()
    {
    }

    public function createEncrypt()
    {
        return new EncryptAdapter();
    }
}
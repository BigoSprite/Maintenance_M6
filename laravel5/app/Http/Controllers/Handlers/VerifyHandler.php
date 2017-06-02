<?php

namespace App\Http\Controllers\Handlers;


class VerifyHandler
{
    private static $__instance = null;

    public static function getInstance(){
        if (self::$__instance == null) {
            self::$__instance = new VerifyHandler();
        }
        return self::$__instance;
    }

    /*
     * 功能：判断参数是否合法
     * @param $gprsID：设备的gprsID
     * @return boolean
     *
     * 合法值：11位纯数字或字符串
     */
    public function isLegal($gprsID)
    {
        $retBoolean = false;

        $str = (string)$gprsID;
        if(preg_match('/^\d{10}$/', $str) == 1){
            $retBoolean = true;
        }

        return $retBoolean;
    }


}

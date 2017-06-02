<?php

namespace App\Http\Controllers\Handlers;

class StringHandler
{
    private static $__instance = null;

    public static function getInstance(){
        if (self::$__instance == null) {
            self::$__instance = new StringHandler();
        }
        return self::$__instance;
    }

    /*
     * 功能：数字字符串$gprsID转换为10位字符串，左边补零
     * @param $gprsID：不足10位的数字
     *
     * @return 10位字符串的gprsID
     */
    public function int2str_tenLength($gprsID){

        if( strlen((string)$gprsID) < 10 ){
            $ret = str_pad((int)$gprsID, 10, "0", STR_PAD_LEFT);
        }else{
            $ret = (string)$gprsID;
        }

        return $ret;
    }

}

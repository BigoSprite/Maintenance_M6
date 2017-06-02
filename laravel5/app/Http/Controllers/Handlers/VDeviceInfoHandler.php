<?php

namespace App\Http\Controllers\Handlers;

use App\Http\Controllers\Controller;
use App\Models\Node\VDeviceInfoModel;

class VDeviceInfoHandler extends Controller
{
    /**
     * 创建型方法
     *
     * @return VDeviceInfoHandler|null
     */
    public static function create(){
        $instance = new VDeviceInfoHandler();
        if($instance != null){
            return $instance;
        }else{
            return null;
        }
    }


    /**
     * 功能：返回对象数组
     *
     * @param $gprsId
     * @return objectArray
     *
     * [
     *    (
            "alias":"var00",
            "name_en":"AVoltage",
            "name_ch":"A相电压",
            "data_type":"short",
            "byte_seq":"BE",
            "scale":"0.1",
            "unit":"V",
            "width":"90"
          ),// one object
     *    ...
     * ]
     *
     */
    public function getParseJSON($gprsId)
    {
        $model = VDeviceInfoModel::where('gprsID', $gprsId)->first(['parseJSON']);

        $objArray = array();
        if($model != null){
            $obj = json_decode("{$model['parseJSON']}");
            $objArray = $obj->data;
        }

        return $objArray;
    }
}

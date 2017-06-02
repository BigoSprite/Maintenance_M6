<?php
/**
 * Created by PhpStorm.
 * User: fm
 * Date: 2017/5/26
 * Time: 10:40
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\VDeviceInfo_Model;

class VDeviceInfo_Handler extends Controller
{
    public function __construct()
    {
    }

    public static function create(){
        $instance = new VDeviceInfo_Handler();
        if($instance != null){
            return $instance;
        }else{
            return null;
        }
    }

    // http://localhost:8888/api/content/deviceRealTimeDataTable_bodyData/0000000001
    public function getParseJSON($gprsId)
    {
        $model = VDeviceInfo_Model::where('gprsID', $gprsId)->get(['parseJSON']);

        $objArray = array();
        if($model != null){
            $obj = json_decode("{$model[0]->parseJSON}");
            $objArray = $obj->data;
        }

        return $objArray;
    }

}
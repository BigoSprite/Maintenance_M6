<?php

namespace App\Http\Controllers\Node;

use App\Http\Controllers\Api\Node\VDeviceInfoApi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class VDeviceInfoController extends Controller
{
    /**
     * 功能：判断$gprsID对应的设备是否存在
     * @param $gprsId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/verify/deviceInfo/0000000001
     */
    public function isGprsIdExist($gprsId)
    {
        $arr = VDeviceInfoApi::create()->isGprsIdExist($gprsId);

        return response(json_encode($arr), JSON_UNESCAPED_UNICODE);
    }

    /**
     * 功能：获取$gprsId对应的设备信息
     * @param $gprsId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/deviceInformation/0000000002
     */
    public function getDeviceInfo($gprsId)
    {
        $arr = VDeviceInfoApi::create()->getDeviceInfo($gprsId);

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 功能：获取全部设备的信息
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/deviceInformation
     */
    public function getDeviceInfoList()
    {
        $arr = VDeviceInfoApi::create()->getDeviceInfoList();

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 功能：注册设备
     * @return \Illuminate\Http\JsonResponse
     *
     * 响应请求 方法 POST
     * http://localhost:8888/api/content/register/device
     * http://localhost:8888/ajaxPost
     */
    public function registerDeviceInfo()
    {
        $gprsID = Input::get('gprsID');
        $data = [
            "gprsID"=> $gprsID,
            "deviceName"=> Input::get('deviceName'),
            "deviceTypeName"=> Input::get('deviceTypeName'),
            "deviceRemark"=> Input::get('deviceRemark'),
            "monitoredUnitName"=> Input::get('monitoredUnitName'),
            "realestateinfo_dbName"=>Input::get('realestateinfo_dbName'),
            "protocolVersion"=>Input::get('protocolVersion'),
            "protocolRemark"=>Input::get('protocolRemark'),
            "contactPersonName"=>Input::get('contactPersonName'),
            "contactTel"=>Input::get('contactTel'),
            "deviceDetailInfo"=>Input::get('deviceDetailInfo'),
//                "parseJSON"=>Input::get('parseJSON'),
            "isDiscarded"=>Input::get('isDiscarded'),
            "addDate"=> Input::get('addDate'),
        ];

        $arr = VDeviceInfoApi::create()->registerDeviceInfo($data, 'gprsID', $gprsID);

        return response()->json($arr, 200);
    }

    /**
     * 功能：更新设备
     * @return \Illuminate\Http\JsonResponse
     *
     * 响应请求 方法 POST
     * http://localhost:8888/api/content/update/device
     * http://localhost:8888/ajaxPost
     */
    public function updateDeviceInfo()
    {
        $gprsID = Input::get('gprsID');
        $data = [
            "gprsID"=> $gprsID,
            "deviceName"=> Input::get('deviceName'),
            "deviceTypeName"=> Input::get('deviceTypeName'),
            "deviceRemark"=> Input::get('deviceRemark'),
            "monitoredUnitName"=> Input::get('monitoredUnitName'),
            "realestateinfo_dbName"=>Input::get('realestateinfo_dbName'),
            "protocolVersion"=>Input::get('protocolVersion'),
            "protocolRemark"=>Input::get('protocolRemark'),
            "contactPersonName"=>Input::get('contactPersonName'),
            "contactTel"=>Input::get('contactTel'),
            "deviceDetailInfo"=>Input::get('deviceDetailInfo'),
//                "parseJSON"=>Input::get('parseJSON'),
            "isDiscarded"=>Input::get('isDiscarded'),
            "addDate"=> Input::get('addDate'),
        ];

        $arr = VDeviceInfoApi::create()->updateDeviceInfo($data, 'gprsID', $gprsID);

        return response()->json($arr, 200);
    }

}

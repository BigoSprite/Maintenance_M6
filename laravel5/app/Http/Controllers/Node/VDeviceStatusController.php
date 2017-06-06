<?php

namespace App\Http\Controllers\Node;

use App\Api\Node\VDeviceStatusApi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class VDeviceStatusController extends Controller
{
    /**
     * 功能：验证gprsId是否存在
     * @param $gprsId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/verify/deviceStatus/0000000001
     */
    public function isGprsIdExist($gprsId)
    {
        $arr = VDeviceStatusApi::create()->isGprsIdExist($gprsId);
        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 功能：获取特定grsID的设备的状态
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/deviceStatus/0000000002
     */
    public function getDeviceStatus($gprsID)
    {
        $arr = VDeviceStatusApi::create()->getDeviceStatus($gprsID);

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 功能：获取全部设备的状态
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/deviceStatusList
     */
    public function getDeviceStatusList()
    {
        $arr = VDeviceStatusApi::create()->getDeviceStatusList();

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 功能：注册设备状态
     * @return \Illuminate\Http\JsonResponse
     *
     * 响应请求 方法 POST
     * http://localhost:8888/api/content/register/deviceStatus
     * http://localhost:8888/ajaxPost
     */
    public function registerDeviceStatus()
    {
        $gprsid =  Input::get('gprsID');
        $data = [
            'gprsID' => $gprsid,
            'isLogin' => Input::get('isLogin'),
            'lastLoginTime' => Input::get('lastLoginTime'),
            'alarmFlag' => Input::get('alarmFlag'),
            'alarmUpdateTime' => Input::get('alarmUpdateTime'),
            'isOperating' => Input::get('isOperating'),
            'operationDesc' => Input::get('operationDesc'),
            'operationUpdateTime' => Input::get('operationUpdateTime')
        ];

        $arr = VDeviceStatusApi::create()->register($data, 'gprsID', $gprsid);

        return response()->json($arr, 200);
    }

    /**
     * 功能：更新设备状态
     * @return \Illuminate\Http\JsonResponse
     *
     * 响应请求 方法 POST
     * http://localhost:8888/api/content/update/deviceStatus
     * http://localhost:8888/ajaxPost
     */
    public function updateDeviceStatus()
    {
        $gprsid =  Input::get('gprsID');
        $data = [
            'gprsID' => $gprsid,
            'isLogin' => Input::get('isLogin'),
            'lastLoginTime' => Input::get('lastLoginTime'),
            'alarmFlag' => Input::get('alarmFlag'),
            'alarmUpdateTime' => Input::get('alarmUpdateTime'),
            'isOperating' => Input::get('isOperating'),
            'operationDesc' => Input::get('operationDesc'),
            'operationUpdateTime' => Input::get('operationUpdateTime')
        ];

        $arr = VDeviceStatusApi::create()->update($data, 'gprsID', $gprsid);

        return response()->json($arr, 200);
    }
}

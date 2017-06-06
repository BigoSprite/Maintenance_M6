<?php

namespace App\Http\Controllers\Client;

use App\Api\Client\VDeviceTypeInfoApi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class VDeviceTypeInfoController extends Controller
{
    /**
     * 功能：验证设备类型是否存在
     * @param $name
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/verify/deviceType/US2000
     */
    public function isDeviceTypeExist($name)
    {
        $arr = VDeviceTypeInfoApi::create()->isDeviceTypeExist($name);

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 功能：获得特定设备类型名称（name）的设备信息
     * @param $name
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/deviceTypeInfo/US2000
     */
    public function getDeviceTypeInfo($name)
    {
        $arr = VDeviceTypeInfoApi::create()->getDeviceTypeInfo($name);

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 功能：获取所有设备类型的信息
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/deviceTypeInfoList
     */
    public function getDeviceTypeInfoList()
    {
        $arr = VDeviceTypeInfoApi::create()->getDeviceTypeInfoList();

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 功能：注册设备类型信息
     * @return \Illuminate\Http\JsonResponse
     *
     * 响应请求 方法 POST
     * http://localhost:8888/api/content/register/deviceTypeInfo
     * http://localhost:8888/ajaxPost
     */
    public function registerDeviceType()
    {
        $name = Input::get('name');
        $data = [
            'name' => $name,
            'typeDesc'=>Input::get('typeDesc')
        ];

        $arr =  VDeviceTypeInfoApi::create()->register($data, 'name', $name);
        return response()->json($arr, 200);
    }

    /**
     * 功能：更新设备类型信息
     * @return \Illuminate\Http\JsonResponse
     *
     * 响应请求 方法 POST
     * http://localhost:8888/api/content/update/deviceTypeInfo
     * http://localhost:8888/ajaxPost
     */
    public function updateDeviceType()
    {
        $name = Input::get('name');
        $data = [
            'name' => $name,
            'typeDesc'=>Input::get('typeDesc')
        ];

        $arr =  VDeviceTypeInfoApi::create()->update($data, 'name', $name);
        return response()->json($arr, 200);
    }
}

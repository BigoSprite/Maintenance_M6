<?php

namespace App\Http\Controllers\Node;

use App\Api\Node\VDeviceRealTimeDataApi;
use App\Http\Controllers\Controller;

class VDeviceRealTimeDataController extends Controller
{
    /**
     * 功能：验证设备是否存在
     * @param $gprsId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/verify/deviceRealTime/0000000001
     */
    public function isDeviceExist($gprsId)
    {
        $arr = VDeviceRealTimeDataApi::create()->isGprsIdExist($gprsId);

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 功能：获取$gprsId对应的实时数据——表头
     * @param $gprsId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/deviceRealTimeDataTable_headerData/0000000001
     */
    public function getTableHeader($gprsId)
    {
        $arr = VDeviceRealTimeDataApi::create()->getTableHeader($gprsId);

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 功能：获取$gprsId对应的实时数据
     * @param $gprsId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/deviceRealTimeDataTable_bodyData/0000000001
     */
    public function getRealTimeData($gprsId)
    {
        $arr = VDeviceRealTimeDataApi::create()->getRealTimeData($gprsId);

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

}















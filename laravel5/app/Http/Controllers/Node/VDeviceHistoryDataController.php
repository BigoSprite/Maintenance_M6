<?php

namespace App\Http\Controllers\Node;

use App\Api\Node\VDeviceHistoryDataApi;
use App\Http\Controllers\Controller;

class VDeviceHistoryDataController extends Controller
{
    /**
     * 功能：获取“历史数据”表头
     * @param $gprsId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/deviceHistoryDataTable_headerData/0000000001
     */
    public function getTableHeader($gprsId)
    {
        $arr = VDeviceHistoryDataApi::create()->getTableHeader($gprsId);

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }


    /**
     * 功能：从历史数据表中获得gprsid对应的设备历史数据
     * @param $gprsId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/deviceHistoryDataTable_bodyData/0000000001
     */
    public function getHistoryData($gprsId)
    {
        $arr = VDeviceHistoryDataApi::create()->getHistoryData($gprsId);

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }
}

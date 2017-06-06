<?php

namespace App\Http\Controllers\Node;

use App\Api\Node\VDeviceNodeInfoApi;
use App\Http\Controllers\Controller;

class VDeviceNodeInfoController extends Controller
{
    /**
     * 功能：判断$nodeName对应的节点是否存在
     * @param $nodeName
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/verify/deviceNodeInfo/jinye
     */
    public function isNodeExist($nodeName)
    {
        $arr = VDeviceNodeInfoApi::create()->isNodeExist($nodeName);

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 功能：获取$nodeName对应的节点信息
     * @param $nodeName
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/deviceNodeInfo/jinye
     */
    public function getNodeInfo($nodeName)
    {
        $arr = VDeviceNodeInfoApi::create()->getNodeInfo($nodeName);

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 功能：获取全部节点信息
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/deviceNodeInfoList
     */
    public function getNodeList()
    {
        $arr = VDeviceNodeInfoApi::create()->getNodeList();

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 功能：注册
     * @param $data
     * @param $primaryKey
     * @param $value
     * @return array
     */
    public function register($data, $primaryKey, $value)
    {
        //
    }

    /**
     * 功能：更新
     * @param $data
     * @param $primaryKey
     * @param $value
     * @return array
     */
    public function update($data, $primaryKey, $value)
    {
       //
    }

}

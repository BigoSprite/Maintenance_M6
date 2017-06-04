<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\NodeInfoApi;
use Illuminate\Support\Facades\Input;

class NodeInfoController extends Controller
{
    /**
     * 功能：判断数据库是否存在某节点
     *
     * @param $nodeName
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/admin/verify/node/成都
     */
    public function isNodeExist($nodeName)
    {
        $arr = NodeInfoApi::create()->isNodeExist($nodeName);

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 功能：获取所有节点信息
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/admin/nodeInfoList
     */
    public function all()
    {
        $arr = NodeInfoApi::create()->all();

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 功能：获取节点名字列表
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/admin/nodeNameList
     */
    public function getNodeNameList()
    {
        $arr = NodeInfoApi::create()->getNodeNameList();

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 功能：获取节点信息
     *
     * @param $nodeName
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/admin/nodeServerInfo/成都
     */
    public function getNodeServerInfo($nodeName)
    {
        $arr = NodeInfoApi::create()->getNodeServerInfo($nodeName);

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 功能：注册新节点
     * @return \Illuminate\Http\JsonResponse
     *
     * 响应请求 方法 POST
     * http://localhost:8888/api/admin/register/node
     * http://localhost:8888/ajaxPost
     */
    public function registerNodeInfo()
    {
        $nodeName = Input::get('nodeName');
        $nodeIp = Input::get('nodeIp');
        $nodeUserName = Input::get('nodeUserName');
        $nodePassword = Input::get('nodePassword');
        $address = Input::get('address');
        $remark = Input::get('remark');

        $data = [
            'nodeName'=>$nodeName,
            'nodeIp'=>$nodeIp,
            'nodeUserName'=>$nodeUserName,
            'nodePassword'=>$nodePassword,
            'address'=>$address,
            'remark'=>$remark,
        ];

        $arr = NodeInfoApi::create()->registerNodeInfo($data, 'nodeName', $nodeName);

        return response()->json($arr, 200);
    }

    /**
     * 功能：更新节点信息
     * @return \Illuminate\Http\JsonResponse
     *
     * 响应请求 方法 POST
     * http://localhost:8888/api/admin/update/node
     * http://localhost:8888/ajaxPost
     */
    public function updateNodeInfo()
    {
        $nodeName = Input::get('nodeName');
        $nodeIp = Input::get('nodeIp');
        $nodeUserName = Input::get('nodeUserName');
        $nodePassword = Input::get('nodePassword');
        $address = Input::get('address');
        $remark = Input::get('remark');

        $data = [
            'nodeName'=>$nodeName,// TODO... 这里的nodeName不应该被修改，
            'nodeIp'=>$nodeIp,
            'nodeUserName'=>$nodeUserName,
            'nodePassword'=>$nodePassword,
            'address'=>$address,
            'remark'=>$remark,
        ];

        $arr = NodeInfoApi::create()->updateNodeInfo($data, 'nodeName', $nodeName);

        return response()->json($arr, 200);
    }
}

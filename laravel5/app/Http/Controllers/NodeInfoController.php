<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\NodeInfoApi;
use Illuminate\Http\Request;

use App\Http\Requests;

class NodeInfoController extends Controller
{


    public function isNodeExist($nodeName)
    {}


    // http://localhost:8888/api/admin/nodeInfoList
    public function all()
    {
        $arr = NodeInfoApi::create()->all();

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    // http://localhost:8888/api/admin/nodeNameList
    public function getNodeNameList()
    {
        $arr = NodeInfoApi::create()->getNodeNameList();

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    // http://localhost:8888/api/admin/nodeServerInfo/成都
    public function getNodeServerInfo($nodeName)
    {
        $arr = NodeInfoApi::create()->getNodeServerInfo($nodeName);

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    public function registerNodeInfo()
    {

    }

    public function updateNodeInfo()
    {

    }
}

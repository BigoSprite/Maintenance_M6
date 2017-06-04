<?php

namespace App\Http\Controllers\Node;

use App\Http\Controllers\Api\Node\Real_Estate_Info_Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class Real_Estate_Info_Controller extends Controller
{
    /**
     * 功能：判断$dbName对应的物业信息是否存在
     * @param $dbName
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/verify/node/realEstateInfo/jinyehotel
     */
    public function isDBNameExist($dbName)
    {
        $arr = Real_Estate_Info_Api::create()->isDBNameExist($dbName);

        return response(json_encode($arr), JSON_UNESCAPED_UNICODE);
    }

    /**
     * 功能：获取$dbName对应的物业信息
     * @param $dbName
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/node/realEstateInfo/jinyehotel
     */
    public function get_Real_Estate_Info($dbName)
    {
        $arr = Real_Estate_Info_Api::create()->get_Real_Estate_Info($dbName);

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 功能：获取全部物业信息
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/node/realEstateInfoList
     */
    public function get_Real_Estate_Info_List()
    {
        $arr = Real_Estate_Info_Api::create()->get_Real_Estate_Info_List();

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 功能：注册
     * @return \Illuminate\Http\JsonResponse
     *
     * 响应请求 方法 POST
     * http://localhost:8888/api/content/register/node/realEstateInfo
     * http://localhost:8888/ajaxPost
     */
    public function register_Real_Estate_Info()
    {
        $dbName = Input::get('dbName');
        $data = [
            "dbName"=> $dbName,
            "realEstateName"=> Input::get('realEstateName'),
            "address"=> Input::get('address'),
            "description"=> Input::get('description'),
        ];

        $arr = Real_Estate_Info_Api::create()->register($data, 'dbName', $dbName);

        return response()->json($arr, 200);
    }

    /**
     * 功能：更新
     * @return \Illuminate\Http\JsonResponse
     *
     * 响应请求 方法 POST
     * http://localhost:8888/api/content/update/node/realEstateInfo
     * http://localhost:8888/ajaxPost
     */
    public function update_Real_Estate_Info()
    {
        $dbName = Input::get('dbName');
        $data = [
            "dbName"=> $dbName,
            "realEstateName"=> Input::get('realEstateName'),
            "address"=> Input::get('address'),
            "description"=> Input::get('description'),
        ];

        $arr = Real_Estate_Info_Api::create()->update($data, 'dbName', $dbName);

        return response()->json($arr, 200);
    }
}

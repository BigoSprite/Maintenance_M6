<?php

namespace App\Http\Controllers\Client;

use App\Api\Client\AssetInfoApi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class AssetInfoController extends Controller
{
    /**
     * 功能：获得所有资产
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/assetInfoList
     */
    public function getAssetInfoList()
    {
        $arr = AssetInfoApi::create()->getAssetInfoList();

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 功能：注册
     * @return \Illuminate\Http\JsonResponse
     *
     * 响应请求 方法 POST
     * http://localhost:8888/api/content/register/assetInfo
     * http://localhost:8888/ajaxPost
     */
    public function registerAssetInfo()
    {
        $distributionRoomInfo_serialId = Input::get('distributionRoomInfo_serialId');
        $data = [
            'distributionRoomInfo_serialId'=>$distributionRoomInfo_serialId,
            'name'=>Input::get('name'),
            'type'=>Input::get('type'),
            'unit'=>Input::get('unit'),
            'amount'=>Input::get('amount'),
            'addDate'=>Input::get('addDate'),
        ];

        // TODO... AssetInfo表需要重新设计。。。。。。。主要是主键的问题
        $arr = AssetInfoApi::create()->register($data, 'distributionRoomInfo_serialId', $distributionRoomInfo_serialId);

        return response()->json($arr, 200);
    }

//    /**
//     * 功能：更新
//     * @return \Illuminate\Http\JsonResponse
//     *
//     * 响应请求 方法 POST
//     * http://localhost:8888/api/content/update/assetInfo
//     * http://localhost:8888/ajaxPost
//     */
//    public function updateAssetInfo()
//    {
//        $distributionRoomInfo_serialId = Input::get('distributionRoomInfo_serialId');
//        $data = [
//            'distributionRoomInfo_serialId'=>$distributionRoomInfo_serialId,
//            'name'=>Input::get('name'),
//            'type'=>Input::get('type'),
//            'unit'=>Input::get('unit'),
//            'amount'=>Input::get('amount'),
//            'addDate'=>Input::get('addDate'),
//        ];
//
//        $arr = AssetInfoApi::create()->update($data, 'distributionRoomInfo_serialId', $distributionRoomInfo_serialId);
//
//        return response()->json($arr, 200);
//    }
}

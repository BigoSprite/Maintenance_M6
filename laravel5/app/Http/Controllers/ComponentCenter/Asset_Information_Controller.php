<?php

namespace App\Http\Controllers\ComponentCenter;

use App\Http\Controllers\Controller;
use App\ModelCenter\Asset_Information_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class Asset_Information_Controller extends Controller
{
    /*
     * 功能：获得asset_info表中的取所有行
     * @return：json
     *
     * 响应请求 方法 GET
     */
    public function getAssetInfoList2Json()
    {
        $assetList = Asset_Information_Model::all();

        $retArray = array();

        foreach ($assetList as $item) {

            $id = $item->id;
            $serialId = $item->serialId;
            $name = $item->name;
            $type = $item->type;
            $unit = $item->unit;
            $amount = $item->amount;
            $addDate = (string)$item->addDate;

            $tmpArray = [
//                'id'=>$id,
                'serialId'=>$serialId, // TODO
                'name'=>$name,
                'type'=>$type,
                'unit'=>$unit,
                'amount'=>$amount,
                'addDate'=>$addDate
            ];

            $retArray[] = $tmpArray;
        }

        return response(json_encode(['data'=>$retArray], JSON_UNESCAPED_UNICODE));
    }

    /*
     * 功能：插入一行到asset_info表
     * @return：json
     *
     * 响应请求 方法 POST
     */
    public function insertAssetInfo(Request $request){

        $assetInfoModel = new Asset_Information_Model;
        $assetInfoModel->serialId = Input::get('serialId');
        $assetInfoModel->name = Input::get('name');
        $assetInfoModel->type = Input::get('type');
        $assetInfoModel->unit = Input::get('unit');
        $assetInfoModel->amount = Input::get('amount');
        $assetInfoModel->addDate = Input::get('addDate');

        // save方法——可用于插入和更新
        if($assetInfoModel->save()){
            return response()->json(['status'=>'success'], 200);
        }else{
            return response()->json(['status'=>'fail'], 500);
        }
    }
}

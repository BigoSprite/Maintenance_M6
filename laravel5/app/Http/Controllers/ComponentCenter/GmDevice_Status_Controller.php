<?php

namespace App\Http\Controllers\ComponentCenter;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ModelCenter\GmDevice_Status_Model;

class GmDevice_Status_Controller extends Controller
{
    /*
     * 功能：获取全部设备的状态
     * @return：json
     *
     * 响应请求 方法 GET
     */
    public function getGmDeviceStatusList2Json()
    {
        $statusModelArray = GmDevice_Status_Model::all();

        $resultArray = array();
        if(count($statusModelArray) > 0) {
            foreach ($statusModelArray as $item) {
                $tmpArray = [
                    'gprsID' => $item->gprsID,
                    'isLogin' => $item->isLogin,
                    'lastLoginTime' => (string)$item->lastLoginTime,
                    'alarmFlag' => (string)$item->alarmFlag,
                    'alarmUpdateTime' => (string)$item->alarmUpdateTime,
                    'isOperating' => (string)$item->isOperating,
                    'operationDesc' => $item->operationDesc,
                    'operationUpdateTime' => (string)$item->operationUpdateTime
                ];

                $resultArray[] = $tmpArray;
            }
        }
        return response(json_encode(['data'=>$resultArray]));
    }

    /*
     * 功能：获取特定grsID的设备的状态
     * @return：json
     *
     * 响应请求 方法 GET
     */
    public function getGmDeviceStatus2Json($gprsID)
    {
        $statusModel = GmDevice_Status_Model::where('gprsID', $gprsID)->first();
        $resultArray = null;
        if($statusModel != null){
            $resultArray = [
                'gprsID' => $statusModel->gprsID,
                'isLogin' => $statusModel->isLogin,
                'lastLoginTime' => (string)$statusModel->lastLoginTime,
                'alarmFlag' => (string)$statusModel->alarmFlag,
                'alarmUpdateTime' => (string)$statusModel->alarmUpdateTime,
                'isOperating' => (string)$statusModel->isOperating,
                'operationDesc' => $statusModel->operationDesc,
                'operationUpdateTime' => (string)$statusModel->operationUpdateTime
            ];
        }

        return response(json_encode(['data'=>$resultArray]));
    }

    /*
    * 功能：插入一行设备状态
    * @return：json
    *
    * 响应请求 方法 POST
    */
    public function insertGmDeviceStatus()
    {
        $gprsid =  Input::get('gprsID');
        $model = GmDevice_Status_Model::where('gprsID', $gprsid)->first();
        if($model == null){
            $statusModel = new GmDevice_Status_Model;
            $statusModel->gprsID = $gprsid;
            $statusModel->isLogin = Input::get('isLogin');
            $statusModel->alarmFlag = Input::get('alarmFlag');
            $statusModel->alarmUpdateTime = Input::get('alarmUpdateTime');
            $statusModel->isOperating = Input::get('isOperating');
            $statusModel->operationDesc = Input::get('operationDesc');
            $statusModel->operationUpdateTime = Input::get('operationUpdateTime');

            // save方法——可用于插入和更新
            if($statusModel->save()){
                return response()->json(['status'=>'success'], 200);
            }else{
                return response()->json(['status'=>'fail'], 501);
            }
        }else{
            return response()->json(['status'=>'fail'], 502);
        }
    }

}

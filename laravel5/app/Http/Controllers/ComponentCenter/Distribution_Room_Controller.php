<?php

namespace App\Http\Controllers\ComponentCenter;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utility\DBConnectinHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\ModelCenter\Distribution_Room_Model;

class Distribution_Room_Controller extends Controller
{
    /*
     * 功能：从distributionRoom表中获得所有配电室
     * @return：json
     *
     * 响应请求 方法 GET
     */
    public function getDistributeRoomList2Json()
    {
        $roomArray = DB::select('SELECT serialId, roomName FROM distributionRoom');
        //$roomArray = Distribution_Room_Model::select(['serialId', 'roomName'])->get();
        $retArray = array();
        if(count($roomArray) > 0){
            foreach ($roomArray as $item) {
                $serialId = $item->serialId;
                $roomName = $item->roomName;
                $tmpArray = [
                    "name"=> $roomName,
                    "serialId"=>$serialId
                ];

                $retArray[] = $tmpArray;
            }

            return response(json_encode(["data"=>$retArray], JSON_UNESCAPED_UNICODE));
        }
    }

    /*
     * 功能：从distributionRoom表中获得“某序列号”对应的一行（配电室的所有属性）
     * @param $serialId：配电室的序列号，对应表从distributionRoom表中获得中的主键
     * @return：json
     *
     * 响应请求 方法 GET
     */
    public function getDistributionRoomInfo2Json($serialId)
    {
        $room_info = $this->__getRoomInfo_Ex($serialId);
        $deviceListInfo = $this->__getDeviceListInfo($serialId);
        return response(json_encode(["data"=>["roomInfo"=>$room_info, "deviceListInfo"=>$deviceListInfo]], JSON_UNESCAPED_UNICODE));
    }

    /*
     * 功能：注册配电室---插入一行数据到表distributionroom
     * @param Illuminate\Http\Request Request：用于获取请求携带的数据（这里没使用）
     * @return：json
     *
     * 响应请求 方法 POST
     */
    public function registerDistributionRoom(Request $request)
    {
        $serialId = Input::get('serialId');
        $roomName = Input::get('roomName');
        $description = Input::get('description');
        $address = Input::get('address');
        $productionPro = Input::get('productionPro');
        $telephoneNumber = Input::get('telephoneNumber');
        $installationDate = Input::get('installationDate');

        $info = DB::select("SELECT serialId FROM distributionRoom WHERE  serialId = {$serialId}");

        if(count($info) > 0){
            $retArray = [
                'status'=>'fail',
                'isExist'=>'true'
            ];
        }else{// 数据库不存在该条数据
            DB::table('distributionRoom')->insert(
                [
                    'serialId' => $serialId,
                    'roomName' => $roomName,
                    'description' => $description,
                    'address' => $address,
                    'productionPro' => $productionPro,
                    'telephoneNumber' =>  $telephoneNumber,
                    'installationDate' => $installationDate
                ]
            );
            $retArray = [
                'status'=>'success',
                'isExist'=>'false'
            ];
        }

        return response()->json($retArray, 200);
    }

    // 从表中获取一行
    private function __getRoomInfo_Ex($serialId)
    {
        $roomInfoModel = Distribution_Room_Model::where('serialId',$serialId)->first();

        if($roomInfoModel != null) {

            $roomInfo = [
                'serialId' => $roomInfoModel->serialId,
                'roomName' => $roomInfoModel->roomName,
                'description' => $roomInfoModel->description,
                'address' => $roomInfoModel->address,
                'productionPro' => $roomInfoModel->productionPro,
                'telephoneNumber' => $roomInfoModel->telephoneNumber,
                'installationDate' => (string)$roomInfoModel->installationDate
            ];

            return $roomInfo;
        }else{
            return null;
        }
    }

    // 这行代码不该写在这里，违背了单一职责原则
    private function __getDeviceListInfo($serialId){

        // 1. 记录每个设备类型的数量
        // $deviceTypeNameMapArray__ [ deviceTypeName => count, ...]
        $deviceTypeNameArray = \App\ModelCenter\GmDevice_Information_Model::where('roomId', $serialId)->get(['deviceTypeName']);

        $deviceTypeNameMapArray__ = array();
        if(count($deviceTypeNameArray) > 0) {
            foreach ($deviceTypeNameArray as $item) {

                if(array_key_exists($item->deviceTypeName, $deviceTypeNameMapArray__)){
                    ++$deviceTypeNameMapArray__[$item->deviceTypeName];
                }else{
                    $deviceTypeNameMapArray__[$item->deviceTypeName] = 1;
                }
            }
        }else{
            return [];
        }

        // 2.从gmdevice_type表一次性获得所有数据，并缓存起来
        $deviceTypeArray = DB::connection('mysql')->select('SELECT * FROM gmdevice_type');
        $deviceTypeMap__ = array();
        if(count($deviceTypeArray) > 0){
            foreach ($deviceTypeArray as $item) {
                $deviceTypeMap__[$item->name] = $item->typeDesc;
            }
        }

        // 3.更新数组
        $retDeviceListInfo = array();
        foreach ($deviceTypeNameMapArray__ as $key=>$value) {
            $key_deviceTypeName = $key;
            $count = $value;

            if(array_key_exists($key_deviceTypeName, $deviceTypeMap__)){
                $retDeviceListInfo[] = [
                    'deviceTypeName'=>$key_deviceTypeName,
                    'deviceTypeDes'=>$deviceTypeMap__[$key_deviceTypeName],
                    'count'=>$count
                ];
            }else{
                $retDeviceListInfo[] = [
                    'deviceTypeName'=>$key_deviceTypeName,
                    'deviceTypeDes'=>'null',// 不存在
                    'count'=>$count
                ];
            }
        }

        return $retDeviceListInfo;
    }

} // END DistributionRoomController

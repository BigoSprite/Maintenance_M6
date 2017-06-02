<?php

namespace App\Http\Controllers\Center;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utility\DBConnectinHandler;
use App\Http\Controllers\Utility\StringHandler;
use App\Model\VDeviceInfo_Model;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\Input;

class VDeviceInfo_Controller extends Controller
{
    public function __construct()
    {
        $this->__initGmDeviceInfoArray();
//        $this->__initGmDeviceStatusArray();
    }


    /**
     * 功能：判断$gprsID对应的设备是否存在
     * @return：json
     *
     * 响应请求 方法 GET
     * 对应的路由：http://localhost:8888/api/content/verifyGprsID/0000000001
     */
    public function verifyGprsID($gprsId)
    {
        $ret = [
            'isExist'=>'false'
        ];

        $model = VDeviceInfo_Model::where('gprsID', $gprsId)->get(['gprsID']);
        if($model != null){
            $ret['isExist'] = 'true';
        }

        return response(json_encode($ret), JSON_UNESCAPED_UNICODE);
    }

    /*
     * 功能：获取全部设备的信息
     * @return：json
     *
     * 响应请求 方法 GET
     * 对应的路由：http://localhost:8888/api/content/deviceInformation
     */
    public function getDeviceInfoList()
    {
        return response(json_encode(["data"=>$this->__gmDeviceInfoArr], JSON_UNESCAPED_UNICODE));
    }

    /*
   * 功能：获取$gprsId对应的设备信息
   * @return：json
   *
   * 响应请求 方法 GET
   * 对应的路由：http://localhost:8888/api/content/deviceInformation/000000001
   */
    public function getDeviceInfo($gprsId)
    {
        $model = VDeviceInfo_Model::where('gprsID', $gprsId)->first();
        if($model != null){
            $retArray = [
                "gprsID"=> StringHandler::getInstance()->int2str_tenLength($model->gprsID),
                "deviceName"=>$model->deviceName,
                "deviceTypeName"=>$model->deviceTypeName,
                "deviceRemark"=>$model->deviceRemark,
                "realestateinfo_dbName"=>$model->realestateinfo_dbName,
                "protocolVersion"=>$model->protocolVersion,
                "protocolRemark"=>$model->protocolRemark,
                "contactPersonName"=>$model->contactPersonName,
                "mobileNumber"=>$model->mobileNumber,
                "longitude"=>(string)$model->latitude,
                "latitude"=>(string)$model->longitude,
                "deviceDetailInfo"=>$model->deviceDetailInfo,
//                "isParseJSONChanged"=>(string)$model->isParseJSONChanged,
//                "parseJSON"=>$model->parseJSON,
                "isDiscarded"=>(string)$model->isDiscarded,
                "addDate"=> $model->addDate
            ];

            return response(json_encode(["data"=>$retArray], JSON_UNESCAPED_UNICODE));
        }else{
            return response(json_encode(["data"=>[]], JSON_UNESCAPED_UNICODE));
        }
    }


//    /*
//     * 功能：获取设备树数据
//     * @return：json
//     *
//     * 响应请求 方法 GET
//     */
//    public function getDeviceTreeData2Json()
//    {
//        // 拼接数组
//        $ret_arr = array();
//
//        foreach ($this->__gmDeviceInfoArr as $item) {
//
//            $gprsID = $item["gprsID"];
//            $deviceName = $item["deviceName"];
//            $deviceTypeName = $item["deviceTypeName"];
//            $serialId = $item["roomId"];
//
//            $isLogin = 0;
//            if(count( $this->__gmDeviceStatusArr) != 0) {
//                foreach ($this->__gmDeviceStatusArr as $elem) {
//                    if ($elem["gprsID"] == $gprsID){
//                        $isLogin = $elem["isLogin"];
//                        break;
//                    }
//                }
//            }
//
//            $one_device_info_arr =[
//                "gprsID"=> $gprsID,
//                "name"=> $deviceName,
//                "deviceTypeName"=> $deviceTypeName,
//                "isLogin"=> $isLogin
//            ];
//
//
//            $locationName = $this->__getDistributionRoomName($serialId);
//
//            if(count($ret_arr) == 0){
//                $ret_arr[] = ["name"=>$locationName, "device"=>[$one_device_info_arr]];
//            }else{
//                $flag = false;
//                for ($i = 0; $i < count($ret_arr); ++$i)
//                {
//                    if( $locationName == $ret_arr[$i]["name"]){
//                        $ret_arr[$i]["device"][] = $one_device_info_arr;
//                        $flag = true;
//                        break;
//                    }
//                }
//
//                if($flag == false){
//                    $ret_arr[] = ["name"=>$locationName, "device"=>[$one_device_info_arr]];
//                }
//
//            }
//        }
//
//        // JSON_UNESCAPED_UNICODE防止二进制及汉字被编码为Unicode
//        return response(json_encode(["data"=>$ret_arr], JSON_UNESCAPED_UNICODE));
//
//        // TEST
//        //return json_encode(
//        //    ["data"=>
//        //        [
//        //            [
//        //                "name"=>"配电室1",
//        //                "device"=>
//        //                    [
//        //                        ["gprsID"=>"0000000001", "name" => "昂思数显表1", "deviceTypeName"=>"US2000", "isLogin"=>true],
//        //                        ["gprsID"=>"0000000003", "name" => "昂思数显表1", "deviceTypeName"=>"US2000", "isLogin"=>true]
//        //                    ]
//        //            ],
//        //            [
//        //                "name"=>"配电室2",
//        //                "device"=>
//        //                    [
//        //                        ["gprsID"=>"0000000002", "name" => "昂思数显表2", "deviceTypeName"=>"US2000", "isLogin"=>true],
//        //                        ["gprsID"=>"0000000004", "name" => "昂思数显表1", "deviceTypeName"=>"US2000", "isLogin"=>true]
//        //                    ]
//        //            ]
//        //        ]
//        //    ], JSON_UNESCAPED_UNICODE
//        //);
//    }
//
//
//    /*
//     * 功能：获取$realEstateName对应小区的所有设备
//     * @param $realEstateName：物业名字（一般指小区名）
//     * @return：json
//     *
//     * 响应请求 方法 GET
//     * 对应的路由：http://localhost:8888/api/content/deviceList/jinyehotel
//     */
//    public function getDeviceListOfRealEstate($realEstateName)
//    {
//        // 1.判断该物业是否存在于hwdevicecloud.realestateinfo表中
//        $realEstateModel = \App\ModelCenter\RealEstate_Information_Model::where('dbName', $realEstateName)->first();
//        if($realEstateModel != null){
//            $status = 'success';
//        }else{
//            $status = 'fail';
//        }
//
//        // 2.获取该物业下的所有设备，并处理其信息；相关table：hwdevicecloud.gmdevice_info
//        $deviceInfoModelArray = GmDevice_Information_Model::where('dataBaseName', $realEstateName)->get();
//
//        $resultArray = [];
//        if(count($deviceInfoModelArray) > 0){
//            // -----------------------------动态的选择要连接的数据库
//            $con = DBConnectinHandler::getInstance()
//                ->connection('localhost', $realEstateName, 'root', 'root');
//
//
//            foreach ($deviceInfoModelArray as $item) {
//
//                //$roomName = DB::select('SELECT roomName FROM distributionroom WHERE serialId = '."{$item->roomId}");
//                //$roomName = DB::connection('mysql')->select('SELECT roomName FROM distributionroom WHERE serialId = '."{$item->roomId}");
//                $roomName = $con->select('SELECT roomName FROM distributionroom WHERE serialId = '."{$item->roomId}");
//
//                if($roomName != null) {
//                    $deviceInfoArray = [
//                        'gprsID' => StringHandler::getInstance()->int2str_tenLength($item->gprsID),
//                        'deviceName' => $item->deviceName,
//                        'deviceTypeName' => $item->deviceTypeName,
//                        'distributionRoom' => $roomName[0]->roomName
//                    ];
//                }
//
//                $resultArray[] = $deviceInfoArray;
//            }
//        }
//
//        return response(json_encode(['data'=>$resultArray, 'status'=>$status], JSON_UNESCAPED_UNICODE));
//    }
//
    /*
     * 功能：注册设备
     * @return：json
     *
     * 响应请求 方法 POST
     * 对应路由：
     * http://localhost:8888/api/content/deviceRegister
     */
    public function registerDeviceInfo(){

        $gprsId = Input::get('gprsID');
        $model = VDeviceInfo_Model::where('gprsID', $gprsId)->first();

        if($model == null){// 数据库不存在该条数据
            $deviceInfoModel = new VDeviceInfo_Model;
            $deviceInfoModel->gprsID = Input::get('gprsID');
            $deviceInfoModel->deviceName = Input::get('deviceName');
            $deviceInfoModel->deviceTypeName = Input::get('deviceTypeName');
            $deviceInfoModel->deviceRemark = Input::get('deviceRemark');
            $deviceInfoModel->realestateinfo_dbName = Input::get('realestateinfo_dbName');
            $deviceInfoModel->protocolVersion = Input::get('protocolVersion');
            $deviceInfoModel->protocolRemark = Input::get('protocolRemark');
            $deviceInfoModel->contactPersonName = Input::get('contactPersonName');
            $deviceInfoModel->mobileNumber = Input::get('mobileNumber');
            $deviceInfoModel->longitude = Input::get('longitude');
            $deviceInfoModel->latitude = Input::get('latitude');
            $deviceInfoModel->deviceDetailInfo = Input::get('deviceDetailInfo');
            $deviceInfoModel->isDiscarded = Input::get('isDiscarded');
            $deviceInfoModel->addDate = Input::get('addDate');

            if($deviceInfoModel->save()){
                return response()->json(['status'=>'success', 'isExist'=>'false'], 200);
            }else{
                return response()->json(['status'=>'fail', 'isExist'=>'false'], 200);
            }
        }else{
            return response()->json(['status'=>'fail', 'isExist'=>'true'], 200);
        }
    }


    private $__gmDeviceInfoArr;
    //private $__gmDeviceStatusArr;


    //  初始化设备信息数组
    private function __initGmDeviceInfoArray()
    {
        // 获取vdevice_info表中的数据
        $device_info_array = VDeviceInfo_Model::all();

        foreach ($device_info_array as $item) {

            // 构造临时数组
            $tmp_array = [
                "gprsID"=> StringHandler::getInstance()->int2str_tenLength($item->gprsID),
                "deviceName"=>$item->deviceName,
                "deviceTypeName"=>$item->deviceTypeName,
                "deviceRemark"=>$item->deviceRemark,
                "realestateinfo_dbName"=>$item->realestateinfo_dbName,
                "protocolVersion"=>$item->protocolVersion,
                "protocolRemark"=>$item->protocolRemark,
                "contactPersonName"=>$item->contactPersonName,
                "mobileNumber"=>$item->mobileNumber,
                "longitude"=>(string)$item->latitude,
                "latitude"=>(string)$item->longitude,
                "deviceDetailInfo"=>$item->deviceDetailInfo,
//                "isParseJSONChanged"=>(string)$item->isParseJSONChanged,
//                "parseJSON"=>$item->parseJSON,
                "isDiscarded"=>(string)$item->isDiscarded,
                "addDate"=> $item->addDate
            ];

            // 加入最终的数组中
            $this->__gmDeviceInfoArr[] = $tmp_array;
        }
    }
//
//    private function  __initGmDeviceStatusArray()
//    {
//        // 获取数据库表gmdevice_status中的数据
//        $statusModelArray = GmDevice_Status_Model::all();
//
//        foreach ($statusModelArray as $item) {
//            // 获得表中字段的值
//            $gprsID = StringHandler::getInstance()->int2str_tenLength($item->gprsID);
//            $isLogin = $item->isLogin;
//            $lastLoginTime = $item->lastLoginTime;
//            $alarmFlag = $item->alarmFlag;
//            $alarmUpdateTime = $item->alarmUpdateTime;
//            $isOperating = $item->isOperating;
//            $operationDesc = $item->operationDesc;
//            $operationUpdateTime = $item->operationUpdateTime;
//
//            // 构造临时数组
//            $tmp_array = [
//                "alarmFlag"=>$alarmFlag,
//                "alarmUpdateTime"=>$alarmUpdateTime,
//                "gprsID"=>$gprsID,
//                "isLogin"=>$isLogin,
//                "isOperating"=>$isOperating,
//                "lastLoginTime"=>$lastLoginTime,
//                "operationDesc"=>$operationDesc,
//                "operationUpdateTime"=>$operationUpdateTime
//            ];
//
//            // 加入最终的数组中
//            $this->__gmDeviceStatusArr[] = $tmp_array;
//        }
//    }
//
//    private function __getDistributionRoomName($serialId)
//    {
//        $roomName = \App\ModelCenter\Distribution_Room_Model::where('serialId', $serialId)->get(['roomName'])->first();
//        return count($roomName) !=0 ? $roomName->roomName: "";
//    }
}

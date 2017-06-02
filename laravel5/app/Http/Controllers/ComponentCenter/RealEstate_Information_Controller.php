<?php

namespace App\Http\Controllers\ComponentCenter;

use App\Http\Controllers\Controller;
use App\ModelCenter\RealEstate_Information_Model;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Utility\DBConnectinHandler;

class RealEstate_Information_Controller extends Controller
{
    /*
     * 功能：获取特定物业信息
     * @param $dbName：物业(一般是小区)名字
     * @return：json
     *
     * 响应请求 方法 GET
     * 对应路由：http://localhost:8888/api/cloud/realEstateInfo/jinyehotel
     */
    public function getRealEstateInfo($dbName)
    {
        $realEstateModel = RealEstate_Information_Model::where('dbName', $dbName)->first();

        $resultArray = null;
        if($realEstateModel != null){
            $resultArray = [
                'dbName'=>$dbName,
                'realEstateName'=>$realEstateModel->realEstateName,
                'address'=>$realEstateModel->address,
                'description'=>$realEstateModel->description,
                'longitude'=>$realEstateModel->longitude,
                'latitude'=>$realEstateModel->latitude,
                'isDiscarded'=>(string)$realEstateModel->isDiscarded,
//                'dbIp'=>$realEstateModel->dbIp,
//                'dbPort'=>$realEstateModel->dbPort,
//                'dbUserName'=>$realEstateModel->dbUserName,
//                'dbPassword'=>$realEstateModel->dbPassword
            ];
        }

        return response(json_encode(['data'=>$resultArray], JSON_UNESCAPED_UNICODE));
    }


    /*
     * 功能：获取所有的物业信息
     * @return：json
     *
     * 响应请求 方法 GET
     * 对应路由：http://localhost:8888/api/cloud/realEstateInfoList
     */
    public function getRealEstateInfoList()
    {
        $realEstateModelArray = RealEstate_Information_Model::all();
        $resultArray = array();
        if(count($realEstateModelArray) > 0){
            foreach ($realEstateModelArray as $item) {
                $tmpArray = [
                    'dbName'=> $item->dbName,
                    'realEstateName'=>$item->realEstateName,
                    'address'=>$item->address,
                    'description'=>$item->description,
                    'longitude'=>(string)$item->longitude,
                    'latitude'=>(string)$item->latitude,
                    'isDiscarded'=>(string)$item->isDiscarded,
//                'dbIp'=>$item->dbIp,
//                'dbPort'=>$item->dbPort,
//                'dbUserName'=>$item->dbUserName,
//                'dbPassword'=>$item->dbPassword
                ];
                $resultArray[] = $tmpArray;
            }
        }

        return response(json_encode(['data'=>$resultArray], JSON_UNESCAPED_UNICODE));
    }

    /*
     * 功能：获取当前物业下的所有配电室
     * @return：json
     *
     * 响应请求 方法 GET
     * 对应路由：http://localhost:8888/api/content/roomList/jinyehotel
     */
    public function getDistributionRoomList($currentRealEstate)
    {
       $model = RealEstate_Information_Model::where('dbName', $currentRealEstate)->first();
        $retArray = array();
       if($model != null){
           $realEstateTmp = [
               'realEstateName'=>$model->realEstateName,
               'dbName'=>$model->dbName,
               'dbIp'=>$model->dbIp,
               'dbPort'=>$model->dbPort,
               'dbUserName'=>$model->dbUserName,
               'dbPassword'=>$model->dbPassword
           ];

           $con = DBConnectinHandler::getInstance()->connection($realEstateTmp['dbIp'], $realEstateTmp['dbName'], $realEstateTmp['dbUserName'], $realEstateTmp['dbPassword']);
           $roomInfoArray = $con->select('SELECT * FROM distributionroom');

           $tmpArray= array();
           foreach ($roomInfoArray as $item1) {
               $tmp = [
                   'serialId'=>$item1->serialId,
                   'roomName'=>$item1->roomName,
                   'description'=>$item1->description,
                   'address'=>$item1->address,
                   'productionPro'=>$item1->productionPro,
                   'telephoneNumber'=>$item1->telephoneNumber,
                   'installationDate'=>$item1->installationDate
               ];
               $tmpArray[] = $tmp;
           }

           $retArray[] = [
               'roomInfo'=>$tmpArray
           ];
       }
        return response(json_encode(['realEstate'=>$realEstateTmp['realEstateName'], 'roomList'=>$retArray]));
    }


    /*
     * 功能：获取“所有物业信息，及其下面的所有配电室信息”
     * @return：json
     *
     * 响应请求 方法 GET
     * 对应路由：http://localhost:8888/api/cloud/realEstateRoomInfoList
     */
    public function get_RealEstateAndRoom_InfoList()
    {
        $retArray = [];

        $realEstateArray = RealEstate_Information_Model::all();
        $realEstateDbArray = [];
        if(count($realEstateArray) > 0){
            // 获得所有的物业信息
            foreach ($realEstateArray as $item) {
                $realEstateDbArray[] = [
                    'realEstateName'=>$item->realEstateName,// TODO
                    'dbName'=>$item->dbName,
                    'dbIp'=>$item->dbIp,
                    'dbPort'=>$item->dbPort,
                    'dbUserName'=>$item->dbUserName,
                    'dbPassword'=>$item->dbPassword
                ];
            }

            // 根据物业信息找到相应的配电室
            foreach ($realEstateDbArray as $item) {
                $con = DBConnectinHandler::getInstance()->connection($item['dbIp'], $item['dbName'], $item['dbUserName'], $item['dbPassword']);
                $roomInfoArray = $con->select('SELECT * FROM distributionroom');

                $tmpArray= array();
                foreach ($roomInfoArray as $item1) {
                    $tmp = [
                        'serialId'=>$item1->serialId,
                        'roomName'=>$item1->roomName,
                        'description'=>$item1->description,
                        'address'=>$item1->address,
                        'productionPro'=>$item1->productionPro,
                        'telephoneNumber'=>$item1->telephoneNumber,
                        'installationDate'=>$item1->installationDate
                    ];
                    $tmpArray[] = $tmp;
                }

                $retArray[] = [
                    'realEstate'=>$item['realEstateName'],
                    'roomInfo'=>$tmpArray
                ];
            }
        }

        return response(json_encode(['data'=>$retArray], JSON_UNESCAPED_UNICODE));
    }


    /*
     * 功能：插入一条新的信息
     * @return：json
     *
     * 响应请求 方法 POST
     */
    public function insertRealEstateInfo()
    {
        $realEstateName = Input::get('name');
        $realEstateModel = RealEstate_Information_Model::where('name', $realEstateName)->first();
        if($realEstateModel != null) {
            return response()->json(['status'=>'fail'], 501);
        }else{

            $model = new RealEstate_Information_Model;
            $model->name = $realEstateName;
            $model->address = Input::get('address');
            $model->description = Input::get('description');
            $model->longitude = Input::get('longitude');
            $model->latitude = Input::get('latitude');
            $model->dbIp = Input::get('dbIp');
            $model->dbPort = Input::get('dbPort');
            $model->dbUserName = Input::get('dbUserName');
            $model->dbPassword = Input::get('dbPassword');
            $model->isDiscarded = Input::get('isDiscarded');

            if($model->save()){
                return response()->json(['status'=>'success'], 200);
            }else{
                return response()->json(['status'=>'fail'], 502);
            }
        }
    }

    /*
     * 功能：更新物业信息
     * @return：json
     *
     * 响应请求 方法 POST
     */
    public function updateRealEstateInfo()
    {
        $realEstateName = Input::get('name');
        $input = [
            'address'=>Input::get('address'),
            'description'=>Input::get('description'),
            'longitude'=>Input::get('longitude'),
            'latitude'=>Input::get('latitude'),
            'dbIp'=>Input::get('dbIp'),
            'dbPort'=>Input::get('dbPort'),
            'dbUserName'=>Input::get('dbUserName'),
            'dbPassword'=>Input::get('dbPassword'),
            'isDiscarded'=>Input::get('isDiscarded')
        ];

        $realEstateModel = RealEstate_Information_Model::where('name', $realEstateName)->first();
        if($realEstateModel != null) {
            if($realEstateModel->update($input)){
                return response()->json(['status'=>'success'], 200);
            }else{
                return response()->json(['status'=>'fail'], 501);
            }
        }else{
            return response()->json(['status'=>'fail'], 502);
        }
    }

}// END RealEstate_Information_Controller

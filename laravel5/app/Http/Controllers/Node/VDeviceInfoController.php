<?php

namespace App\Http\Controllers\Node;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\NodeRepository\VDeviceInfoRepository as VDeviceMgr;
use Illuminate\Support\Facades\Input;

class VDeviceInfoController extends Controller
{
    /**
     * 仓库管理员
     *
     * @var VDeviceMgr
     */
    private $vDeviceMgr;

    /**
     * assign value to $user by IoC(依赖注入)
     *
     * UserInfoController constructor.
     * @param VDeviceMgr $vDeviceMgr
     */
    public function __construct(VDeviceMgr $vDeviceMgr)
    {
        $this->vDeviceMgr = $vDeviceMgr;
    }

    /**
     * 功能：判断$gprsID对应的设备是否存在
     * @param $gprsId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/verifyGprsID/0000000001
     */
    public function verifyGprsID($gprsId)
    {
        $ret = [
            'isExist'=>'false'
        ];

        $isExist = $this->vDeviceMgr->isFieldExist('gprsID', $gprsId);

        if($isExist){
            $ret['isExist'] = 'true';
        }

        return response(json_encode($ret), JSON_UNESCAPED_UNICODE);
    }


    /**
     * 功能：获取全部设备的信息
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/deviceInformation
     */
    public function getDeviceInfoList()
    {
        $deviceModelList = $this->vDeviceMgr->all();

        $retArray = array();

        if(count($deviceModelList) > 0){
            foreach ($deviceModelList as $model) {
                // 构造临时数组
                $tmp_array = [
                    "gprsID"=> $model->gprsID,
                    "deviceName"=> $model->deviceName,
                    "deviceTypeName"=> $model->deviceTypeName,
                    "deviceRemark"=> $model->deviceRemark,
                    "monitoredUnitName"=> $model->monitoredUnitName,
                    "realestateinfo_dbName"=> $model->realestateinfo_dbName,
                    "protocolVersion"=> $model->protocolVersion,
                    "protocolRemark"=> $model->protocolRemark,
                    "contactPersonName"=> $model->contactPersonName,
                    "contactTel"=> $model->contactTel,
                    "deviceDetailInfo"=> $model->deviceDetailInfo,
//                "parseJSON"=> $model->parseJSON,
                    "isDiscarded"=> $model->isDiscarded,
                    "addDate"=> $model->addDate,
                ];

                // 加入最终的数组中
                $retArray[] = $tmp_array;
                
            }
            
        }

        return response(json_encode(["data"=>$retArray], JSON_UNESCAPED_UNICODE));
    }

    /**
     * 功能：获取$gprsId对应的设备信息
     * @param $gprsId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/deviceInformation/0000000001
     */
    public function getDeviceInfo($gprsId)
    {
        $map = $this->vDeviceMgr->findBy('gprsID', $gprsId);

        if($map != null){
            $retArray = [
                "gprsID"=> $map['gprsID'],
                "deviceName"=>$map['deviceName'],
                "deviceTypeName"=>$map['deviceTypeName'],
                "deviceRemark"=>$map['deviceRemark'],
                "monitoredUnitName"=>$map['monitoredUnitName'],
                "realestateinfo_dbName"=>$map['realestateinfo_dbName'],
                "protocolVersion"=>$map['protocolVersion'],
                "protocolRemark"=>$map['protocolRemark'],
                "contactPersonName"=>$map['contactPersonName'],
                "contactTel"=>$map['contactTel'],
                "deviceDetailInfo"=>$map['deviceDetailInfo'],
//                "parseJSON"=>$map['parseJSON'],
                "isDiscarded"=>$map['isDiscarded'],
                "addDate"=> $map['addDate'],
            ];

            return response(json_encode(["data"=>$retArray], JSON_UNESCAPED_UNICODE));
        }else{
            return response(json_encode(["data"=>[]], JSON_UNESCAPED_UNICODE));
        }
    }


    /**
     * 功能：注册设备
     * @return \Illuminate\Http\JsonResponse
     *
     * 响应请求 方法 POST
     * http://localhost:8888/api/content/register/device
     */
    public function registerDeviceInfo()
    {
        $gprsID = Input::get('gprsID');

        $data = [
            "gprsID"=> $gprsID,
            "deviceName"=> Input::get('deviceName'),
            "deviceTypeName"=> Input::get('deviceTypeName'),
            "deviceRemark"=> Input::get('deviceRemark'),
            "monitoredUnitName"=> Input::get('monitoredUnitName'),
            "realestateinfo_dbName"=>Input::get('realestateinfo_dbName'),
            "protocolVersion"=>Input::get('protocolVersion'),
            "protocolRemark"=>Input::get('protocolRemark'),
            "contactPersonName"=>Input::get('contactPersonName'),
            "contactTel"=>Input::get('contactTel'),
            "deviceDetailInfo"=>Input::get('deviceDetailInfo'),
//                "parseJSON"=>Input::get('parseJSON'),
            "isDiscarded"=>Input::get('isDiscarded'),
            "addDate"=> Input::get('addDate'),
        ];

        return $this->vDeviceMgr->create($data, 'gprsID', $gprsID);
    }

    /**
     * 功能：更新设备
     * @return \Illuminate\Http\JsonResponse
     *
     * 响应请求 方法 POST
     * http://localhost:8888/api/content/update/device
     */
    public function updateDeviceInfo()
    {
        $gprsID = Input::get('gprsID');

        $data = [
            "gprsID"=> $gprsID,
            "deviceName"=> Input::get('deviceName'),
            "deviceTypeName"=> Input::get('deviceTypeName'),
            "deviceRemark"=> Input::get('deviceRemark'),
            "monitoredUnitName"=> Input::get('monitoredUnitName'),
            "realestateinfo_dbName"=>Input::get('realestateinfo_dbName'),
            "protocolVersion"=>Input::get('protocolVersion'),
            "protocolRemark"=>Input::get('protocolRemark'),
            "contactPersonName"=>Input::get('contactPersonName'),
            "contactTel"=>Input::get('contactTel'),
            "deviceDetailInfo"=>Input::get('deviceDetailInfo'),
//                "parseJSON"=>Input::get('parseJSON'),
            "isDiscarded"=>Input::get('isDiscarded'),
            "addDate"=> Input::get('addDate'),
        ];

        return $this->vDeviceMgr->update($data, 'gprsID', $gprsID);
    }

}

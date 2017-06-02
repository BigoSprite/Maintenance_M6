<?php

namespace App\Http\Controllers\Node;

use App\Http\Controllers\Controller;
use App\Repositories\NodeRepository\VDeviceStatusRepository as VDeviceStatusMgr;
use Illuminate\Support\Facades\Input;

class VDeviceStatusController extends Controller
{

    /**
     * 仓库管理员
     *
     * @var VDeviceStatusMgr
     */
    private $vDeviceStatusMgr;

    public function __construct(VDeviceStatusMgr $vDeviceStatusMgr)
    {
        $this->vDeviceStatusMgr = $vDeviceStatusMgr;
    }

    /**
     * 功能：验证gprsId是否存在
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/verify/deviceStatus/000000001
     */
    public function isGprsIdExist($gprsId)
    {
        $ret = [
            'isExist'=>'false'
        ];

        $isExist = $this->vDeviceStatusMgr->isFieldExist('gprsID', $gprsId);

        if($isExist){
            $ret['isExist'] = 'true';
        }

        return response(json_encode($ret), JSON_UNESCAPED_UNICODE);
    }

    /**
     * 功能：获取特定grsID的设备的状态
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/deviceStatus/000000001
     */
    public function getDeviceStatus($gprsID)
    {
        $map = $this->vDeviceStatusMgr->findBy('gprsID', $gprsID);

        if($map != null){
            $retArray = [
                'gprsID' => $map['gprsID'],
                'isLogin' => $map['isLogin'],
                'lastLoginTime' => $map['lastLoginTime'],
                'alarmFlag' => $map['alarmFlag'],
                'alarmUpdateTime' => $map['alarmUpdateTime'],
                'isOperating' => (string)$map['isOperating'],
                'operationDesc' => $map['operationDesc'],
                'operationUpdateTime' => (string)$map['operationUpdateTime'],
            ];

            return response(json_encode(["data"=>$retArray], JSON_UNESCAPED_UNICODE));
        }else{
            return response(json_encode(["data"=>[]], JSON_UNESCAPED_UNICODE));
        }
    }

    /**
     * 功能：获取全部设备的状态
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/deviceStatusList
     */
    public function getDeviceStatusList()
    {
        $statusModelArray = $this->vDeviceStatusMgr->all();

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
        return response(json_encode(['data'=>$resultArray], JSON_UNESCAPED_UNICODE));
    }



    /**
     * 功能：注册设备状态
     * @return \Illuminate\Http\JsonResponse
     *
     * 响应请求 方法 POST
     * http://localhost:8888/api/content/register/deviceStatus
     */
    public function registerDeviceStatus()
    {
        $gprsid =  Input::get('gprsID');

        $data = [
            'gprsID' => $gprsid,
            'isLogin' => Input::get('isLogin'),
            'lastLoginTime' => Input::get('lastLoginTime'),
            'alarmFlag' => Input::get('alarmFlag'),
            'alarmUpdateTime' => Input::get('alarmUpdateTime'),
            'isOperating' => Input::get('isOperating'),
            'operationDesc' => Input::get('operationDesc'),
            'operationUpdateTime' => Input::get('operationUpdateTime')
        ];

        return $this->vDeviceStatusMgr->create($data, 'gprsID', $gprsid);
    }

    /**
     * 功能：更新设备状态
     * @return \Illuminate\Http\JsonResponse
     *
     * 响应请求 方法 POST
     * http://localhost:8888/api/content/update/deviceStatus
     */
    public function updateDeviceStatus()
    {
        $gprsid =  Input::get('gprsID');

        $data = [
            'gprsID' => $gprsid,
            'isLogin' => Input::get('isLogin'),
            'lastLoginTime' => Input::get('lastLoginTime'),
            'alarmFlag' => Input::get('alarmFlag'),
            'alarmUpdateTime' => Input::get('alarmUpdateTime'),
            'isOperating' => Input::get('isOperating'),
            'operationDesc' => Input::get('operationDesc'),
            'operationUpdateTime' => Input::get('operationUpdateTime')
        ];

        return $this->vDeviceStatusMgr->update($data, 'gprsID', $gprsid);
    }


}

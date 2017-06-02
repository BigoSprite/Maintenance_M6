<?php

namespace App\Http\Controllers\Node;

use App\Http\Controllers\Handlers\VDeviceInfoHandler;
use App\Http\Controllers\Handlers\VerifyHandler;
use App\Http\Controllers\Controller;
use App\Repositories\NodeRepository\VDeviceRealTimeDataRepository as VDeviceRealTimeDataMgr;

class VDeviceRealTimeDataController extends Controller
{
    /**
     * 仓库管理员
     *
     * @var VDeviceRealTimeDataMgr
     */
    private $vDeviceRealTimeDataMgr;

    public function __construct(VDeviceRealTimeDataMgr $vDeviceRealTimeDataMgr)
    {
        $this->vDeviceRealTimeDataMgr = $vDeviceRealTimeDataMgr;
    }

    /**
     * 功能：验证设备是否存在
     * @param $gprsId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/verify/deviceRealTime/0000000001
     */
    public function isDeviceExist($gprsId)
    {
        $ret = [
            'isExist'=>'false'
        ];

        $isExist = $this->vDeviceRealTimeDataMgr->isFieldExist('gprsID', $gprsId);

        if($isExist){
            $ret['isExist'] = 'true';
        }

        return response(json_encode($ret), JSON_UNESCAPED_UNICODE);
    }


    /**
     * 功能：获取$gprsId对应的实时数据——表头
     * @param $gprsid
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/deviceRealTimeDataTable_headerData/0000000001
     */
    public function getTableHeader($gprsid)
    {
        // parseJSON Array
        $objArray = VDeviceInfoHandler::create()->getParseJSON($gprsid);

        // 加入缓存；使用观察者定制消息驱动，数据库改变之后通知这里 TODO...

        $dataArray = array();
        if($objArray != null){
            foreach ($objArray as $obj) {
                $dataArray[] = [
                    "id"=>strtolower((string)$obj->alias),
                    "name"=>(string)$obj->name_ch
                ];
            }
        }

        // JSON_UNESCAPED_UNICODE防止二进制及汉字被编码为Unicode
        return response(json_encode(["data"=>$dataArray], JSON_UNESCAPED_UNICODE));
    }


    /**
     * 功能：获取$gprsId对应的实时数据
     * @param $gprsid
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/deviceRealTimeDataTable_bodyData/0000000001
     */
    public function getRealTimeData($gprsid)
    {
        if(VerifyHandler::getInstance()->isLegal($gprsid) == false){
            return response(json_encode( ["lastUpdateTime" => null, "data" => []], JSON_UNESCAPED_UNICODE));
        }

        // parseJSON Array
        $objArray = VDeviceInfoHandler::create()->getParseJSON($gprsid);

        $realTimeDataModel = $this->vDeviceRealTimeDataMgr->findBy('gprsID', $gprsid);
        if($realTimeDataModel != null){
            $resultArray = ["lastUpdateTime" => (string)$realTimeDataModel->lastUpdateTime, "data" => []];

            if($objArray != null) {
                foreach ($objArray as $obj) {
                    $varN = strtolower($obj->alias);
                    $name_en = (string)$obj->name_en;
                    $name_ch = (string)$obj->name_ch;
                    $data_type = $obj->data_type;
                    $byte_seq = strtolower($obj->byte_seq);
                    $scale = (float)$obj->scale;
                    $unit = $obj->unit;

                    $hexString = bin2hex($realTimeDataModel->$varN);

                    if ($byte_seq == 'be') {// 大端
                        $hexString = strrev($hexString);
                    }

                    // 把数据放到数组
                    $val = (string)(hexdec($hexString) * $scale) . $unit;
                    $resultArray["data"][] = ["name" => $name_ch, "value" => $val];
                }
            }
            // JSON_UNESCAPED_UNICODE防止二进制及汉字被编码为Unicode
            return response(json_encode($resultArray, JSON_UNESCAPED_UNICODE));
        }else{

            $resultArray = ["lastUpdateTime" => null, "data" => []];
            foreach ($objArray as $obj) {
                $zhName = (string)$obj->name_ch;
                $resultArray["data"][] = ["name" => $zhName, "value" => null];
            }

            return response(json_encode($resultArray, JSON_UNESCAPED_UNICODE));
            //exit("The device info with gprsId =  {$gprsid} doesn't exist in the table of gmdevice_realtimedata!");
        }
    }



}















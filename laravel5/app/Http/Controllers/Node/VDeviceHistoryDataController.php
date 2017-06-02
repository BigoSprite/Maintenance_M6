<?php

namespace App\Http\Controllers\Node;

use App\Http\Controllers\Handlers\VDeviceInfoHandler;
use App\Http\Controllers\Handlers\VerifyHandler;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class VDeviceHistoryDataController extends Controller
{
    /**
     * 功能：获取“历史数据”表头
     * @param $gprsid
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/deviceHistoryDataTable_headerData/0000000001
     */
    public function getTableHeader($gprsid)
    {
        // parseJSON Array
        $objArray = VDeviceInfoHandler::create()->getParseJSON($gprsid);

        $dataArray = array();
        if ($objArray != null) {
            foreach ($objArray as $obj) {
                $dataArray[] = [
                    "id" => strtolower((string)$obj->alias),
                    "name" => (string)$obj->name_ch
                ];
            }
        }

        // JSON_UNESCAPED_UNICODE防止二进制及汉字被编码为Unicode
        return response(json_encode(["data" => $dataArray], JSON_UNESCAPED_UNICODE));
    }


    /**
     * 功能：从历史数据表中获得gprsid对应的设备历史数据
     * @param $gprsid
     * @return：json
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/deviceHistoryDataTable_bodyData/0000000001
     */
    public function getHistoryData($gprsid)
    {
        if (VerifyHandler::getInstance()->isLegal($gprsid) == false) {
            return response(json_encode(["lastUpdateTime" => null, "data" => []], JSON_UNESCAPED_UNICODE));
        }

        // parseJSON Array
        $objArray = VDeviceInfoHandler::create()->getParseJSON($gprsid);

        // TODO...
        $historyDataModelArray = DB::connection('mysql_cloud_node')->select('SELECT * FROM vdevice_' . "{$gprsid} " . 'limit 100');

        $resultDataArr = array();
        foreach ($historyDataModelArray as $oneLineInTable) {

            $tmpArray = array();
            $tmpArray["saveTime"] = $oneLineInTable->saveTime;

            if($objArray != null) {
                foreach ($objArray as $obj) {
                    $varN = strtolower($obj->alias);
                    $name_en = (string)$obj->name_en;
                    $name_ch = (string)$obj->name_ch;
                    $data_type = $obj->data_type;
                    $byte_seq = strtolower($obj->byte_seq);
                    $scale = (float)$obj->scale;
                    $unit = $obj->unit;

                    $hexString = bin2hex($oneLineInTable->$varN);
                    if ($byte_seq == 'be') {// 大端
                        $hexString = strrev($hexString);
                    }
                    // 把数据放到数组
                    $val = (string)(hexdec($hexString) * $scale) . $unit;
                    $tmpArray[$varN] = $val;
                }
            }

            $resultDataArr[] = $tmpArray;
        }

        // JSON_UNESCAPED_UNICODE防止二进制及汉字被编码为Unicode
        return response(json_encode(["data"=>$resultDataArr], JSON_UNESCAPED_UNICODE));
    }
}

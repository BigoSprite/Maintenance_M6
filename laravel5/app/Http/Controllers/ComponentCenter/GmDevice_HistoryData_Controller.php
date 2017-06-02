<?php

namespace App\Http\Controllers\ComponentCenter;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Utility\VerifyHandler;

class GmDevice_HistoryData_Controller extends BaseGmDeviceDataController
{
    public function __construct()
    {
        parent::__construct();
    }

    /*
     * 功能：从xml文件中获取“历史数据”表头，并响应前端请求
     * @param $deviceType：设备类型
     * @return：json
     *
     * 响应请求 方法 GET
     */
    public function getHistoryDataTableHeader2Json($deviceType)
    {

        $this->loadXmlElementWithDeviceType('deviceInfoMappingFile.xml', $deviceType);

        if( count($this->xmlElemArray)!=0 )
        {
            $dataArray = array();
            foreach ($this->xmlElemArray as $item) {
                $dataArray[] = ["id"=>strtolower((string)$item["store_field"]), "name"=>(string)$item["zh_name"]];
            }

            // JSON_UNESCAPED_UNICODE防止二进制及汉字被编码为Unicode
            return response(json_encode(["data"=>$dataArray], JSON_UNESCAPED_UNICODE));
        }else{
            return response()->json(['status'=>'fail'], 200);
        }
    }

    /*
     * 功能：从历史数据表中获得gprsid对应的设备历史数据
     * @param $deviceType：设备类型
     * @param $gprsid：gprsid
     * @return：json
     *
     * 响应请求 方法 GET
     */
    public function getHistoryData2Json($deviceType, $gprsid)
    {
        if(VerifyHandler::getInstance()->isLegal($gprsid) == false){
            return response(json_encode(["data"=>[]], JSON_UNESCAPED_UNICODE));
        }

        $this->loadXmlElementWithDeviceType('deviceInfoMappingFile.xml', $deviceType);

        $deviceDataArr = DB::connection('mysql_cloud')->select('SELECT * FROM gmdevice_'."{$gprsid}");

        $resultDataArr = array();

        foreach ($deviceDataArr as $oneLineInTable) {

            $tmpArray = array();
            $tmpArray["uploadTime"] = $oneLineInTable->uploadTime;

            foreach ($this->xmlElemArray as $elem) {
                $varN = strtolower($elem["store_field"]);
                $map_name = (string)$elem["map_name"];
                $zhName = (string)$elem["zh_name"];
                $data_type = $elem["data_type"];
                $byte_seq = strtolower($elem["byte_seq"]);
                $scale = (float)$elem["scale"];
                $unit = $elem["unit"];

                $hexString = bin2hex($oneLineInTable->$varN);

                if ($byte_seq == 'be') {// 大端
                    $hexString = strrev($hexString);
                }

                // 把数据放到数组
                $val = (string)(hexdec($hexString) * $scale) . $unit;
                $tmpArray[$varN] = $val;
            }

            $resultDataArr[] = $tmpArray;
        }

        // JSON_UNESCAPED_UNICODE防止二进制及汉字被编码为Unicode
        return response(json_encode(["data"=>$resultDataArr], JSON_UNESCAPED_UNICODE));

    }
}

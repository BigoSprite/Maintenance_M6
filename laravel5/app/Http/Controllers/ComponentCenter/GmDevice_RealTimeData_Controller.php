<?php

namespace App\Http\Controllers\ComponentCenter;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utility\VerifyHandler;
use App\ModelCenter\GmDevice_RealTimeData_Model;


class GmDevice_RealTimeData_Controller extends Controller
{
    /*
     * 功能：从xml文件中获取“实时数据”表头
     * @param $deviceType：设备类型
     * @return：json
     *
     * 响应请求 方法 GET
     */
    public function getTableHeader2Json($deviceType)
    {
        $this->__loadXmlElementWithDeviceType('deviceInfoMappingFile.xml', $deviceType);

        if( count($this->__xmlElemArray)!=0 )
        {
            $dataArray = array();
            foreach ($this->__xmlElemArray as $item) {

                $varN = strtolower((string)$item["store_field"]);// 转换为小写
                $dataArray[] = ["id"=>$varN, "name"=>(string)$item["zh_name"]];
            }

            // JSON_UNESCAPED_UNICODE防止二进制及汉字被编码为Unicode
            return response(json_encode(["data"=>$dataArray], JSON_UNESCAPED_UNICODE));
        }else{
            exit('Error, '."load xml file filed!");
        }
    }

    /*
     * 功能：获取gprsID对应设备的实时数据
     * @param $deviceType：设备类型
     * @param $gprsid：设备的gprsID
     * @return：json
     *
     * 响应请求 方法 GET
     */
    public function getRealTimeData2Json($deviceType, $gprsid)
    {

       if(VerifyHandler::getInstance()->isLegal($gprsid) == false){
           return response(json_encode( ["lastUpdateTime" => null, "data" => []], JSON_UNESCAPED_UNICODE));
       }

        $this->__loadXmlElementWithDeviceType('deviceInfoMappingFile.xml', $deviceType);

        //$oneLineDataArray = DB::select("SELECT * FROM gmdevice_realtimedata WHERE gprsID = {$gprsid}");
        $realTimeDataModel = GmDevice_RealTimeData_Model::where('gprsID', $gprsid)->first();

        if($realTimeDataModel != null) {

            $resultArray = ["lastUpdateTime" => (string)$realTimeDataModel->lastUpdateTime, "data" => []];

            foreach ($this->__xmlElemArray as $elem) {
                $varN = strtolower($elem["store_field"]);
                $map_name = (string)$elem["map_name"];
                $zhName = (string)$elem["zh_name"];
                $data_type = $elem["data_type"];
                $byte_seq = strtolower($elem["byte_seq"]);
                $scale = (float)$elem["scale"];
                $unit = $elem["unit"];

                $hexString = bin2hex($realTimeDataModel->$varN);

                if ($byte_seq == 'be') {// 大端
                    $hexString = strrev($hexString);
                }

                // 把数据放到数组
                $name = $zhName;
                $val = (string)(hexdec($hexString) * $scale) . $unit;
                $resultArray["data"][] = ["name" => $name, "value" => $val];
            }

            // JSON_UNESCAPED_UNICODE防止二进制及汉字被编码为Unicode
            return response(json_encode($resultArray, JSON_UNESCAPED_UNICODE));
        }else{

            $resultArray = ["lastUpdateTime" => null, "data" => []];
            foreach ($this->__xmlElemArray as $elem) {
                $zhName = (string)$elem["zh_name"];
                $resultArray["data"][] = ["name" => $zhName, "value" => null];
            }
            return response(json_encode($resultArray, JSON_UNESCAPED_UNICODE));
            //exit("The device info with gprsId =  {$gprsid} doesn't exist in the table of gmdevice_realtimedata!");
        }

    }

    private $__xmlElemArray;

    /*
    * 功能：从public文件夹下加载mappingFile.xml配置文件
    *
    * $__xmlElemArray
    * [ ["store_field"=>"", "map_name"=>"", "zh_name"=>"" "data_type"=>"", "byte_seq"=>"", "scale"=>"", "unit"=>""], [~], ...]
    */
    private function __loadXmlFile($filePath)
    {
        if(file_exists($filePath)){
            $xml = simplexml_load_file($filePath);

            $itemArr = $xml->device_query_and_return->children();

            foreach ($itemArr as $item){
                $arr = $item->attributes();
                //$tmpArr = [$arr["store_field"], $arr["map_name"], $arr["zh_name"], $arr["data_type"], $arr["byte_seq"], $arr["scale"], $arr["unit"]];
                $this->__xmlElemArray[] =
                    [
                        "store_field"=>$arr["store_field"],
                        "map_name"=>$arr["map_name"],
                        "zh_name"=>$arr["zh_name"],
                        "data_type"=>$arr["data_type"],
                        "byte_seq"=>$arr["byte_seq"],
                        "scale"=>$arr["scale"],
                        "unit"=>$arr["unit"]
                    ];
            }
        }else{
            exit('Error, '."{$filePath} doesn't exist!");
        }
    }

    /*
   * 功能：从public文件夹下加载mappingFile.xml配置文件，并根据$deviceType获得特定的对象
   *
   * $__xmlElemArray
   * [ ["store_field"=>"", "map_name"=>"", "zh_name"=>"" "data_type"=>"", "byte_seq"=>"", "scale"=>"", "unit"=>""], [~], ...]
   */
    private function __loadXmlElementWithDeviceType($filePath, $deviceType)
    {
        if(file_exists($filePath)){
            $xml = simplexml_load_file($filePath);

            if($xml->device_info_array != null ) {
                $target = null;
                foreach ($xml->device_info_array->device_query_and_return as $item) {
                    if ($item->attributes()['device_type_name'] == $deviceType) {
                        $target = $item;
                        break;
                    }
                }

                if($target != null) {
                    // $target为对应于$deviceType的对象
                    $targetItemArray = $target->children();
                    foreach ($targetItemArray as $item) {
                        $arr = $item->attributes();
                        //$tmpArr = [$arr["store_field"], $arr["map_name"], $arr["zh_name"], $arr["data_type"], $arr["byte_seq"], $arr["scale"], $arr["unit"]];
                        $this->__xmlElemArray[] =
                            [
                                "store_field" => $arr["store_field"],
                                "map_name" => $arr["map_name"],
                                "zh_name" => $arr["zh_name"],
                                "data_type" => $arr["data_type"],
                                "byte_seq" => $arr["byte_seq"],
                                "scale" => $arr["scale"],
                                "unit" => $arr["unit"]
                            ];
                    }
                }else{
                    exit("The device with deviceType = {$deviceType} doesn't exist!");
                }
            }
        }else{
            exit('Error, '."{$filePath} doesn't exist!");
        }
    }
}

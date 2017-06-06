<?php

namespace App\Api\Node;

use App\Api\Utils\DBDirector;
use Illuminate\Container\Container as App;

class VDeviceHistoryDataApi
{
    public static function create()
    {
        $instance = new VDeviceHistoryDataApi();
        if($instance != null){
            return $instance;
        }
        return null;
    }

    /**
     * 功能：获取$gprsId对应的历史数据——表头
     * @param $gprsId
     * @return array
     */
    public function getTableHeader($gprsId)
    {
        // parseJSON Array
        $objArray = (VDeviceInfoApi::create()->getParseJSON($gprsId))['data'];

        // 加入缓存；使用观察者定制消息驱动，数据库改变之后通知这里 TODO...

        $dataArray = array();
        if( count($objArray) > 0){
            foreach ($objArray as $obj) {
                $dataArray[] = [
                    "id"=>strtolower((string)$obj->alias),
                    "name"=>(string)$obj->name_ch
                ];
            }
        }

        return ["data"=>$dataArray];
    }

    /**
     * 功能：从历史数据表中获得gprsId对应的设备历史数据
     * @param $gprsId
     * @return array
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/deviceHistoryDataTable_bodyData/0000000001
     */
    public function getHistoryData($gprsId)
    {
        // 1. 获取表头数组 parseJSON Array
        if(true){// TODO
            $objArray = (VDeviceInfoApi::create()->getParseJSON($gprsId))['data'];
        }else{// 从缓存中获得
            $objArray = null;
        }

        // 2. 连接数据库进行查询
        $con = DBDirector::getInstance()->connection(
            '127.0.0.1',
            'hwdevicecloudnode',
            'root',
            'root'
        );
        $table = "vdevice_".$gprsId;
        $rows = count($con->select("SELECT * from {$table}"));
        if( $rows <= 100){
            $historyDataModelArray = $con->select("SELECT * FROM {$table} LIMIT 100");
        }else{
            $startIndex = $rows - 100;
            $historyDataModelArray = $con->select("SELECT * FROM {$table} LIMIT $startIndex,-1");// TODO...
        }
//        $historyDataModelArray = DB::connection('mysql_cloud_node')->select('SELECT * FROM vdevice_' . "{$gprsId} " . 'limit 100');

        // 3. 访问数据并范返回
        $resultDataArr = array();
        if(count($historyDataModelArray) > 0) {
            foreach ($historyDataModelArray as $oneLineInTable) {

                $tmpArray = array();
                $tmpArray["saveTime"] = $oneLineInTable->saveTime;

                if ($objArray != null) {
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
        }

        $con->disconnect();

        return ["data"=>$resultDataArr];
    }

}
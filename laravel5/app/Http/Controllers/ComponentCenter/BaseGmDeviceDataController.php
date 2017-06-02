<?php
/**
 * Created by PhpStorm.
 * User: fm
 * Date: 2017/4/28
 * Time: 17:08
 */

namespace App\Http\Controllers\ComponentCenter;

use App\Http\Controllers\Controller;

class BaseGmDeviceDataController extends Controller
{

    public function __construct()
    {
        //$this->loadXmlFile('mappingFile.xml');
    }

    public $xmlElemArray;

    /*
     * 功能：从public文件夹下加载mappingFile.xml配置文件
     *
     * $__xmlElemArray
     * [ ["store_field"=>"", "map_name"=>"", "zh_name"=>"" "data_type"=>"", "byte_seq"=>"", "scale"=>"", "unit"=>""], [~], ...]
     */
    public function loadXmlFile($filePath)
    {
        if(file_exists($filePath)){
            $xml = simplexml_load_file($filePath);

            $itemArr = $xml->device_query_and_return->children();
            foreach ($itemArr as $item){
                $arr = $item->attributes();
                //$tmpArr = [$arr["store_field"], $arr["map_name"], $arr["zh_name"], $arr["data_type"], $arr["byte_seq"], $arr["scale"], $arr["unit"]];
                $this->xmlElemArray[] =
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
    public function loadXmlElementWithDeviceType($filePath, $deviceType)
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
                        $this->xmlElemArray[] =
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
<?php

/**
 * This file is created by hanzhiwei using _example_template_XXXApi.php
 *
 * @Copyright
 *      @user: hanzhiwei
 *      @Email: bigosprite@163.com
 *      @GitHub: https://github.com/BigoSprite
 */

namespace App\Http\Controllers\Api\Node;
use App\Http\Controllers\Api\Contracts\Api;
use App\Repositories\Eloquent\AbstractRepository;
use App\Http\Controllers\Api\Utils\ApiInstanceFactory;

/** MAKE SURE that yourApi class extents Api in order to use the (REPOSITORY MANAGER) */
class VDeviceRealTimeDataApi extends Api
{
    /**
     * Constructor.
     *
     * @param AbstractRepository $repository
     * @NOTE you HAVE TO implement constructor and call parent constructor like follow.
     */
    public function __construct(AbstractRepository $repository)
    {
        /** Don't forget to call parent constructor. */
        parent::__construct($repository);
    }

    /**
     * Create Function
     *
     * @return object
     */
    public static function create()
    {
        /** CREATE_FUNC like Cocos2d-x's CREATE_FUNC */
        /** Don't forget to CHANGE the parameters of CREATE_FUNC! */
        /** @NOTE 魔术常量__NAMESPACE__表示的当前命名空间 */
        return ApiInstanceFactory::CREATE_FUNC(
            'VDeviceRealTimeDataApi',
            __NAMESPACE__,
            'VDeviceRealTimeDataRepository',
            'App\Repositories\NodeRepository'
        );
    }

    /**
     * 功能：判断XXX对应的数据对象是否存在
     * @param $gprsId
     * @return array
     *
     * @NOTE Don't forget to CHANGE XXX to the right attribute.
     */
    public function isGprsIdExist($gprsId)
    {
        $ret = [
            'isExist'=>'false'
        ];

        $isExist = $this->repositoryMgr->isFieldExist('gprsID', $gprsId);

        if($isExist){
            $ret['isExist'] = 'true';
        }

        return $ret;
    }


    /**
     * 功能：获取$gprsId对应的实时数据——表头
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
     * 功能：获取$gprsId对应的实时数据
     * @param $gprsId
     * @return array
     */
    public function getRealTimeData($gprsId)
    {
        // parseJSON Array
        $objArray = (VDeviceInfoApi::create()->getParseJSON($gprsId))['data'];

        $arrMap = $this->repositoryMgr->findBy('gprsID', $gprsId);
        if($arrMap != null){
            $resultArray = ["lastUpdateTime" => (string)$arrMap['lastUpdateTime'], "data" => []];

            if($objArray != null) {
                foreach ($objArray as $obj) {
                    $varN = strtolower($obj->alias);
                    $name_en = (string)$obj->name_en;
                    $name_ch = (string)$obj->name_ch;
                    $data_type = $obj->data_type;
                    $byte_seq = strtolower($obj->byte_seq);
                    $scale = (float)$obj->scale;
                    $unit = $obj->unit;

                    $hexString = bin2hex($arrMap[$varN]);

                    if ($byte_seq == 'be') {// 大端
                        $hexString = strrev($hexString);
                    }

                    // 把数据放到数组
                    $val = (string)(hexdec($hexString) * $scale) . $unit;
                    $resultArray["data"][] = ["name" => $name_ch, "value" => $val];
                }
            }

        }else{
            $resultArray = ["lastUpdateTime" => null, "data" => []];
            foreach ($objArray as $obj) {
                $zhName = (string)$obj->name_ch;
                $resultArray["data"][] = ["name" => $zhName, "value" => null];
            }
            //exit("The device info with gprsId =  {$gprsid} doesn't exist in the table of gmdevice_realtimedata!");
        }

        return $resultArray;
    }



    /**
     * 功能：注册
     * @param $data
     * @param $primaryKey
     * @param $value
     * @return array
     */
    public function register($data, $primaryKey, $value)
    {
        return $this->repositoryMgr->create_Ex($data, $primaryKey, $value);
    }

    /**
     * 功能：更新
     * @param $data
     * @param $primaryKey
     * @param $value
     * @return mixed
     */
    public function update($data, $primaryKey, $value)
    {
        return $this->repositoryMgr->update_Ex($data, $primaryKey, $value);
    }

    /**
     * Other Method
     *
     * @NOTE you can add you own method like this.
     *
     */
    public function otherMethod()
    {
        //
    }
}
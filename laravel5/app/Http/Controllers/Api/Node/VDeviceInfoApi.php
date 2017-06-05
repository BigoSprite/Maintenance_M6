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
class VDeviceInfoApi extends Api
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
     * @return object
     */
    public static function create()
    {
        /** CREATE_FUNC like Cocos2d-x's CREATE_FUNC */
        /** Don't forget to CHANGE the parameters of CREATE_FUNC! */
        return ApiInstanceFactory::CREATE_FUNC(
            'VDeviceInfoApi',
            __NAMESPACE__,
            'VDeviceInfoRepository',
            'App\Repositories\NodeRepository'
        );
    }

    /**
     * 功能：判断$gprsID对应的设备是否存在
     * @param $gprsId
     * @return array
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
     * 功能：获取$gprsId对应的设备信息
     * @param $gprsId
     * @return array
     */
    public function getDeviceInfo($gprsId)
    {
        $arrMap = $this->repositoryMgr->findBy('gprsID', $gprsId);
        $retArray = array();
        if(count($arrMap) > 0){
            $retArray = [
                "gprsID"=> $arrMap['gprsID'],
                "deviceName"=>$arrMap['deviceName'],
                "deviceTypeName"=>$arrMap['deviceTypeName'],
                "deviceRemark"=>$arrMap['deviceRemark'],
                "monitoredUnitName"=>$arrMap['monitoredUnitName'],
                "realestateinfo_dbName"=>$arrMap['realestateinfo_dbName'],
                "protocolVersion"=>$arrMap['protocolVersion'],
                "protocolRemark"=>$arrMap['protocolRemark'],
                "contactPersonName"=>$arrMap['contactPersonName'],
                "contactTel"=>$arrMap['contactTel'],
                "deviceDetailInfo"=>$arrMap['deviceDetailInfo'],
//                "parseJSON"=>$arrMap['parseJSON'],
                "isDiscarded"=>$arrMap['isDiscarded'],
                "addDate"=> $arrMap['addDate'],
            ];
        }

        return ["data"=>$retArray];
    }

    /**
     * 功能：获取全部设备的信息
     * @return array
     */
    public function getDeviceInfoList()
    {
        $deviceModelList = $this->repositoryMgr->all();

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

        return ["data"=>$retArray];
    }

    /**
     * 功能：注册设备
     * @param $data
     * @param $primaryKey
     * @param $value
     * @return array
     */
    public function registerDeviceInfo($data, $primaryKey, $value)
    {
        return $this->repositoryMgr->create_Ex($data, $primaryKey, $value);
    }

    /**
     * 功能：更新设备
     * @param $data
     * @param $primaryKey
     * @param $value
     * @return array
     */
    public function updateDeviceInfo($data, $primaryKey, $value)
    {
        return $this->repositoryMgr->update_Ex($data, $primaryKey, $value);
    }


    /**
     * 功能：返回对象数组
     *
     * @param $gprsId
     * @return array
     *["data"=>
     * [
     *    (
            "alias":"var00",
            "name_en":"AVoltage",
            "name_ch":"A相电压",
            "data_type":"short",
            "byte_seq":"BE",
            "scale":"0.1",
            "unit":"V",
            "width":"90"
          ),// one object
     *    ...
     * ]
     *]
     *
     */
    public function getParseJSON($gprsId)
    {
        $parseJSONArrMap = $this->repositoryMgr->findBy('gprsID', $gprsId, ['parseJSON']);

        $objArray = array();
        if(count($parseJSONArrMap) > 0){
            $obj = json_decode("{$parseJSONArrMap['parseJSON']}");
            $objArray = $obj->data;
        }

        return ['data'=>$objArray];
    }

}
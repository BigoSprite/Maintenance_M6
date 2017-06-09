<?php

/**
 * This file is created by hanzhiwei using _example_template_XXXApi.php
 *
 * @Copyright
 *      @user: hanzhiwei
 *      @Email: bigosprite@163.com
 *      @GitHub: https://github.com/BigoSprite
 */

namespace App\Api\Client;

use App\Api\Contracts\Api;
use App\Repositories\Eloquent\AbstractRepository;
use App\Api\Utils\ApiInstanceFactory;

/** MAKE SURE that yourApi class extents Api in order to use the (REPOSITORY MANAGER) */
class AssetInfoApi extends Api
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
     * @param $runtimeDatabaseName
     * @return object
     */
    public static function create(string $runtimeDatabaseName = "")
    {
        /** Don't forget to configure model's connection, if you wanna change database at runtime! */
        parent::configureConnection($runtimeDatabaseName);

        /** CREATE_FUNC like Cocos2d-x's CREATE_FUNC */
        /** Don't forget to CHANGE the parameters of CREATE_FUNC! */
        /** @NOTE 魔术常量__NAMESPACE__表示的当前命名空间 */
        return ApiInstanceFactory::CREATE_FUNC(
            'AssetInfoApi',
            __NAMESPACE__,
            'AssetInfoRepository',
            'App\Repositories\ClientRepository'
        );
    }

    /**
     * 功能：获得所有资产
     * @param $dbName
     * @return array
     */
    public function getAssetInfoList($dbName)
    {
        // 1. 获取外键distributionRoomInfo_serialId对应的配电室的中文名字
        $dataMap = DistributionRoomInfoApi::create($dbName)->getRoomNameListWithSerialId();
        $arr = $dataMap['data'];

        $serialId_name_map = array();
        foreach ($arr as $item) {
            $serialId = $item['serialId'];
            $roomName = $item['name'];
            $serialId_name_map[$serialId] = $roomName;
        }

        // 2. serialId和中文名字的映射操作
        $modelArray = $this->repositoryMgr->all();
        $data = array();
        foreach ($modelArray as $item) {

            $serialIdOfRoom = $item->distributionRoomInfo_serialId;
            $name_ch = '';
            if(array_key_exists($serialIdOfRoom, $serialId_name_map)){
                $name_ch = $serialId_name_map[$serialIdOfRoom];
            }

            $tmp = [
                'distributionRoomInfo_serialId' => $serialIdOfRoom,
                'distributionRoomName'=>$name_ch,
                'name' => $item->name,
                'type'=>$item->type,
                'unit'=>$item->unit,
                'amount'=>(string)$item->amount,
                'addDate'=>$item->addDate
            ];
            $data[] = $tmp;
        }
        return ['data'=>$data];
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
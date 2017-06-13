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
class DistributionRoomInfoApi extends Api
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
     * @param string $runtimeDatabaseName
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
            'DistributionRoomInfoApi',
            __NAMESPACE__,
            'DistributionRoomInfoRepository',
            'App\Repositories\ClientRepository'
        );
    }

    /**
     * 功能：判断$serialId对应的数据对象是否存在
     * @param $serialId
     * @return array
     */
    public function isRoomExist($serialId)
    {
        $ret = [
            'isExist'=>'false'
        ];

        $isExist = $this->repositoryMgr->isFieldExist('serialId', $serialId);

        if($isExist){
            $ret['isExist'] = 'true';
        }

        return $ret;
    }


    /**
     * 功能：判断$roomName对应的数据对象是否存在
     * @param $roomName
     * @return array
     */
    public function isRoomExist_Ex($roomName)
    {
        $ret = [
            'isExist'=>'false'
        ];

        $isExist = $this->repositoryMgr->isFieldExist('roomName', $roomName);

        if($isExist){
            $ret['isExist'] = 'true';
        }

        return $ret;
    }


    /**
 * 功能：从distribution_Room_info表中获得“某序列号”对应的一行（配电室的所有属性）
 * @param $serialId
 * @return array
 */
    public function getRoomInfo($serialId)
    {
        $arrMap = $this->repositoryMgr->findBy('serialId', $serialId);
        $roomInfo = array();
        if($arrMap != null) {
            $roomInfo = [
                'serialId' => $arrMap['serialId'],
                'roomName' => $arrMap['roomName'],
                'description' => $arrMap['description'],
                'address' => $arrMap['address'],
                'contactPerson' => $arrMap['contactPerson'],
                'contactTel' => $arrMap['contactTel'],
                'registerDate' => (string)$arrMap['registerDate']
            ];
        }

        return ['data'=>$roomInfo];
    }

    /**
     * 功能：从distribution_Room_info表中获得$roomName对应的一行（配电室的所有属性）
     * @param $roomName
     * @return array
     */
    public function getRoomInfo_Ex($roomName)
    {
        $arrMap = $this->repositoryMgr->findBy('roomName', $roomName);
        $roomInfo = array();
        if($arrMap != null) {
            $roomInfo = [
                'serialId' => $arrMap['serialId'],
                'roomName' => $arrMap['roomName'],
                'description' => $arrMap['description'],
                'address' => $arrMap['address'],
                'contactPerson' => $arrMap['contactPerson'],
                'contactTel' => $arrMap['contactTel'],
                'registerDate' => (string)$arrMap['registerDate']
            ];
        }

        return ['data'=>$roomInfo];
    }

    /**
     * 功能：从从distribution_Room_info表中获得所有配电室信息
     * @return array
     */
    public function getRoomInfoList()
    {
        $roomInfoArr= $this->repositoryMgr->all();
        $data= array();
        if(count($roomInfoArr) > 0) {
            foreach ($roomInfoArr as $item) {
                $tmp = [
                    'serialId' => $item->serialId,
                    'roomName' => $item->roomName,
                    'description' => $item->description,
                    'address' => $item->address,
                    'contactPerson' => $item->contactPerson,
                    'contactTel' => $item->contactTel,
                    'registerDate' => (string)$item->registerDate
                ];
                $data[] = $tmp;
            }
        }

        return ['data'=>$data];
    }

    /**
     * 功能：获得所有配电室名字及其序列号
     * @return array
     */
    public function getRoomNameListWithSerialId()
    {
//        $roomArray = DB::select('SELECT serialId, roomName FROM distributionRoom');
        $roomArray = $this->repositoryMgr->all(['serialId', 'roomName']);

        $retArray = array();
        if(count($roomArray) > 0){
            foreach ($roomArray as $item) {
                $serialId = $item->serialId;
                $roomName = $item->roomName;
                $tmpArray = [
                    "name"=> $roomName,
                    "serialId"=>$serialId
                ];

                $retArray[] = $tmpArray;
            }
        }

        return ["data"=>$retArray];
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
<?php

/**
 * This file is created by hanzhiwei using _example_template_XXXApi.php
 *
 * @Copyright
 *      @user: hanzhiwei
 *      @Email: bigosprite@163.com
 *      @GitHub: https://github.com/BigoSprite
 */

namespace App\Api\Node;
use App\Api\Contracts\Api;
use App\Repositories\Eloquent\AbstractRepository;
use App\Api\Utils\ApiInstanceFactory;

/** MAKE SURE that yourApi class extents Api in order to use the (REPOSITORY MANAGER) */
class VDeviceStatusApi extends Api
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
        return ApiInstanceFactory::CREATE_FUNC(
            'VDeviceStatusApi',
            __NAMESPACE__,
            'VDeviceStatusRepository',
            'App\Repositories\NodeRepository'
        );
    }


    /**
     * 功能：判断XXX对应的数据对象是否存在
     * @param $gprsId
     * @return array
     *
     * @NOTE Don't forget to CHANGE XXX to the right attribute——total four locations needed!
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
     * 功能：获取特定grsID的设备的状态
     * @param $gprsID
     * @return array
     */
    public function getDeviceStatus($gprsID)
    {
        $arrMap = $this->repositoryMgr->findBy('gprsID', $gprsID);
        $retArray = array();
        if(count($arrMap) > 0){
            $retArray = [
                'gprsID' => $arrMap['gprsID'],
                'isLogin' => $arrMap['isLogin'],
                'lastLoginTime' => $arrMap['lastLoginTime'],
                'alarmFlag' => $arrMap['alarmFlag'],
                'alarmUpdateTime' => $arrMap['alarmUpdateTime'],
                'isOperating' => (string)$arrMap['isOperating'],
                'operationDesc' => $arrMap['operationDesc'],
                'operationUpdateTime' => (string)$arrMap['operationUpdateTime'],
            ];
        }

        return ["data"=>$retArray];
    }

    /**
     * 功能：获取全部设备的状态
     * @return array
     */
    public function getDeviceStatusList()
    {
        $statusModelArray = $this->repositoryMgr->all();
        $resultArray = array();
        if(count($statusModelArray) > 0) {
            foreach ($statusModelArray as $item) {
                $tmpArray = [
                    'gprsID' => $item->gprsID,
                    'isLogin' => $item->isLogin,
                    'lastLoginTime' => (string)$item->lastLoginTime,
                    'alarmFlag' => (string)$item->alarmFlag,
                    'alarmUpdateTime' => (string)$item->alarmUpdateTime,
                    'isOperating' => (string)$item->isOperating,
                    'operationDesc' => $item->operationDesc,
                    'operationUpdateTime' => (string)$item->operationUpdateTime
                ];

                $resultArray[] = $tmpArray;
            }
        }
        return ['data'=>$resultArray];
    }


    /**
     * 功能：注册设备状态
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
     * 功能：更新设备状态
     * @param $data
     * @param $primaryKey
     * @param $value
     * @return mixed
     */
    public function update($data, $primaryKey, $value)
    {
        return $this->repositoryMgr->update_Ex($data, $primaryKey, $value);
    }

}